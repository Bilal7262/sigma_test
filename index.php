<?php
include('db.php');
session_start();

require_once __DIR__ .'/stripe-php/init.php';



$actual_link = $_SERVER['REQUEST_URI'];
$actual_link = substr($actual_link, 1);
$link = explode('/',$actual_link);
$link = $link[sizeof($link) - 1 ];

//Breaking the URL
$link_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = explode('/', $link_path);
$mid_link = $folder[2];

// echo $link;
// echo $mid_link;

if($mid_link == "api")
    include('route.php');
else
    include('include/front_route.php');

