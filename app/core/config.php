<?php 

if($_SERVER['SERVER_NAME'] == "localhost")
{
	//for local server
	define("ROOT", "http://localhost/indoorgolfdirgit");

	define("DBDRIVER", "mysql");
	define("DBHOST", "localhost");
	define("DBUSER", "root");
	define("DBPASS", "");
	define("DBNAME", "indoorgolf");

}else{
	//for online server
	define("ROOT", "http://www.indoorgolfdir.com");	

	define("DBDRIVER", "mysql");
	define("DBHOST", "localhost");
	define("DBUSER", "u630753873_webmaster");
	define("DBPASS", "IamMaster!!1");
	define("DBNAME", "u630753873_indoorgolf");
}

define('APP_NAME', "Indoor Golf");