

<?php 

//--------------------------------------------------------------------------------------------
//This config file is located in pucker-mob/httpsdocs/assets/php
define("PROJECT_ROOT", dirname(dirname(dirname(dirname(__FILE__ ))))); // e.g.: pucker-mob
define("PROJECT_HTTPDOCS", dirname(dirname(dirname(__FILE__ ))));// e.g.: pucker-mob/httpsdocs
define("PATH_ASSETS_PHP", PROJECT_HTTPDOCS.'/assets/php');// e.g.: pucker-mob/httpsdocs/assets/php



$current_directory = substr(pathinfo($_SERVER['SCRIPT_NAME'],PATHINFO_DIRNAME),1); //to insert path name 
echo "<br/>\$current_directory = $current_directory";
echo "<br/>";

echo "<br/>  PROJECT_ROOT   " .  PROJECT_ROOT;
echo "<br/>  PROJECT_HTTPDOCS   " .  PROJECT_HTTPDOCS;
echo "<br/>  PATH_ASSETS_PHP   " .  PATH_ASSETS_PHP;
echo "<br/>";
echo "<br/>_SERVER[\"DOCUMENT_ROOT\"]) " . $_SERVER['DOCUMENT_ROOT'] ;
echo "<br/>";

echo "<br/>  dirname x1   " .  dirname(__FILE__) ;
echo "<br/>  dirname x2   " .  dirname(dirname(__FILE__)) ;
echo "<br/>  dirname x3   " .  dirname(dirname(dirname(__FILE__))) ;
echo "<br/>  ";
echo "<br/>  __DIR__  =    "  . __DIR__ ;

	define("ROOT", dirname(dirname(dirname(__FILE__ ))));
echo "<br/>  ROOT  =    "  . ROOT;


if ($_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www")$local = true; else $local = FALSE;  

echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "\$local  = $local";
echo "<br/>";
echo 'Current PHP version: ' . phpversion();
echo "<br/>";
echo "<br/>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
 ?>


