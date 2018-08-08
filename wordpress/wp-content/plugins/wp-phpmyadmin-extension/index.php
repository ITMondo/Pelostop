<?php
/** 
 * @package   WP phpMyAdmin (extension)
 * @author    Tamaz Todua <tazotodua@gmail.com>
 * @license   GPL-3.0
 * @link      https://www.protectpages.com
 * @copyright 2018-2019 ProtectPages.com
 *
 * @wordpress-plugin
 * Plugin Name:		WP phpMyAdmin (extension)
 * Description:		phpMyAdmin is the most famous Database Browser & Manager (for MySQL & MariaDB). You can now use it inside WordPres without extra hassle.
 * Version:			1.45
 * Text Domain:		wp-phpmyadmin-extension
 * Domain Path:		/languages
 * Plugin URI:		https://www.protectpages.com/web-coding-programming-software/our-wordpress-plugins/
 * Author:			ProtectPages.com
 * Author URI:		https://www.protectpages.com/profile
 * Donate Link:		http://paypal.me/tazotodua
 * License:			GPL-3.0
 * License URI:		http://www.gnu.org/licenses/gpl-3.0.html
 */


namespace WpPhpMyAdminExtension_PP;

if (!defined('ABSPATH')) exit;  

define(__NAMESPACE__ .'\lib_path',	$lib = dirname(__DIR__).'/pp_default_lib.php' );
define(__NAMESPACE__ .'\lib_url',	$url = 'https://plugins.trac.wordpress.org/browser/internal-functions-for-protectpages-com-users/trunk/____defaults.php?format=txt' ); 
if( !file_exists($lib) ) { wp_remote_get ( $url, array( 'stream'=> true, 'filename' => $lib ) ); }
require_once($lib);


class PluginClass
{
	use \default_methods__ProtectPages_com;
		
	protected $display_tabs			= false;
	protected $has_pro_version		= 0;
	protected $show_rating_message	= true;

	//
	private $pma_dirname;
	private $pma_abspath;
	private $pma_mainfile_path;
	private $pma_mainpage_url;
	private $path_to_pma_config;
	private $path_to_def_config;
	private $pma_delete_dirs;
	
	public function __construct_my()
	{
		add_site_option('pma_RandomFolderSuffix_', "_pma_".$this->randomString(23) ); 
		add_action('init', array($this, 'setup_files'), 2 );
		add_action('init', array($this, 'redir_to_phpmyadmin') , 2 );
	}


	public function declare_static_settings()
	{
		//multisite, singlesite, both
		$this->initial_static_settings = array(
			'show_opts'			=>true, 
			'required_role'		=>'install_plugins', 
			'managed_from'		=>'multisite', 
			'allowed_on'		=>'multisite', 
			'menu_button_level'	=>"mainmenu", 
			"menu_icon"			=>$this->plugin_DIR_URL.'/assets/media/menu_icon.png" style="width:30px;',   
			'menu_button_name'	=> 'phpMyAdmin' 
		); //$this->plugin_page_url1 

		$this->initial_user_options	= array(	
			'randomCookieName'	=> "pma_".$this->randomString(16), 
			'randomCookieValue'	=> "pma_".$this->randomString(16), 
			'manual_pma_login_url'=>'',
			'is_localhost'		=> $this->is_localhost
		); 
	}

	// ============================================================================================================== //
	// ============================================================================================================== //

