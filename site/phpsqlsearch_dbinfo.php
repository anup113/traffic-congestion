<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "test_database";

@mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not collect to Mysql");
@mysql_select_db("$db_name") or die ("No connecton");

echo"Successful Connection";
?>