<?php

/* 
Template Name: Test 
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');



$url_test =get_template_directory() . '/webservice/ws-test.php';
require_once($url_test);




callWSPelostopTest(1968);



exit();