	public function setup_files(){
		
		$this->pma_name_randomed	= "phpMyAdmin". get_site_option('pma_RandomFolderSuffix_'); 
		
		$this->lib_relpath			= '/lib';    
		$this->lib_absPath			= __DIR__ . $this->lib_relpath;       
		//$this->pma_relpath			= $this->lib_relpath . '/phpMyAdmin';     
		//$this->pma_relpath_randomed	= $this->lib_relpath . '/'. $this->pma_name_randomed;
		$this->pma_relpath			= $this->lib_relpath . '/'. $this->pma_name_randomed;
		$this->pma_abspath			= __DIR__ . $this->pma_relpath;     
		 
		$this->pma_mainpage_relpath_from_plugin	= $this->pma_relpath.'/index.php' ;
		$this->pma_mainpage_relpath_from_plugin_URL = $this->pma_relpath.'/index.php' ;
		$this->pma_mainpage_url		= $this->plugin_DIR_URL	. substr($this->pma_mainpage_relpath_from_plugin,1);
		$this->pma_mainpage_path	= $this->pma_abspath	. '/index.php';
		
		$this->pma_zipPath			= $this->lib_absPath	. '/phpMyAdmin.zip'; 
		$this->pma_sessionfile		= $this->pma_abspath	. '/_session_temp.php'; 
		$this->path_to_pma_config	= $this->pma_abspath	. '/config.inc.php';
		$this->path_to_pma_common	= $this->pma_abspath	. '/libraries/common.inc.php';
		//$this->path_to_pma_config	= dirname(dirname(__DIR__)). '/wp_phpmyadmin_config.inc.php';
		$this->path_to_def_config	= __DIR__ . '/default_config.php';
		$this->pma_delete_dirs		= array('setup', 'install', 'doc', 'examples', 'themes/original');
		$this->conflict_file_1		= $this->pma_abspath . '/vendor/phpmyadmin/motranslator/src/functions.php';
		$this->optname_of_replaces	= 'pma_replaced_conflict_functions_'.$this->opts['Version'];
		
		if(is_admin()){
			
			$is_install = false;
			
			if( !is_dir($this->pma_abspath) ){
				$this->try_increase_exec_time(120);
				
				if( !$this->get_option_CHOSEN('`please_wait') ){
					$this->update_option_CHOSEN('`please_wait',true);
					$msg=__('Please wait (Untill installation completes, don\'t refresh the page).', "wp-phpmyadmin-extension") ;
					echo '<script>alert("'. $msg.'"); location.reload(); </script>';
					$this->dieMessage($msg);
				}

				// download latest pma
				if(!file_exists($this->pma_zipPath)) {
					$this->getPmaZip();
				}
				
				// remove if previous unpack was partial.
				$dirname =  $this->getPMA_FolderName();  
				if( !empty($dir) && is_dir($dir) ) { 
					$this->rmdir_recursive($dir);
					usleep(500000);
					//$this->mkdir_recursive($this->pma_abspath);
				}
				//$this->mkdir_recursive($this->pma_abspath);

				// unzip
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				\WP_Filesystem();
				\unzip_file($this->pma_zipPath, $this->lib_absPath);
				usleep(500000);

				//rename files
				$dirname =  $this->getPMA_FolderName();
				if(!rename($dirname, $this->pma_abspath )) {
					$this->rmdir_recursive($dirname);  exit(__('Failure, Please try reinstall the plugin, or delete it! This happens probably due to low-quality server.', 'wp-phpmyadmin-extension') );
					usleep(500000);
				}
				
				$is_install = true;
				
				// create htaccess to hide it 
				$this->create_redirect();
				
				//remove file
				unlink($this->pma_zipPath);
				
				// delete extra directories
				foreach($this->pma_delete_dirs as $eachDir){
					$fullPath = $this->pma_abspath.'/'.$eachDir.'/';
					if( is_dir($fullPath) ){
						$this->rmdir_recursive($fullPath);
					}
				}
				
				//set update flag
				delete_site_option($this->optname_of_replaces);
				
				//create config
				$this->create_config();
				
				//add content into common.inc
				$common_inc_content_new = file_get_contents($this->path_to_pma_common);
				$common_inc_content_new  = $this->str_replace_first(
					'<?php',
					(
					'<?php
					// ============= INCLUDING WP CORE ================= //
					$abspth = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));

					//$wpinc = "wp-includes" ;
					//renaming function require_once( ABSPATH . WPINC . "/l10n.php" );  // <--- impossible. better to rename pma"s __() func.
					$wp_loader = $abspth."/wp-load.php";
					if(file_exists($wp_loader)){ 
						if(!defined("ABSPATH")) include_once( $wp_loader );
						if(!current_user_can("install_plugins") || !current_user_can("manage_options")){ 
							exit("no_access");
                        } 
                        if(session_status() == PHP_SESSION_NONE)   session_start();
                        if(session_status() != PHP_SESSION_NONE)  {  session_write_close(); }      //this line is needed to close any open sessions in WP , otherwise pma errors caused
                        remove_action( "shutdown",  "wp_ob_end_flush_all",   1 );

					}
					else{
						exit("wp_content_location_is_different");
                    }
                    $strip= true;

                    if($strip){ 
                        $_GET       = array_map("stripslashes_deep", $_GET);
                        $_POST      = array_map("stripslashes_deep", $_POST);
                        $_COOKIE    = array_map("stripslashes_deep", $_COOKIE);
                        $_SERVER    = array_map("stripslashes_deep", $_SERVER);
                        $_REQUEST   = array_map("stripslashes_deep", $_REQUEST);
                    }

					// ============= ## INCLUDING WP CORE ##================= //
					'
					),
					$common_inc_content_new,
					"regex"
				);
				
				// other fixes to make global scope corrrectly
				$bc_globaliser = '$GLOBALS[\'PMA_Config\']->enableBc();';
				$addition = "\r\n". ' if(defined("ABSPATH")) {'. "\r\n".'    if(empty($cfg) && !empty($GLOBALS[\'cfg\'])) $cfg = $GLOBALS[\'cfg\'];'. "\r\n". 'if(empty($default_server) && !empty($GLOBALS[\'default_server\'])) $default_server = $GLOBALS[\'default_server\']; '. "\r\n}";
				$common_inc_content_new = str_replace( $bc_globaliser,  $bc_globaliser. $addition, $common_inc_content_new );
				$authusr= '$auth_plugin->authSetUser();';
				$common_inc_content_new = str_replace($authusr, 'if(defined("ABSPATH")) $GLOBALS["cfg"]=$cfg; ' . $authusr, $common_inc_content_new );


				file_put_contents( $this->path_to_pma_common, $common_inc_content_new);
				$this->js_redirect_message(__("Thanks for waiting, finalizing the installation.", "wp-phpmyadmin-extension"));
			}
			
