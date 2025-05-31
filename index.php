<?php
session_start();

require "app/core/init.php";

//gets clean url name to use
$URL = $_GET['url'] ?? "home";
$URL = explode("/", $URL);

// gets what page number we are on
$page =$_GET['page'] ?? 1;
$page = (int)$page; // ensures page is an integer
$prev_page = $page <= 1 ? 1 : $page - 1;
$next_page = $page + 1;

//if filename entered exists, go to it otherwise go to page not found
$file = page(strtolower($URL[0]));
if(file_exists($file))
{
    require $file;
} else {
    require page("404");
}


