<?php

$DB_HOST = "localhost"; //change this to your ip address
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "pms";

$con=mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

if (!$con)
{
    die( "Unable to select database");
}

?>