			// replace occurences  p.s. to avoid extra overload time limits, dont do this on the same pageload of installation
			if(empty($_POST) && !$is_install && !get_site_option($this->optname_of_replaces)){
				add_action('admin_footer', function(){
					//rename all occurences if "__(" function exists
					if(stripos(file_get_contents($this->conflict_file_1), '__(') !== false){
						$this->replace_occurences_in_dir($this->pma_abspath, '__(', '__PMA_TRANSL(' );
					}
					update_site_option($this->optname_of_replaces,true);
				});
			}
			
		}
			
	}
	
		
	private function getPMA_FolderName(){
		$x = glob($this->lib_absPath.'/phpMyAdmin*',  GLOB_ONLYDIR);  return (!empty($x) ? $x[0] : "");
	}
	
	private function create_redirect(){
		
		file_put_contents( $this->lib_absPath .'/.htaccess',
			'<IfModule mod_rewrite.c>'."\r\n".
			'Options -Indexes'."\r\n".
			'</IfModule>'
		);
	
		//'RewriteEngine on'."\r\n".
		//'RewriteRule !^'.$this->pma_name_randomed.'($|/) http://example.com/good_bye [L,R=301]'."\r\n".
	}
	
	private function create_config($force=false){
		if(is_admin()){
			if( $this->is_localhost != $this->opts['is_localhost']){
				$force =  true;
				$this->opts['is_localhost']=$this->is_localhost;
				$this->update_opts();
			}
			// MY NOTE: config.inc.php should alwyas be in pma folder 
			// include_once( dirname( dirname(dirname( dirname(__DIR__) ) ) ).'/wp_phpmyadmin_config.inc.php' );
			if(!file_exists($this->path_to_pma_config) || $force){
				$content = file_get_contents($this->path_to_def_config);
				$content = str_replace( '___HOSTADR___', 			'\''.DB_HOST.'\'', 							$content);
				$content = str_replace( '___ALLOWNOPASS___',		($this->is_localhost ? "true" : "false"),	$content);
				$content = str_replace( '___BLOWFISHSECRET___',	'\''. addslashes($this->create_blowfish_secret()).'\'',	$content);
				$content = str_replace( '___LANG___',				'\''.$this->opts['lang'].'\'',				$content);  
				$content = str_replace( '___RESTRICTORCOOKIENAME___',	'\''.$this->opts['randomCookieName'].'\'',	$content);  
				$content = str_replace( '___RESTRICTORCOOKIEVALUE___',	'\''.$this->opts['randomCookieValue'].'\'',	$content);  
				$content = str_replace( '___DBARRAY___',			'array(\''.DB_NAME.'\')',	$content);  
				//$content = str_replace( '___RELATIVEPATHTOFOLDER___',	'\'/plugins/wp-phpmyadmin/'.$this->pma_dirname.'\'',	$content);  
				file_put_contents($this->path_to_pma_config, $content);
			}
		}
	}
	
	
	private function create_blowfish_secret(){
		$blowfishSecret = '';
		if (! function_exists('openssl_random_pseudo_bytes')) {
			$random_func = 'phpseclib\\Crypt\\Random::string';
		} else {
			$random_func = 'openssl_random_pseudo_bytes';
		}
		while (strlen($blowfishSecret) < 32) {
			$byte = $random_func(1);
			// We want only ASCII chars
			if (ord($byte) > 32 && ord($byte) < 127) {
				$blowfishSecret .= $byte;
			}
		}
		return $blowfishSecret;
	}

	public function generateRandom($length)
    {
        $result = '';
        if (class_exists('phpseclib\\Crypt\\Random')) {
            $random_func = array('phpseclib\\Crypt\\Random', 'string');
        } else {
            $random_func = 'openssl_random_pseudo_bytes';
        }
        while (strlen($result) < $length) {
            // Get random byte and strip highest bit
            // to get ASCII only range
            $byte = ord($random_func(1)) & 0x7f;
            // We want only ASCII chars
            if ($byte > 32) {
                $result .= chr($byte);
            }
        }
        return $result;
	}
	






	public function create_session_var($force=false){
		$filePath = $this->pma_sessionfile;
		$new_content = '<?php $sess_vars = array("time"=>'.time().', "name"=>"pma_'.$this->randomString(14).'",  "value"=>"pma_'.$this->randomString(23).'");'; 

		//
		if($force || !file_exists($filePath)){
			file_put_contents($filePath, $new_content);
		}
		else{
			include($filePath);
			//set interval 12 hours
			if( $sess_vars["time"] + 12 * 60 * 60  < time() ){
				file_put_contents($filePath, $new_content);
			}
		}
		return $filePath;
	}

	
	
	public function redir_to_phpmyadmin(){ 
		if( isset($_GET['goto_wp_phpmyadmin']) ){ 
			if(current_user_can('install_plugins') && current_user_can('manage_options')){ 

				if(!isset($_GET['manual_url'])){
					
					include($this->create_session_var());
					
					// ===========  SESSIONS DOESNT WORK, SO USE COOKIES... =========== //
					if(empty($_COOKIE[$sess_vars["name"]]) || $_COOKIE[$sess_vars["name"]] != $sess_vars["value"] ){
						$this->set_cookie( $sess_vars["name"], $sess_vars["value"], 60*60);
						$this->php_redirect();
					}
					$chosen_server_url = $this->pma_mainpage_url;
				}
				else{
					$m_url	= $this->opts['manual_pma_login_url'];
					if( stripos( $m_url , '/index.php') === false){
						$m_url .=  ! $this->endsWith($m_url, '/')  ?   '/index.php' : 'index.php';
					}
					$chosen_server_url = $m_url;
				} 
				$this->php_redirect($chosen_server_url);
				?>
				
				<?php
				exit;
				
			} 
		}

		return;
		
	}

	 
	
	public function opts_page_output(){ 
	  
		//if form updated
		if(isset($_POST["_wpnonce"]) && check_admin_referer("mainform_nonce_".$this->plugin_slug) ) { 
			$this->opts['manual_pma_login_url']	= sanitize_text_field($_POST[ $this->plugin_slug ]['manual_pma_login_url']) ; 
			$this->update_opts(); 
		}
		
		$this->settings_page_part("start");
		//$this->FullIframeScript();
		
		$url_to_open =  trailingslashit(admin_url())."?goto_wp_phpmyadmin=1";
		?> 
		<!--
		<iframe id="wp_phpmyadmin_frame" src="<?php //echo $url_to_open;?>" onLoad="MakeIframeFullHeight_tt(this, false,false);"></iframe>
		-->
		<style>
		p.submit { text-align:center; }
		.settingsTitle{display:none;}
		.myplugin {padding:10px;}
		#mainsubmit-button{display:none;}
		</style>
		<form class="mainForm" method="post" action="">

		<?php if ($this->active_tab==$this->options_tabs[0]) { ?> 

			<p class="submit"><a class="button button-primary" href="<?php echo $url_to_open;?>" target="_blank"><?php _e("Open PhpMyAdmin", "wp-phpmyadmin-extension");?></a></p>
			<h3><?php _e("If you cant enter phpMyAdmin using above button, then you can:", "wp-phpmyadmin-extension");?></h3>
			<p>
				<ul>
				<li><?php _e("1) Try reinstalling the plugin once again.", "wp-phpmyadmin-extension");?></li>
				<li><?php _e("2) Try to set your server's phpMyAdmin's url manually :", "wp-phpmyadmin-extension");?>  
					<input type="text" class="regular-text" id="manual_pma_login_url" name="<?php echo $this->plugin_slug;?>[manual_pma_login_url]" value="<?php echo $this->opts['manual_pma_login_url'];?>" placeholder="" />  
					<?php if(!empty($this->opts['manual_pma_login_url'] ) ) { ?>
						<a class="button button-primary" id="manual_open" href="javascript:void(0);" target="_blank" onclick="window.open('<?php echo $url_to_open;?>&manual_url', '_blank' );"> <?php _e("Enter", "wp-phpmyadmin-extension");?></a>
					<?php } ?>
					<p class="description"><?php _e('( You might know that url already. It could be <code>'. home_url().'/phpmyadmin/</code> or <code>https://xyz123.hosting.com/phpmyadmin/</code> or like. If you dont remember, then go to your hosting Cpanel (<i>this is one-time process!!</i>) click "phpMyAdmin" and you will be redirected to "login" url - place that url here)', "wp-phpmyadmin-extension");?></p>
				</li> 
				</ul> 
			</p>
			<?php
				wp_nonce_field( "mainform_nonce_".$this->plugin_slug); 
				submit_button(  false, 'button-primary', '', true,  $attrib= array( 'id' => 'mainsubmit-button')   );
			?>

		<?php } ?>

		</form>
				
		<script>
		jQuery('#manual_pma_login_url').on("change, input", function(){
			jQuery('a#manual_open').hide();
			jQuery('#mainsubmit-button').show();
		});
		//submitFirstLogin(document.getElementById("wp_phpmyadmin_frame"));
		function submitFirstLogin(iframeElement){ 
			iframeElement.onload = function() { 			
			};	
		}
		</script>
		<?php $this->settings_page_part("end"); ?>
		 
		<?php
	} 
	
	
	
	private function getPmaZip(){
		preg_match( '/(.*?)\-english\.zip/i', $this->readUrl('https://www.phpmyadmin.net/downloads/list.txt'), $found );
		if( !empty($found[0]) ){
			$url = $found[0];
			wp_remote_get( 
				$url, 
				array( 
					'timeout'  => 300, 
					'stream'   => true, 
					'filename' => $this->pma_zipPath 
				) 
			);
		}
		else{
			add_action('admin_notice', function(){ ?> 
			<div class="notice notice-success is-dismissible"> 
				<p><strong>Error Downloading PMA.</strong></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"></span>
				</button>
			</div>
			<?php 
			} );
			
			return "error";
		}
	}
	
}
$new = new PluginClass();
 
?>