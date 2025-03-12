<?php
define("DATABASE", "bill-order");//////////////////////////////////////////////
define("USERNAME", "root");
define("PASSWORD", "");///////////////////////////////////////////////////////
define("LOCALHOST", "localhost");////////////////////////////////////////////*/
$connect = mysqli_connect(LOCALHOST,USERNAME,PASSWORD,DATABASE) or die("Database connection error");///////////////
mysqli_query($connect,"set names 'utf8'");/////////////////////////////////////
date_default_timezone_set('America/New_York');