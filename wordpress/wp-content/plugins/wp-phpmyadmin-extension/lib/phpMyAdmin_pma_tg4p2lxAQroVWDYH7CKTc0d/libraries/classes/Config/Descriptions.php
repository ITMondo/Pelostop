<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Verbose descriptions for settings.
 *
 * @package PhpMyAdmin
 */
namespace PhpMyAdmin\Config;

use PhpMyAdmin\Sanitize;

/**
 * Base class for forms, loads default configuration options, checks allowed
 * values etc.
 *
 * @package PhpMyAdmin
 */
class Descriptions
{
    /**
     * Return
     * Return name or description for a configuration path.
     *
     * @param string $path Path of configuration
     * @param string $type Type of message, either 'name', 'cmt' or 'desc'
     *
     * @return string
     */
    public static function get($path, $type = 'name')
    {
        $key = str_replace(
            array('Servers/1/', '/'),
            array('Servers/', '_'),
            $path
        );
        $value = self::getString($key, $type);

        /* Fallback to path for name and empty string for description and comment */
        if (is_null($value)) {
            if ($type == 'name') {
                $value = $path;
            } else {
                $value = '';
            }
        }

        return Sanitize::sanitize($value);
    }

    /**
     * Return name or description for a cleaned up configuration path.
     *
     * @param string $path Path of configuration
     * @param string $type Type of message, either 'name', 'cmt' or 'desc'
     *
     * @return string|null Null if not found
     */
    public static function getString($path, $type = 'name')
    {
        switch ($path . '_' . $type) {
            case 'AllowArbitraryServer_desc':
                return __PMA_TRANSL('If enabled, user can enter any MySQL server in login form for cookie auth.');
            case 'AllowArbitraryServer_name':
                return __PMA_TRANSL('Allow login to any MySQL server');
            case 'ArbitraryServerRegexp_desc':
                return __PMA_TRANSL(
                    'Restricts the MySQL servers the user can enter when a login to an arbitrary '
                    . 'MySQL server is enabled by matching the IP or hostname of the MySQL server ' .
                    'to the given regular expression.'
                );
            case 'ArbitraryServerRegexp_name':
                return __PMA_TRANSL('Restrict login to MySQL server');
            case 'AllowThirdPartyFraming_desc':
                return __PMA_TRANSL(
                    'Enabling this allows a page located on a different domain to call phpMyAdmin '
                    . 'inside a frame, and is a potential [strong]security hole[/strong] allowing '
                    . 'cross-frame scripting (XSS) attacks.'
                );
            case 'AllowThirdPartyFraming_name':
                return __PMA_TRANSL('Allow third party framing');
            case 'AllowUserDropDatabase_name':
                return __PMA_TRANSL('Show "Drop database" link to normal users');
            case 'blowfish_secret_desc':
                return __PMA_TRANSL(
                    'Secret passphrase used for encrypting cookies in [kbd]cookie[/kbd] '
                    . 'authentication.'
                );
            case 'blowfish_secret_name':
                return __PMA_TRANSL('Blowfish secret');
            case 'BrowseMarkerEnable_desc':
                return __PMA_TRANSL('Highlight selected rows.');
            case 'BrowseMarkerEnable_name':
                return __PMA_TRANSL('Row marker');
            case 'BrowsePointerEnable_desc':
                return __PMA_TRANSL('Highlight row pointed by the mouse cursor.');
            case 'BrowsePointerEnable_name':
                return __PMA_TRANSL('Highlight pointer');
            case 'BZipDump_desc':
                return __PMA_TRANSL(
                    'Enable bzip2 compression for'
                    . ' import operations.'
                );
            case 'BZipDump_name':
                return __PMA_TRANSL('Bzip2');
            case 'CharEditing_desc':
                return __PMA_TRANSL(
                    'Defines which type of editing controls should be used for CHAR and VARCHAR '
                    . 'columns; [kbd]input[/kbd] - allows limiting of input length, '
                    . '[kbd]textarea[/kbd] - allows newlines in columns.'
                );
            case 'CharEditing_name':
                return __PMA_TRANSL('CHAR columns editing');
            case 'CodemirrorEnable_desc':
                return __PMA_TRANSL(
                    'Use user-friendly editor for editing SQL queries '
                    . '(CodeMirror) with syntax highlighting and '
                    . 'line numbers.'
                );
            case 'CodemirrorEnable_name':
                return __PMA_TRANSL('Enable CodeMirror');
            case 'LintEnable_desc':
                return __PMA_TRANSL(
                    'Find any errors in the query before executing it.'
                    . ' Requires CodeMirror to be enabled.'
                );
            case 'LintEnable_name':
                return __PMA_TRANSL('Enable linter');
            case 'MinSizeForInputField_desc':
                return __PMA_TRANSL(
                    'Defines the minimum size for input fields generated for CHAR and VARCHAR '
                    . 'columns.'
                );
            case 'MinSizeForInputField_name':
                return __PMA_TRANSL('Minimum size for input field');
            case 'MaxSizeForInputField_desc':
                return __PMA_TRANSL(
                    'Defines the maximum size for input fields generated for CHAR and VARCHAR '
                    . 'columns.'
                );
            case 'MaxSizeForInputField_name':
                return __PMA_TRANSL('Maximum size for input field');
            case 'CharTextareaCols_desc':
                return __PMA_TRANSL('Number of columns for CHAR/VARCHAR textareas.');
            case 'CharTextareaCols_name':
                return __PMA_TRANSL('CHAR textarea columns');
            case 'CharTextareaRows_desc':
                return __PMA_TRANSL('Number of rows for CHAR/VARCHAR textareas.');
            case 'CharTextareaRows_name':
                return __PMA_TRANSL('CHAR textarea rows');
            case 'CheckConfigurationPermissions_name':
                return __PMA_TRANSL('Check config file permissions');
            case 'CompressOnFly_desc':
                return __PMA_TRANSL(
                    'Compress gzip exports on the fly without the need for much memory; if '
                    . 'you encounter problems with created gzip files disable this feature.'
                );
            case 'CompressOnFly_name':
                return __PMA_TRANSL('Compress on the fly');
            case 'Confirm_desc':
                return __PMA_TRANSL(
                    'Whether a warning ("Are your really sure…") should be displayed '
                    . 'when you\'re about to lose data.'
                );
            case 'Confirm_name':
                return __PMA_TRANSL('Confirm DROP queries');
            case 'DBG_sql_desc':
                return __PMA_TRANSL('Log SQL queries and their execution time, to be displayed in the console');
            case 'DBG_sql_name':
                return __PMA_TRANSL('Debug SQL');
            case 'DefaultTabDatabase_desc':
                return __PMA_TRANSL('Tab that is displayed when entering a database.');
            case 'DefaultTabDatabase_name':
                return __PMA_TRANSL('Default database tab');
            case 'DefaultTabServer_desc':
                return __PMA_TRANSL('Tab that is displayed when entering a server.');
            case 'DefaultTabServer_name':
                return __PMA_TRANSL('Default server tab');
            case 'DefaultTabTable_desc':
                return __PMA_TRANSL('Tab that is displayed when entering a table.');
            case 'DefaultTabTable_name':
                return __PMA_TRANSL('Default table tab');
            case 'EnableAutocompleteForTablesAndColumns_desc':
                return __PMA_TRANSL('Autocomplete of the table and column names in the SQL queries.');
            case 'EnableAutocompleteForTablesAndColumns_name':
                return __PMA_TRANSL('Enable autocomplete for table and column names');
            case 'HideStructureActions_desc':
                return __PMA_TRANSL('Whether the table structure actions should be hidden.');
            case 'ShowColumnComments_name':
                return __PMA_TRANSL('Show column comments');
            case 'ShowColumnComments_desc':
                return __PMA_TRANSL('Whether column comments should be shown in table structure view');
            case 'HideStructureActions_name':
                return __PMA_TRANSL('Hide table structure actions');
            case 'DefaultTransformations_Hex_name':
                return __PMA_TRANSL('Default transformations for Hex');
            case 'DefaultTransformations_Hex_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_Substring_name':
                return __PMA_TRANSL('Default transformations for Substring');
            case 'DefaultTransformations_Substring_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_Bool2Text_name':
                return __PMA_TRANSL('Default transformations for Bool2Text');
            case 'DefaultTransformations_Bool2Text_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_External_name':
                return __PMA_TRANSL('Default transformations for External');
            case 'DefaultTransformations_External_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_PreApPend_name':
                return __PMA_TRANSL('Default transformations for PreApPend');
            case 'DefaultTransformations_PreApPend_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_DateFormat_name':
                return __PMA_TRANSL('Default transformations for DateFormat');
            case 'DefaultTransformations_DateFormat_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_Inline_name':
                return __PMA_TRANSL('Default transformations for Inline');
            case 'DefaultTransformations_Inline_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_TextImageLink_name':
                return __PMA_TRANSL('Default transformations for TextImageLink');
            case 'DefaultTransformations_TextImageLink_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');
            case 'DefaultTransformations_TextLink_name':
                return __PMA_TRANSL('Default transformations for TextLink');
            case 'DefaultTransformations_TextLink_desc':
                return __PMA_TRANSL('Values for options list for default transformations. These will be overwritten if transformation is filled in at table structure page.');

            case 'DisplayServersList_desc':
                return __PMA_TRANSL('Show server listing as a list instead of a drop down.');
            case 'DisplayServersList_name':
                return __PMA_TRANSL('Display servers as a list');
            case 'DisableMultiTableMaintenance_desc':
                return __PMA_TRANSL(
                    'Disable the table maintenance mass operations, like optimizing or repairing '
                    . 'the selected tables of a database.'
                );
            case 'DisableMultiTableMaintenance_name':
                return __PMA_TRANSL('Disable multi table maintenance');
            case 'ExecTimeLimit_desc':
                return __PMA_TRANSL(
                    'Set the number of seconds a script is allowed to run ([kbd]0[/kbd] for no '
                    . 'limit).'
                );
            case 'ExecTimeLimit_name':
                return __PMA_TRANSL('Maximum execution time');
            case 'Export_lock_tables_name':
                return sprintf(
                    __PMA_TRANSL('Use %s statement'), '<code>LOCK TABLES</code>'
                );
            case 'Export_asfile_name':
                return __PMA_TRANSL('Save as file');
            case 'Export_charset_name':
                return __PMA_TRANSL('Character set of the file');
            case 'Export_codegen_format_name':
                return __PMA_TRANSL('Format');
            case 'Export_compression_name':
                return __PMA_TRANSL('Compression');
            case 'Export_csv_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_csv_enclosed_name':
                return __PMA_TRANSL('Columns enclosed with');
            case 'Export_csv_escaped_name':
                return __PMA_TRANSL('Columns escaped with');
            case 'Export_csv_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_csv_removeCRLF_name':
                return __PMA_TRANSL('Remove CRLF characters within columns');
            case 'Export_csv_separator_name':
                return __PMA_TRANSL('Columns terminated with');
            case 'Export_csv_terminated_name':
                return __PMA_TRANSL('Lines terminated with');
            case 'Export_excel_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_excel_edition_name':
                return __PMA_TRANSL('Excel edition');
            case 'Export_excel_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_excel_removeCRLF_name':
                return __PMA_TRANSL('Remove CRLF characters within columns');
            case 'Export_file_template_database_name':
                return __PMA_TRANSL('Database name template');
            case 'Export_file_template_server_name':
                return __PMA_TRANSL('Server name template');
            case 'Export_file_template_table_name':
                return __PMA_TRANSL('Table name template');
            case 'Export_format_name':
                return __PMA_TRANSL('Format');
            case 'Export_htmlword_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_htmlword_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_htmlword_structure_or_data_name':
                return __PMA_TRANSL('Dump table');
            case 'Export_latex_caption_name':
                return __PMA_TRANSL('Include table caption');
            case 'Export_latex_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_latex_comments_name':
                return __PMA_TRANSL('Comments');
            case 'Export_latex_data_caption_name':
                return __PMA_TRANSL('Table caption');
            case 'Export_latex_data_continued_caption_name':
                return __PMA_TRANSL('Continued table caption');
            case 'Export_latex_data_label_name':
                return __PMA_TRANSL('Label key');
            case 'Export_latex_mime_name':
                return __PMA_TRANSL('MIME type');
            case 'Export_latex_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_latex_relation_name':
                return __PMA_TRANSL('Relationships');
            case 'Export_latex_structure_caption_name':
                return __PMA_TRANSL('Table caption');
            case 'Export_latex_structure_continued_caption_name':
                return __PMA_TRANSL('Continued table caption');
            case 'Export_latex_structure_label_name':
                return __PMA_TRANSL('Label key');
            case 'Export_latex_structure_or_data_name':
                return __PMA_TRANSL('Dump table');
            case 'Export_method_name':
                return __PMA_TRANSL('Export method');
            case 'Export_ods_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_ods_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_odt_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_odt_comments_name':
                return __PMA_TRANSL('Comments');
            case 'Export_odt_mime_name':
                return __PMA_TRANSL('MIME type');
            case 'Export_odt_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_odt_relation_name':
                return __PMA_TRANSL('Relationships');
            case 'Export_odt_structure_or_data_name':
                return __PMA_TRANSL('Dump table');
            case 'Export_onserver_name':
                return __PMA_TRANSL('Save on server');
            case 'Export_onserver_overwrite_name':
                return __PMA_TRANSL('Overwrite existing file(s)');
            case 'Export_as_separate_files_name':
                return __PMA_TRANSL('Export as separate files');
            case 'Export_quick_export_onserver_name':
                return __PMA_TRANSL('Save on server');
            case 'Export_quick_export_onserver_overwrite_name':
                return __PMA_TRANSL('Overwrite existing file(s)');
            case 'Export_remember_file_template_name':
                return __PMA_TRANSL('Remember file name template');
            case 'Export_sql_auto_increment_name':
                return __PMA_TRANSL('Add AUTO_INCREMENT value');
            case 'Export_sql_backquotes_name':
                return __PMA_TRANSL('Enclose table and column names with backquotes');
            case 'Export_sql_compatibility_name':
                return __PMA_TRANSL('SQL compatibility mode');
            case 'Export_sql_dates_name':
                return __PMA_TRANSL('Creation/Update/Check dates');
            case 'Export_sql_delayed_name':
                return __PMA_TRANSL('Use delayed inserts');
            case 'Export_sql_disable_fk_name':
                return __PMA_TRANSL('Disable foreign key checks');
            case 'Export_sql_views_as_tables_name':
                return __PMA_TRANSL('Export views as tables');
            case 'Export_sql_metadata_name':
                return __PMA_TRANSL('Export related metadata from phpMyAdmin configuration storage');
            case 'Export_sql_create_database_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'CREATE DATABASE / USE');
            case 'Export_sql_drop_database_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'DROP DATABASE');
            case 'Export_sql_drop_table_name':
                return sprintf(
                    __PMA_TRANSL('Add %s'), 'DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT / TRIGGER'
                );
            case 'Export_sql_create_table_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'CREATE TABLE');
            case 'Export_sql_create_view_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'CREATE VIEW');
            case 'Export_sql_create_trigger_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'CREATE TRIGGER');
            case 'Export_sql_hex_for_binary_name':
                return __PMA_TRANSL('Use hexadecimal for BINARY & BLOB');
            case 'Export_sql_if_not_exists_name':
                return __PMA_TRANSL(
                    'Add IF NOT EXISTS (less efficient as indexes will be generated during'
                    . ' table creation)'
                );
            case 'Export_sql_ignore_name':
                return __PMA_TRANSL('Use ignore inserts');
            case 'Export_sql_include_comments_name':
                return __PMA_TRANSL('Comments');
            case 'Export_sql_insert_syntax_name':
                return __PMA_TRANSL('Syntax to use when inserting data');
            case 'Export_sql_max_query_size_name':
                return __PMA_TRANSL('Maximal length of created query');
            case 'Export_sql_mime_name':
                return __PMA_TRANSL('MIME type');
            case 'Export_sql_procedure_function_name':
                return sprintf(__PMA_TRANSL('Add %s'), 'CREATE PROCEDURE / FUNCTION / EVENT');
            case 'Export_sql_relation_name':
                return __PMA_TRANSL('Relationships');
            case 'Export_sql_structure_or_data_name':
                return __PMA_TRANSL('Dump table');
            case 'Export_sql_type_name':
                return __PMA_TRANSL('Export type');
            case 'Export_sql_use_transaction_name':
                return __PMA_TRANSL('Enclose export in a transaction');
            case 'Export_sql_utc_time_name':
                return __PMA_TRANSL('Export time in UTC');
            case 'Export_texytext_columns_name':
                return __PMA_TRANSL('Put columns names in the first row');
            case 'Export_texytext_null_name':
                return __PMA_TRANSL('Replace NULL with');
            case 'Export_texytext_structure_or_data_name':
                return __PMA_TRANSL('Dump table');
            case 'ForeignKeyDropdownOrder_desc':
                return __PMA_TRANSL(
                    'Sort order for items in a foreign-key dropdown box; [kbd]content[/kbd] is '
                    . 'the referenced data, [kbd]id[/kbd] is the key value.'
                );
            case 'ForeignKeyDropdownOrder_name':
                return __PMA_TRANSL('Foreign key dropdown order');
            case 'ForeignKeyMaxLimit_desc':
                return __PMA_TRANSL('A dropdown will be used if fewer items are present.');
            case 'ForeignKeyMaxLimit_name':
                return __PMA_TRANSL('Foreign key limit');
            case 'DefaultForeignKeyChecks_desc':
                return __PMA_TRANSL('Default value for foreign key checks checkbox for some queries.');
            case 'DefaultForeignKeyChecks_name':
                return __PMA_TRANSL('Foreign key checks');
            case 'Form_Browse_name':
                return __PMA_TRANSL('Browse mode');
            case 'Form_Browse_desc':
                return __PMA_TRANSL('Customize browse mode.');
            case 'Form_CodeGen_name':
                return 'CodeGen';
            case 'Form_CodeGen_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Csv_name':
                return __PMA_TRANSL('CSV');
            case 'Form_Csv_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Developer_name':
                return __PMA_TRANSL('Developer');
            case 'Form_Developer_desc':
                return __PMA_TRANSL('Settings for phpMyAdmin developers.');
            case 'Form_Edit_name':
                return __PMA_TRANSL('Edit mode');
            case 'Form_Edit_desc':
                return __PMA_TRANSL('Customize edit mode.');
            case 'Form_Export_defaults_name':
                return __PMA_TRANSL('Export defaults');
            case 'Form_Export_defaults_desc':
                return __PMA_TRANSL('Customize default export options.');
            case 'Form_General_name':
                return __PMA_TRANSL('General');
            case 'Form_General_desc':
                return __PMA_TRANSL('Set some commonly used options.');
            case 'Form_Import_defaults_name':
                return __PMA_TRANSL('Import defaults');
            case 'Form_Import_defaults_desc':
                return __PMA_TRANSL('Customize default common import options.');
            case 'Form_Import_export_name':
                return __PMA_TRANSL('Import / export');
            case 'Form_Import_export_desc':
                return __PMA_TRANSL('Set import and export directories and compression options.');
            case 'Form_Latex_name':
                return __PMA_TRANSL('LaTeX');
            case 'Form_Latex_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Navi_databases_name':
                return __PMA_TRANSL('Databases');
            case 'Form_Navi_databases_desc':
                return __PMA_TRANSL('Databases display options.');
            case 'Form_Navi_panel_name':
                return __PMA_TRANSL('Navigation panel');
            case 'Form_Navi_panel_desc':
                return __PMA_TRANSL('Customize appearance of the navigation panel.');
            case 'Form_Navi_tree_name':
                return __PMA_TRANSL('Navigation tree');
            case 'Form_Navi_tree_desc':
                return __PMA_TRANSL('Customize the navigation tree.');
            case 'Form_Navi_servers_name':
                return __PMA_TRANSL('Servers');
            case 'Form_Navi_servers_desc':
                return __PMA_TRANSL('Servers display options.');
            case 'Form_Navi_tables_name':
                return __PMA_TRANSL('Tables');
            case 'Form_Navi_tables_desc':
                return __PMA_TRANSL('Tables display options.');
            case 'Form_Main_panel_name':
                return __PMA_TRANSL('Main panel');
            case 'Form_Microsoft_Office_name':
                return __PMA_TRANSL('Microsoft Office');
            case 'Form_Microsoft_Office_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Open_Document_name':
                return 'OpenDocument';
            case 'Form_Open_Document_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Other_core_settings_name':
                return __PMA_TRANSL('Other core settings');
            case 'Form_Other_core_settings_desc':
                return __PMA_TRANSL('Settings that didn\'t fit anywhere else.');
            case 'Form_Page_titles_name':
                return __PMA_TRANSL('Page titles');
            case 'Form_Page_titles_desc':
                return __PMA_TRANSL(
                    'Specify browser\'s title bar text. Refer to '
                    . '[doc@faq6-27]documentation[/doc] for magic strings that can be used '
                    . 'to get special values.'
                );
            case 'Form_Security_name':
                return __PMA_TRANSL('Security');
            case 'Form_Security_desc':
                return __PMA_TRANSL(
                    'Please note that phpMyAdmin is just a user interface and its features do not '
                    . 'limit MySQL.'
                );
            case 'Form_Server_name':
                return __PMA_TRANSL('Basic settings');
            case 'Form_Server_auth_name':
                return __PMA_TRANSL('Authentication');
            case 'Form_Server_auth_desc':
                return __PMA_TRANSL('Authentication settings.');
            case 'Form_Server_config_name':
                return __PMA_TRANSL('Server configuration');
            case 'Form_Server_config_desc':
                return __PMA_TRANSL(
                    'Advanced server configuration, do not change these options unless you know '
                    . 'what they are for.'
                );
            case 'Form_Server_desc':
                return __PMA_TRANSL('Enter server connection parameters.');
            case 'Form_Server_pmadb_name':
                return __PMA_TRANSL('Configuration storage');
            case 'Form_Server_pmadb_desc':
                return __PMA_TRANSL(
                    'Configure phpMyAdmin configuration storage to gain access to additional '
                    . 'features, see [doc@linked-tables]phpMyAdmin configuration storage[/doc] in '
                    . 'documentation.'
                );
            case 'Form_Server_tracking_name':
                return __PMA_TRANSL('Changes tracking');
            case 'Form_Server_tracking_desc':
                return __PMA_TRANSL(
                    'Tracking of changes made in database. Requires the phpMyAdmin configuration '
                    . 'storage.'
                );
            case 'Form_Sql_name':
                return __PMA_TRANSL('SQL');
            case 'Form_Sql_box_name':
                return __PMA_TRANSL('SQL Query box');
            case 'Form_Sql_box_desc':
                return __PMA_TRANSL('Customize links shown in SQL Query boxes.');
            case 'Form_Sql_desc':
                return __PMA_TRANSL('Customize default options.');
            case 'Form_Sql_queries_name':
                return __PMA_TRANSL('SQL queries');
            case 'Form_Sql_queries_desc':
                return __PMA_TRANSL('SQL queries settings.');
            case 'Form_Startup_name':
                return __PMA_TRANSL('Startup');
            case 'Form_Startup_desc':
                return __PMA_TRANSL('Customize startup page.');
            case 'Form_DbStructure_name':
                return __PMA_TRANSL('Database structure');
            case 'Form_DbStructure_desc':
                return __PMA_TRANSL('Choose which details to show in the database structure (list of tables).');
            case 'Form_TableStructure_name':
                return __PMA_TRANSL('Table structure');
            case 'Form_TableStructure_desc':
                return __PMA_TRANSL('Settings for the table structure (list of columns).');
            case 'Form_Tabs_name':
                return __PMA_TRANSL('Tabs');
            case 'Form_Tabs_desc':
                return __PMA_TRANSL('Choose how you want tabs to work.');
            case 'Form_DisplayRelationalSchema_name':
                return __PMA_TRANSL('Display relational schema');
            case 'Form_DisplayRelationalSchema_desc':
                return '';
            case 'PDFDefaultPageSize_name':
                return __PMA_TRANSL('Paper size');
            case 'PDFDefaultPageSize_desc':
                return '';
            case 'Form_Databases_name':
                return __PMA_TRANSL('Databases');
            case 'Form_Text_fields_name':
                return __PMA_TRANSL('Text fields');
            case 'Form_Text_fields_desc':
                return __PMA_TRANSL('Customize text input fields.');
            case 'Form_Texy_name':
                return __PMA_TRANSL('Texy! text');
            case 'Form_Texy_desc':
                return __PMA_TRANSL('Customize default options');
            case 'Form_Warnings_name':
                return __PMA_TRANSL('Warnings');
            case 'Form_Warnings_desc':
                return __PMA_TRANSL('Disable some of the warnings shown by phpMyAdmin.');
            case 'Form_Console_name':
                return __PMA_TRANSL('Console');
            case 'GZipDump_desc':
                return __PMA_TRANSL(
                    'Enable gzip compression for import '
                    . 'and export operations.'
                );
            case 'GZipDump_name':
                return __PMA_TRANSL('GZip');
            case 'IconvExtraParams_name':
                return __PMA_TRANSL('Extra parameters for iconv');
            case 'IgnoreMultiSubmitErrors_desc':
                return __PMA_TRANSL(
                    'If enabled, phpMyAdmin continues computing multiple-statement queries even if '
                    . 'one of the queries failed.'
                );
            case 'IgnoreMultiSubmitErrors_name':
                return __PMA_TRANSL('Ignore multiple statement errors');
            case 'Import_allow_interrupt_desc':
                return __PMA_TRANSL(
                    'Allow interrupt of import in case script detects it is close to time limit. '
                    . 'This might be a good way to import large files, however it can break '
                    . 'transactions.'
                );
            case 'Import_allow_interrupt_name':
                return __PMA_TRANSL('Partial import: allow interrupt');
            case 'Import_charset_name':
                return __PMA_TRANSL('Character set of the file');
            case 'Import_csv_col_names_name':
                return __PMA_TRANSL('Lines terminated with');
            case 'Import_csv_enclosed_name':
                return __PMA_TRANSL('Columns enclosed with');
            case 'Import_csv_escaped_name':
                return __PMA_TRANSL('Columns escaped with');
            case 'Import_csv_ignore_name':
                return __PMA_TRANSL('Do not abort on INSERT error');
            case 'Import_csv_replace_name':
                return __PMA_TRANSL('Add ON DUPLICATE KEY UPDATE');
            case 'Import_csv_replace_desc':
                return __PMA_TRANSL('Update data when duplicate keys found on import');
            case 'Import_csv_terminated_name':
                return __PMA_TRANSL('Columns terminated with');
            case 'Import_format_desc':
                return __PMA_TRANSL(
                    'Default format; be aware that this list depends on location (database, table) '
                    . 'and only SQL is always available.'
                );
            case 'Import_format_name':
                return __PMA_TRANSL('Format of imported file');
            case 'Import_ldi_enclosed_name':
                return __PMA_TRANSL('Columns enclosed with');
            case 'Import_ldi_escaped_name':
                return __PMA_TRANSL('Columns escaped with');
            case 'Import_ldi_ignore_name':
                return __PMA_TRANSL('Do not abort on INSERT error');
            case 'Import_ldi_local_option_name':
                return __PMA_TRANSL('Use LOCAL keyword');
            case 'Import_ldi_replace_name':
                return __PMA_TRANSL('Add ON DUPLICATE KEY UPDATE');
            case 'Import_ldi_replace_desc':
                return __PMA_TRANSL('Update data when duplicate keys found on import');
            case 'Import_ldi_terminated_name':
                return __PMA_TRANSL('Columns terminated with');
            case 'Import_ods_col_names_name':
                return __PMA_TRANSL('Column names in first row');
            case 'Import_ods_empty_rows_name':
                return __PMA_TRANSL('Do not import empty rows');
            case 'Import_ods_recognize_currency_name':
                return __PMA_TRANSL('Import currencies ($5.00 to 5.00)');
            case 'Import_ods_recognize_percentages_name':
                return __PMA_TRANSL('Import percentages as proper decimals (12.00% to .12)');
            case 'Import_skip_queries_desc':
                return __PMA_TRANSL('Number of queries to skip from start.');
            case 'Import_skip_queries_name':
                return __PMA_TRANSL('Partial import: skip queries');
            case 'Import_sql_compatibility_name':
                return __PMA_TRANSL('SQL compatibility mode');
            case 'Import_sql_no_auto_value_on_zero_name':
                return __PMA_TRANSL('Do not use AUTO_INCREMENT for zero values');
            case 'Import_sql_read_as_multibytes_name':
                return __PMA_TRANSL('Read as multibytes');
            case 'InitialSlidersState_name':
                return __PMA_TRANSL('Initial state for sliders');
            case 'InsertRows_desc':
                return __PMA_TRANSL('How many rows can be inserted at one time.');
            case 'InsertRows_name':
                return __PMA_TRANSL('Number of inserted rows');
            case 'LimitChars_desc':
                return __PMA_TRANSL('Maximum number of characters shown in any non-numeric column on browse view.');
            case 'LimitChars_name':
                return __PMA_TRANSL('Limit column characters');
            case 'LoginCookieDeleteAll_desc':
                return __PMA_TRANSL(
                    'If TRUE, logout deletes cookies for all servers; when set to FALSE, logout '
                    . 'only occurs for the current server. Setting this to FALSE makes it easy to '
                    . 'forget to log out from other servers when connected to multiple servers.'
                );
            case 'LoginCookieDeleteAll_name':
                return __PMA_TRANSL('Delete all cookies on logout');
            case 'LoginCookieRecall_desc':
                return __PMA_TRANSL(
                    'Define whether the previous login should be recalled or not in '
                    . '[kbd]cookie[/kbd] authentication mode.'
                );
            case 'LoginCookieRecall_name':
                return __PMA_TRANSL('Recall user name');
            case 'LoginCookieStore_desc':
                return __PMA_TRANSL(
                    'Defines how long (in seconds) a login cookie should be stored in browser. '
                    . 'The default of 0 means that it will be kept for the existing session only, '
                    . 'and will be deleted as soon as you close the browser window. This is '
                    . 'recommended for non-trusted environments.'
                );
            case 'LoginCookieStore_name':
                return __PMA_TRANSL('Login cookie store');
            case 'LoginCookieValidity_desc':
                return __PMA_TRANSL('Define how long (in seconds) a login cookie is valid.');
            case 'LoginCookieValidity_name':
                return __PMA_TRANSL('Login cookie validity');
            case 'LongtextDoubleTextarea_desc':
                return __PMA_TRANSL('Double size of textarea for LONGTEXT columns.');
            case 'LongtextDoubleTextarea_name':
                return __PMA_TRANSL('Bigger textarea for LONGTEXT');
            case 'MaxCharactersInDisplayedSQL_desc':
                return __PMA_TRANSL('Maximum number of characters used when a SQL query is displayed.');
            case 'MaxCharactersInDisplayedSQL_name':
                return __PMA_TRANSL('Maximum displayed SQL length');
            case 'MaxDbList_cmt':
                return __PMA_TRANSL('Users cannot set a higher value');
            case 'MaxDbList_desc':
                return __PMA_TRANSL('Maximum number of databases displayed in database list.');
            case 'MaxDbList_name':
                return __PMA_TRANSL('Maximum databases');
            case 'FirstLevelNavigationItems_desc':
                return __PMA_TRANSL(
                    'The number of items that can be displayed on each page on the first level'
                    . ' of the navigation tree.'
                );
            case 'FirstLevelNavigationItems_name':
                return __PMA_TRANSL('Maximum items on first level');
            case 'MaxNavigationItems_desc':
                return __PMA_TRANSL('The number of items that can be displayed on each page of the navigation tree.');
            case 'MaxNavigationItems_name':
                return __PMA_TRANSL('Maximum items in branch');
            case 'MaxRows_desc':
                return __PMA_TRANSL(
                    'Number of rows displayed when browsing a result set. If the result set '
                    . 'contains more rows, "Previous" and "Next" links will be '
                    . 'shown.'
                );
            case 'MaxRows_name':
                return __PMA_TRANSL('Maximum number of rows to display');
            case 'MaxTableList_cmt':
                return __PMA_TRANSL('Users cannot set a higher value');
            case 'MaxTableList_desc':
                return __PMA_TRANSL('Maximum number of tables displayed in table list.');
            case 'MaxTableList_name':
                return __PMA_TRANSL('Maximum tables');
            case 'MemoryLimit_desc':
                return __PMA_TRANSL(
                    'The number of bytes a script is allowed to allocate, eg. [kbd]32M[/kbd] '
                    . '([kbd]-1[/kbd] for no limit and [kbd]0[/kbd] for no change).'
                );
            case 'MemoryLimit_name':
                return __PMA_TRANSL('Memory limit');
            case 'ShowDatabasesNavigationAsTree_desc':
                return __PMA_TRANSL('In the navigation panel, replaces the database tree with a selector');
            case 'ShowDatabasesNavigationAsTree_name':
                return __PMA_TRANSL('Show databases navigation as tree');
            case 'NavigationWidth_name':
                return __PMA_TRANSL('Navigation panel width');
            case 'NavigationWidth_desc':
                return __PMA_TRANSL('Set to 0 to collapse navigation panel.');
            case 'NavigationLinkWithMainPanel_desc':
                return __PMA_TRANSL('Link with main panel by highlighting the current database or table.');
            case 'NavigationLinkWithMainPanel_name':
                return __PMA_TRANSL('Link with main panel');
            case 'NavigationDisplayLogo_desc':
                return __PMA_TRANSL('Show logo in navigation panel.');
            case 'NavigationDisplayLogo_name':
                return __PMA_TRANSL('Display logo');
            case 'NavigationLogoLink_desc':
                return __PMA_TRANSL('URL where logo in the navigation panel will point to.');
            case 'NavigationLogoLink_name':
                return __PMA_TRANSL('Logo link URL');
            case 'NavigationLogoLinkWindow_desc':
                return __PMA_TRANSL(
                    'Open the linked page in the main window ([kbd]main[/kbd]) or in a new one '
                    . '([kbd]new[/kbd]).'
                );
            case 'NavigationLogoLinkWindow_name':
                return __PMA_TRANSL('Logo link target');
            case 'NavigationDisplayServers_desc':
                return __PMA_TRANSL('Display server choice at the top of the navigation panel.');
            case 'NavigationDisplayServers_name':
                return __PMA_TRANSL('Display servers selection');
            case 'NavigationTreeDefaultTabTable_name':
                return __PMA_TRANSL('Target for quick access icon');
            case 'NavigationTreeDefaultTabTable2_name':
                return __PMA_TRANSL('Target for second quick access icon');
            case 'NavigationTreeDisplayItemFilterMinimum_desc':
                return __PMA_TRANSL(
                    'Defines the minimum number of items (tables, views, routines and events) to '
                    . 'display a filter box.'
                );
            case 'NavigationTreeDisplayItemFilterMinimum_name':
                return __PMA_TRANSL('Minimum number of items to display the filter box');
            case 'NavigationTreeDisplayDbFilterMinimum_name':
                return __PMA_TRANSL('Minimum number of databases to display the database filter box');
            case 'NavigationTreeEnableGrouping_desc':
                return __PMA_TRANSL(
                    'Group items in the navigation tree (determined by the separator defined in ' .
                    'the Databases and Tables tabs above).'
                );
            case 'NavigationTreeEnableGrouping_name':
                return __PMA_TRANSL('Group items in the tree');
            case 'NavigationTreeDbSeparator_desc':
                return __PMA_TRANSL('String that separates databases into different tree levels.');
            case 'NavigationTreeDbSeparator_name':
                return __PMA_TRANSL('Database tree separator');
            case 'NavigationTreeTableSeparator_desc':
                return __PMA_TRANSL('String that separates tables into different tree levels.');
            case 'NavigationTreeTableSeparator_name':
                return __PMA_TRANSL('Table tree separator');
            case 'NavigationTreeTableLevel_name':
                return __PMA_TRANSL('Maximum table tree depth');
            case 'NavigationTreePointerEnable_desc':
                return __PMA_TRANSL('Highlight server under the mouse cursor.');
            case 'NavigationTreePointerEnable_name':
                return __PMA_TRANSL('Enable highlighting');
            case 'NavigationTreeEnableExpansion_desc':
                return __PMA_TRANSL('Whether to offer the possibility of tree expansion in the navigation panel.');
            case 'NavigationTreeEnableExpansion_name':
                return __PMA_TRANSL('Enable navigation tree expansion');
            case 'NavigationTreeShowTables_name':
                return __PMA_TRANSL('Show tables in tree');
            case 'NavigationTreeShowTables_desc':
                return __PMA_TRANSL('Whether to show tables under database in the navigation tree');
            case 'NavigationTreeShowViews_name':
                return __PMA_TRANSL('Show views in tree');
            case 'NavigationTreeShowViews_desc':
                return __PMA_TRANSL('Whether to show views under database in the navigation tree');
            case 'NavigationTreeShowFunctions_name':
                return __PMA_TRANSL('Show functions in tree');
            case 'NavigationTreeShowFunctions_desc':
                return __PMA_TRANSL('Whether to show functions under database in the navigation tree');
            case 'NavigationTreeShowProcedures_name':
                return __PMA_TRANSL('Show procedures in tree');
            case 'NavigationTreeShowProcedures_desc':
                return __PMA_TRANSL('Whether to show procedures under database in the navigation tree');
            case 'NavigationTreeShowEvents_name':
                return __PMA_TRANSL('Show events in tree');
            case 'NavigationTreeShowEvents_desc':
                return __PMA_TRANSL('Whether to show events under database in the navigation tree');
            case 'NumRecentTables_desc':
                return __PMA_TRANSL('Maximum number of recently used tables; set 0 to disable.');
            case 'NumFavoriteTables_desc':
                return __PMA_TRANSL('Maximum number of favorite tables; set 0 to disable.');
            case 'NumRecentTables_name':
                return __PMA_TRANSL('Recently used tables');
            case 'NumFavoriteTables_name':
                return __PMA_TRANSL('Favorite tables');
            case 'RowActionLinks_desc':
                return __PMA_TRANSL('These are Edit, Copy and Delete links.');
            case 'RowActionLinks_name':
                return __PMA_TRANSL('Where to show the table row links');
            case 'RowActionLinksWithoutUnique_desc':
                return __PMA_TRANSL('Whether to show row links even in the absence of a unique key.');
            case 'RowActionLinksWithoutUnique_name':
                return __PMA_TRANSL('Show row links anyway');
            case 'DisableShortcutKeys_name':
                return __PMA_TRANSL('Disable shortcut keys');
            case 'DisableShortcutKeys_desc':
                return __PMA_TRANSL('Disable shortcut keys');
            case 'NaturalOrder_desc':
                return __PMA_TRANSL('Use natural order for sorting table and database names.');
            case 'NaturalOrder_name':
                return __PMA_TRANSL('Natural order');
            case 'TableNavigationLinksMode_desc':
                return __PMA_TRANSL('Use only icons, only text or both.');
            case 'TableNavigationLinksMode_name':
                return __PMA_TRANSL('Table navigation bar');
            case 'OBGzip_desc':
                return __PMA_TRANSL('Use GZip output buffering for increased speed in HTTP transfers.');
            case 'OBGzip_name':
                return __PMA_TRANSL('GZip output buffering');
            case 'Order_desc':
                return __PMA_TRANSL(
                    '[kbd]SMART[/kbd] - i.e. descending order for columns of type TIME, DATE, '
                    . 'DATETIME and TIMESTAMP, ascending order otherwise.'
                );
            case 'Order_name':
                return __PMA_TRANSL('Default sorting order');
            case 'PersistentConnections_desc':
                return __PMA_TRANSL('Use persistent connections to MySQL databases.');
            case 'PersistentConnections_name':
                return __PMA_TRANSL('Persistent connections');
            case 'PmaNoRelation_DisableWarning_desc':
                return __PMA_TRANSL(
                    'Disable the default warning that is displayed on the database details '
                    . 'Structure page if any of the required tables for the phpMyAdmin '
                    . 'configuration storage could not be found.'
                );
            case 'PmaNoRelation_DisableWarning_name':
                return __PMA_TRANSL('Missing phpMyAdmin configuration storage tables');
            case 'ReservedWordDisableWarning_desc':
                return __PMA_TRANSL(
                    'Disable the default warning that is displayed on the Structure page if column '
                    . 'names in a table are reserved MySQL words.'
                );
            case 'ReservedWordDisableWarning_name':
                return __PMA_TRANSL('MySQL reserved word warning');
            case 'TabsMode_desc':
                return __PMA_TRANSL('Use only icons, only text or both.');
            case 'TabsMode_name':
                return __PMA_TRANSL('How to display the menu tabs');
            case 'ActionLinksMode_desc':
                return __PMA_TRANSL('Use only icons, only text or both.');
            case 'ActionLinksMode_name':
                return __PMA_TRANSL('How to display various action links');
            case 'ProtectBinary_desc':
                return __PMA_TRANSL('Disallow BLOB and BINARY columns from editing.');
            case 'ProtectBinary_name':
                return __PMA_TRANSL('Protect binary columns');
            case 'QueryHistoryDB_desc':
                return __PMA_TRANSL(
                    'Enable if you want DB-based query history (requires phpMyAdmin configuration '
                    . 'storage). If disabled, this utilizes JS-routines to display query history '
                    . '(lost by window close).'
                );
            case 'QueryHistoryDB_name':
                return __PMA_TRANSL('Permanent query history');
            case 'QueryHistoryMax_cmt':
                return __PMA_TRANSL('Users cannot set a higher value');
            case 'QueryHistoryMax_desc':
                return __PMA_TRANSL('How many queries are kept in history.');
            case 'QueryHistoryMax_name':
                return __PMA_TRANSL('Query history length');
            case 'RecodingEngine_desc':
                return __PMA_TRANSL('Select which functions will be used for character set conversion.');
            case 'RecodingEngine_name':
                return __PMA_TRANSL('Recoding engine');
            case 'RememberSorting_desc':
                return __PMA_TRANSL('When browsing tables, the sorting of each table is remembered.');
            case 'RememberSorting_name':
                return __PMA_TRANSL('Remember table\'s sorting');
            case 'TablePrimaryKeyOrder_desc':
                return __PMA_TRANSL('Default sort order for tables with a primary key.');
            case 'TablePrimaryKeyOrder_name':
                return __PMA_TRANSL('Primary key default sort order');
            case 'RepeatCells_desc':
                return __PMA_TRANSL('Repeat the headers every X cells, [kbd]0[/kbd] deactivates this feature.');
            case 'RepeatCells_name':
                return __PMA_TRANSL('Repeat headers');
            case 'GridEditing_name':
                return __PMA_TRANSL('Grid editing: trigger action');
            case 'RelationalDisplay_name':
                return __PMA_TRANSL('Relational display');
            case 'RelationalDisplay_desc':
                return __PMA_TRANSL('For display Options');
            case 'SaveCellsAtOnce_name':
                return __PMA_TRANSL('Grid editing: save all edited cells at once');
            case 'SaveDir_desc':
                return __PMA_TRANSL('Directory where exports can be saved on server.');
            case 'SaveDir_name':
                return __PMA_TRANSL('Save directory');
            case 'Servers_AllowDeny_order_desc':
                return __PMA_TRANSL('Leave blank if not used.');
            case 'Servers_AllowDeny_order_name':
                return __PMA_TRANSL('Host authorization order');
            case 'Servers_AllowDeny_rules_desc':
                return __PMA_TRANSL('Leave blank for defaults.');
            case 'Servers_AllowDeny_rules_name':
                return __PMA_TRANSL('Host authorization rules');
            case 'Servers_AllowNoPassword_name':
                return __PMA_TRANSL('Allow logins without a password');
            case 'Servers_AllowRoot_name':
                return __PMA_TRANSL('Allow root login');
            case 'Servers_SessionTimeZone_name':
                return __PMA_TRANSL('Session timezone');
            case 'Servers_SessionTimeZone_desc':
                return __PMA_TRANSL(
                    'Sets the effective timezone; possibly different than the one from your '
                    .  'database server'
                );
            case 'Servers_auth_http_realm_desc':
                return __PMA_TRANSL('HTTP Basic Auth Realm name to display when doing HTTP Auth.');
            case 'Servers_auth_http_realm_name':
                return __PMA_TRANSL('HTTP Realm');
            case 'Servers_auth_type_desc':
                return __PMA_TRANSL('Authentication method to use.');
            case 'Servers_auth_type_name':
                return __PMA_TRANSL('Authentication type');
            case 'Servers_bookmarktable_desc':
                return __PMA_TRANSL(
                    'Leave blank for no [doc@bookmarks@]bookmark[/doc] '
                    . 'support, suggested: [kbd]pma__bookmark[/kbd]'
                );
            case 'Servers_bookmarktable_name':
                return __PMA_TRANSL('Bookmark table');
            case 'Servers_column_info_desc':
                return __PMA_TRANSL(
                    'Leave blank for no column comments/mime types, suggested: '
                    . '[kbd]pma__column_info[/kbd].'
                );
            case 'Servers_column_info_name':
                return __PMA_TRANSL('Column information table');
            case 'Servers_compress_desc':
                return __PMA_TRANSL('Compress connection to MySQL server.');
            case 'Servers_compress_name':
                return __PMA_TRANSL('Compress connection');
            case 'Servers_controlpass_name':
                return __PMA_TRANSL('Control user password');
            case 'Servers_controluser_desc':
                return __PMA_TRANSL(
                    'A special MySQL user configured with limited permissions, more information '
                    . 'available on [doc@linked-tables]documentation[/doc].'
                );
            case 'Servers_controluser_name':
                return __PMA_TRANSL('Control user');
            case 'Servers_controlhost_desc':
                return __PMA_TRANSL(
                    'An alternate host to hold the configuration storage; leave blank to use the '
                    . 'already defined host.'
                );
            case 'Servers_controlhost_name':
                return __PMA_TRANSL('Control host');
            case 'Servers_controlport_desc':
                return __PMA_TRANSL(
                    'An alternate port to connect to the host that holds the configuration storage; '
                    . 'leave blank to use the default port, or the already defined port, if the '
                    . 'controlhost equals host.'
                );
            case 'Servers_controlport_name':
                return __PMA_TRANSL('Control port');
            case 'Servers_hide_db_desc':
                return __PMA_TRANSL('Hide databases matching regular expression (PCRE).');
            case 'Servers_DisableIS_desc':
                return __PMA_TRANSL(
                    'More information on [a@https://github.com/phpmyadmin/phpmyadmin/issues/8970]phpMyAdmin '
                    .  'issue tracker[/a] and [a@https://bugs.mysql.com/19588]MySQL Bugs[/a]'
                );
            case 'Servers_DisableIS_name':
                return __PMA_TRANSL('Disable use of INFORMATION_SCHEMA');
            case 'Servers_hide_db_name':
                return __PMA_TRANSL('Hide databases');
            case 'Servers_history_desc':
                return __PMA_TRANSL(
                    'Leave blank for no SQL query history support, suggested: '
                    . '[kbd]pma__history[/kbd].'
                );
            case 'Servers_history_name':
                return __PMA_TRANSL('SQL query history table');
            case 'Servers_host_desc':
                return __PMA_TRANSL('Hostname where MySQL server is running.');
            case 'Servers_host_name':
                return __PMA_TRANSL('Server hostname');
            case 'Servers_LogoutURL_name':
                return __PMA_TRANSL('Logout URL');
            case 'Servers_MaxTableUiprefs_desc':
                return __PMA_TRANSL(
                    'Limits number of table preferences which are stored in database, the oldest '
                    . 'records are automatically removed.'
                );
            case 'Servers_MaxTableUiprefs_name':
                return __PMA_TRANSL('Maximal number of table preferences to store');
            case 'Servers_savedsearches_name':
                return __PMA_TRANSL('QBE saved searches table');
            case 'Servers_savedsearches_desc':
                return __PMA_TRANSL(
                    'Leave blank for no QBE saved searches support, suggested: '
                    . '[kbd]pma__savedsearches[/kbd].'
                );
            case 'Servers_export_templates_name':
                return __PMA_TRANSL('Export templates table');
            case 'Servers_export_templates_desc':
                return __PMA_TRANSL(
                    'Leave blank for no export template support, suggested: '
                    . '[kbd]pma__export_templates[/kbd].'
                );
            case 'Servers_central_columns_name':
                return __PMA_TRANSL('Central columns table');
            case 'Servers_central_columns_desc':
                return __PMA_TRANSL(
                    'Leave blank for no central columns support, suggested: '
                    . '[kbd]pma__central_columns[/kbd].'
                );
            case 'Servers_only_db_desc':
                return __PMA_TRANSL(
                    'You can use MySQL wildcard characters (% and _), escape them if you want to '
                    . 'use their literal instances, i.e. use [kbd]\'my\_db\'[/kbd] and not '
                    . '[kbd]\'my_db\'[/kbd].'
                );
            case 'Servers_only_db_name':
                return __PMA_TRANSL('Show only listed databases');
            case 'Servers_password_desc':
                return __PMA_TRANSL('Leave empty if not using config auth.');
            case 'Servers_password_name':
                return __PMA_TRANSL('Password for config auth');
            case 'Servers_pdf_pages_desc':
                return __PMA_TRANSL('Leave blank for no PDF schema support, suggested: [kbd]pma__pdf_pages[/kbd].');
            case 'Servers_pdf_pages_name':
                return __PMA_TRANSL('PDF schema: pages table');
            case 'Servers_pmadb_desc':
                return __PMA_TRANSL(
                    'Database used for relations, bookmarks, and PDF features. See '
                    . '[doc@linked-tables]pmadb[/doc] for complete information. '
                    . 'Leave blank for no support. Suggested: [kbd]phpmyadmin[/kbd].'
                );
            case 'Servers_pmadb_name':
                return __PMA_TRANSL('Database name');
            case 'Servers_port_desc':
                return __PMA_TRANSL('Port on which MySQL server is listening, leave empty for default.');
            case 'Servers_port_name':
                return __PMA_TRANSL('Server port');
            case 'Servers_recent_desc':
                return __PMA_TRANSL(
                    'Leave blank for no "persistent" recently used tables across sessions, '
                    . 'suggested: [kbd]pma__recent[/kbd].'
                );
            case 'Servers_recent_name':
                return __PMA_TRANSL('Recently used table');
            case 'Servers_favorite_desc':
                return __PMA_TRANSL(
                    'Leave blank for no "persistent" favorite tables across sessions, '
                    . 'suggested: [kbd]pma__favorite[/kbd].'
                );
            case 'Servers_favorite_name':
                return __PMA_TRANSL('Favorites table');
            case 'Servers_relation_desc':
                return __PMA_TRANSL(
                    'Leave blank for no '
                    . '[doc@relations@]relation-links[/doc] support, '
                    . 'suggested: [kbd]pma__relation[/kbd].'
                );
            case 'Servers_relation_name':
                return __PMA_TRANSL('Relation table');
            case 'Servers_SignonSession_desc':
                return __PMA_TRANSL(
                    'See [doc@authentication-modes]authentication '
                    . 'types[/doc] for an example.'
                );
            case 'Servers_SignonSession_name':
                return __PMA_TRANSL('Signon session name');
            case 'Servers_SignonURL_name':
                return __PMA_TRANSL('Signon URL');
            case 'Servers_socket_desc':
                return __PMA_TRANSL('Socket on which MySQL server is listening, leave empty for default.');
            case 'Servers_socket_name':
                return __PMA_TRANSL('Server socket');
            case 'Servers_ssl_desc':
                return __PMA_TRANSL('Enable SSL for connection to MySQL server.');
            case 'Servers_ssl_name':
                return __PMA_TRANSL('Use SSL');
            case 'Servers_table_coords_desc':
                return __PMA_TRANSL('Leave blank for no PDF schema support, suggested: [kbd]pma__table_coords[/kbd].');
            case 'Servers_table_coords_name':
                return __PMA_TRANSL('Designer and PDF schema: table coordinates');
            case 'Servers_table_info_desc':
                return __PMA_TRANSL(
                    'Table to describe the display columns, leave blank for no support; '
                    . 'suggested: [kbd]pma__table_info[/kbd].'
                );
            case 'Servers_table_info_name':
                return __PMA_TRANSL('Display columns table');
            case 'Servers_table_uiprefs_desc':
                return __PMA_TRANSL(
                    'Leave blank for no "persistent" tables\' UI preferences across sessions, '
                    . 'suggested: [kbd]pma__table_uiprefs[/kbd].'
                );
            case 'Servers_table_uiprefs_name':
                return __PMA_TRANSL('UI preferences table');
            case 'Servers_tracking_add_drop_database_desc':
                return __PMA_TRANSL(
                    'Whether a DROP DATABASE IF EXISTS statement will be added as first line to '
                    . 'the log when creating a database.'
                );
            case 'Servers_tracking_add_drop_database_name':
                return __PMA_TRANSL('Add DROP DATABASE');
            case 'Servers_tracking_add_drop_table_desc':
                return __PMA_TRANSL(
                    'Whether a DROP TABLE IF EXISTS statement will be added as first line to the '
                    . 'log when creating a table.'
                );
            case 'Servers_tracking_add_drop_table_name':
                return __PMA_TRANSL('Add DROP TABLE');
            case 'Servers_tracking_add_drop_view_desc':
                return __PMA_TRANSL(
                    'Whether a DROP VIEW IF EXISTS statement will be added as first line to the '
                    . 'log when creating a view.'
                );
            case 'Servers_tracking_add_drop_view_name':
                return __PMA_TRANSL('Add DROP VIEW');
            case 'Servers_tracking_default_statements_desc':
                return __PMA_TRANSL('Defines the list of statements the auto-creation uses for new versions.');
            case 'Servers_tracking_default_statements_name':
                return __PMA_TRANSL('Statements to track');
            case 'Servers_tracking_desc':
                return __PMA_TRANSL(
                    'Leave blank for no SQL query tracking support, suggested: '
                    . '[kbd]pma__tracking[/kbd].'
                );
            case 'Servers_tracking_name':
                return __PMA_TRANSL('SQL query tracking table');
            case 'Servers_tracking_version_auto_create_desc':
                return __PMA_TRANSL(
                    'Whether the tracking mechanism creates versions for tables and views '
                    . 'automatically.'
                );
            case 'Servers_tracking_version_auto_create_name':
                return __PMA_TRANSL('Automatically create versions');
            case 'Servers_userconfig_desc':
                return __PMA_TRANSL(
                    'Leave blank for no user preferences storage in database, suggested: '
                    .  '[kbd]pma__userconfig[/kbd].'
                );
            case 'Servers_userconfig_name':
                return __PMA_TRANSL('User preferences storage table');
            case 'Servers_users_desc':
                return __PMA_TRANSL(
                    'Both this table and the user groups table are required to enable the ' .
                    'configurable menus feature; leaving either one of them blank will disable ' .
                    'this feature, suggested: [kbd]pma__users[/kbd].'
                );
            case 'Servers_users_name':
                return __PMA_TRANSL('Users table');
            case 'Servers_usergroups_desc':
                return __PMA_TRANSL(
                    'Both this table and the users table are required to enable the configurable ' .
                    'menus feature; leaving either one of them blank will disable this feature, ' .
                    'suggested: [kbd]pma__usergroups[/kbd].'
                );
            case 'Servers_usergroups_name':
                return __PMA_TRANSL('User groups table');
            case 'Servers_navigationhiding_desc':
                return __PMA_TRANSL(
                    'Leave blank to disable the feature to hide and show navigation items, ' .
                    'suggested: [kbd]pma__navigationhiding[/kbd].'
                );
            case 'Servers_navigationhiding_name':
                return __PMA_TRANSL('Hidden navigation items table');
            case 'Servers_user_desc':
                return __PMA_TRANSL('Leave empty if not using config auth.');
            case 'Servers_user_name':
                return __PMA_TRANSL('User for config auth');
            case 'Servers_verbose_desc':
                return __PMA_TRANSL(
                    'A user-friendly description of this server. Leave blank to display the ' .
                    'hostname instead.'
                );
            case 'Servers_verbose_name':
                return __PMA_TRANSL('Verbose name of this server');
            case 'ShowAll_desc':
                return __PMA_TRANSL('Whether a user should be displayed a "show all (rows)" button.');
            case 'ShowAll_name':
                return __PMA_TRANSL('Allow to display all the rows');
            case 'ShowChgPassword_desc':
                return __PMA_TRANSL(
                    'Please note that enabling this has no effect with [kbd]config[/kbd] ' .
                    'authentication mode because the password is hard coded in the configuration ' .
                    'file; this does not limit the ability to execute the same command directly.'
                );
            case 'ShowChgPassword_name':
                return __PMA_TRANSL('Show password change form');
            case 'ShowCreateDb_name':
                return __PMA_TRANSL('Show create database form');
            case 'ShowDbStructureComment_desc':
                return __PMA_TRANSL('Show or hide a column displaying the comments for all tables.');
            case 'ShowDbStructureComment_name':
                return __PMA_TRANSL('Show table comments');
            case 'ShowDbStructureCreation_desc':
                return __PMA_TRANSL('Show or hide a column displaying the Creation timestamp for all tables.');
            case 'ShowDbStructureCreation_name':
                return __PMA_TRANSL('Show creation timestamp');
            case 'ShowDbStructureLastUpdate_desc':
                return __PMA_TRANSL('Show or hide a column displaying the Last update timestamp for all tables.');
            case 'ShowDbStructureLastUpdate_name':
                return __PMA_TRANSL('Show last update timestamp');
            case 'ShowDbStructureLastCheck_desc':
                return __PMA_TRANSL('Show or hide a column displaying the Last check timestamp for all tables.');
            case 'ShowDbStructureLastCheck_name':
                return __PMA_TRANSL('Show last check timestamp');
            case 'ShowDbStructureCharset_desc':
                return __PMA_TRANSL('Show or hide a column displaying the charset for all tables.');
            case 'ShowDbStructureCharset_name':
                return __PMA_TRANSL('Show table charset');
            case 'ShowFieldTypesInDataEditView_desc':
                return __PMA_TRANSL(
                    'Defines whether or not type fields should be initially displayed in ' .
                    'edit/insert mode.'
                );
            case 'ShowFieldTypesInDataEditView_name':
                return __PMA_TRANSL('Show field types');
            case 'ShowFunctionFields_desc':
                return __PMA_TRANSL('Display the function fields in edit/insert mode.');
            case 'ShowFunctionFields_name':
                return __PMA_TRANSL('Show function fields');
            case 'ShowHint_desc':
                return __PMA_TRANSL('Whether to show hint or not.');
            case 'ShowHint_name':
                return __PMA_TRANSL('Show hint');
            case 'ShowPhpInfo_desc':
                return __PMA_TRANSL(
                    'Shows link to [a@https://php.net/manual/function.phpinfo.php]phpinfo()[/a] ' .
                    'output.'
                );
            case 'ShowPhpInfo_name':
                return __PMA_TRANSL('Show phpinfo() link');
            case 'ShowServerInfo_name':
                return __PMA_TRANSL('Show detailed MySQL server information');
            case 'ShowSQL_desc':
                return __PMA_TRANSL('Defines whether SQL queries generated by phpMyAdmin should be displayed.');
            case 'ShowSQL_name':
                return __PMA_TRANSL('Show SQL queries');
            case 'RetainQueryBox_desc':
                return __PMA_TRANSL('Defines whether the query box should stay on-screen after its submission.');
            case 'RetainQueryBox_name':
                return __PMA_TRANSL('Retain query box');
            case 'ShowStats_desc':
                return __PMA_TRANSL('Allow to display database and table statistics (eg. space usage).');
            case 'ShowStats_name':
                return __PMA_TRANSL('Show statistics');
            case 'SkipLockedTables_desc':
                return __PMA_TRANSL('Mark used tables and make it possible to show databases with locked tables.');
            case 'SkipLockedTables_name':
                return __PMA_TRANSL('Skip locked tables');
            case 'SQLQuery_Edit_name':
                return __PMA_TRANSL('Edit');
            case 'SQLQuery_Explain_name':
                return __PMA_TRANSL('Explain SQL');
            case 'SQLQuery_Refresh_name':
                return __PMA_TRANSL('Refresh');
            case 'SQLQuery_ShowAsPHP_name':
                return __PMA_TRANSL('Create PHP code');
            case 'SuhosinDisableWarning_desc':
                return __PMA_TRANSL(
                    'Disable the default warning that is displayed on the main page if Suhosin is ' .
                    'detected.'
                );
            case 'SuhosinDisableWarning_name':
                return __PMA_TRANSL('Suhosin warning');
            case 'LoginCookieValidityDisableWarning_desc':
                return __PMA_TRANSL(
                    'Disable the default warning that is displayed on the main page if the value ' .
                    'of the PHP setting session.gc_maxlifetime is less than the value of ' .
                    '`LoginCookieValidity`.'
                );
            case 'LoginCookieValidityDisableWarning_name':
                return __PMA_TRANSL('Login cookie validity warning');
            case 'TextareaCols_desc':
                return __PMA_TRANSL(
                    'Textarea size (columns) in edit mode, this value will be emphasized for SQL ' .
                    'query textareas (*2).'
                );
            case 'TextareaCols_name':
                return __PMA_TRANSL('Textarea columns');
            case 'TextareaRows_desc':
                return __PMA_TRANSL(
                    'Textarea size (rows) in edit mode, this value will be emphasized for SQL ' .
                    'query textareas (*2).'
                );
            case 'TextareaRows_name':
                return __PMA_TRANSL('Textarea rows');
            case 'TitleDatabase_desc':
                return __PMA_TRANSL('Title of browser window when a database is selected.');
            case 'TitleDatabase_name':
                return __PMA_TRANSL('Database');
            case 'TitleDefault_desc':
                return __PMA_TRANSL('Title of browser window when nothing is selected.');
            case 'TitleDefault_name':
                return __PMA_TRANSL('Default title');
            case 'TitleServer_desc':
                return __PMA_TRANSL('Title of browser window when a server is selected.');
            case 'TitleServer_name':
                return __PMA_TRANSL('Server');
            case 'TitleTable_desc':
                return __PMA_TRANSL('Title of browser window when a table is selected.');
            case 'TitleTable_name':
                return __PMA_TRANSL('Table');
            case 'TrustedProxies_desc':
                return __PMA_TRANSL(
                    'Input proxies as [kbd]IP: trusted HTTP header[/kbd]. The following example ' .
                    'specifies that phpMyAdmin should trust a HTTP_X_FORWARDED_FOR ' .
                    '(X-Forwarded-For) header coming from the proxy 1.2.3.4:[br][kbd]1.2.3.4: ' .
                    'HTTP_X_FORWARDED_FOR[/kbd].'
                );
            case 'TrustedProxies_name':
                return __PMA_TRANSL('List of trusted proxies for IP allow/deny');
            case 'UploadDir_desc':
                return __PMA_TRANSL('Directory on server where you can upload files for import.');
            case 'UploadDir_name':
                return __PMA_TRANSL('Upload directory');
            case 'UseDbSearch_desc':
                return __PMA_TRANSL('Allow for searching inside the entire database.');
            case 'UseDbSearch_name':
                return __PMA_TRANSL('Use database search');
            case 'UserprefsDeveloperTab_desc':
                return __PMA_TRANSL(
                    'When disabled, users cannot set any of the options below, regardless of the ' .
                    'checkbox on the right.'
                );
            case 'UserprefsDeveloperTab_name':
                return __PMA_TRANSL('Enable the Developer tab in settings');
            case 'VersionCheck_desc':
                return __PMA_TRANSL('Enables check for latest version on main phpMyAdmin page.');
            case 'VersionCheck_name':
                return __PMA_TRANSL('Version check');
            case 'ProxyUrl_desc':
                return __PMA_TRANSL(
                    'The url of the proxy to be used when retrieving the information about the ' .
                    'latest version of phpMyAdmin or when submitting error reports. You need this ' .
                    'if the server where phpMyAdmin is installed does not have direct access to ' .
                    'the internet. The format is: "hostname:portnumber".'
                );
            case 'ProxyUrl_name':
                return __PMA_TRANSL('Proxy url');
            case 'ProxyUser_desc':
                return __PMA_TRANSL(
                    'The username for authenticating with the proxy. By default, no ' .
                    'authentication is performed. If a username is supplied, Basic ' .
                    'Authentication will be performed. No other types of authentication are ' .
                    'currently supported.'
                );
            case 'ProxyUser_name':
                return __PMA_TRANSL('Proxy username');
            case 'ProxyPass_desc':
                return __PMA_TRANSL('The password for authenticating with the proxy.');
            case 'ProxyPass_name':
                return __PMA_TRANSL('Proxy password');

            case 'ZipDump_desc':
                return __PMA_TRANSL('Enable ZIP compression for import and export operations.');
            case 'ZipDump_name':
                return __PMA_TRANSL('ZIP');
            case 'CaptchaLoginPublicKey_desc':
                return __PMA_TRANSL('Enter your public key for your domain reCaptcha service.');
            case 'CaptchaLoginPublicKey_name':
                return __PMA_TRANSL('Public key for reCaptcha');
            case 'CaptchaLoginPrivateKey_desc':
                return __PMA_TRANSL('Enter your private key for your domain reCaptcha service.');
            case 'CaptchaLoginPrivateKey_name':
                return __PMA_TRANSL('Private key for reCaptcha');

            case 'SendErrorReports_desc':
                return __PMA_TRANSL('Choose the default action when sending error reports.');
            case 'SendErrorReports_name':
                return __PMA_TRANSL('Send error reports');

            case 'ConsoleEnterExecutes_desc':
                return __PMA_TRANSL(
                    'Queries are executed by pressing Enter (instead of Ctrl+Enter). New lines ' .
                    'will be inserted with Shift+Enter.'
                );
            case 'ConsoleEnterExecutes_name':
                return __PMA_TRANSL('Enter executes queries in console');

            case 'ZeroConf_desc':
                return __PMA_TRANSL(
                    'Enable Zero Configuration mode which lets you setup phpMyAdmin '
                    . 'configuration storage tables automatically.'
                );
            case 'ZeroConf_name':
                return __PMA_TRANSL('Enable Zero Configuration mode');
            case 'Console_StartHistory_name':
                return __PMA_TRANSL('Show query history at start');
            case 'Console_AlwaysExpand_name':
                return __PMA_TRANSL('Always expand query messages');
            case 'Console_CurrentQuery_name':
                return __PMA_TRANSL('Show current browsing query');
            case 'Console_EnterExecutes_name':
                return __PMA_TRANSL('Execute queries on Enter and insert new line with Shift + Enter');
            case 'Console_DarkTheme_name':
                return __PMA_TRANSL('Switch to dark theme');
            case 'Console_Height_name':
                return __PMA_TRANSL('Console height');
            case 'Console_Mode_name':
                return __PMA_TRANSL('Console mode');
            case 'Console_GroupQueries_name':
                return __PMA_TRANSL('Group queries');
            case 'Console_Order_name':
                return __PMA_TRANSL('Order');
            case 'Console_OrderBy_name':
                return __PMA_TRANSL('Order by');
            case 'FontSize_name':
                return __PMA_TRANSL('Font size');
            case 'DefaultConnectionCollation_name':
                return __PMA_TRANSL('Server connection collation');
        }
        return null;
    }
}

