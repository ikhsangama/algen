<?php
 
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'algen');
 


$host="mysql.idhostinger.com";
$username="u267036507_user";
$password="beryorindi";
$database="u267036507_ta";


/**
 * $dbconnect : koneksi kedatabase
 */
//$dbconnect = new mysqli($host, $username, $password, $database);

$dbconnect = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 
/**
 * Check Error yang terjadi saat koneksi
 * jika terdapat error maka die() // stop dan tampilkan error
 */
if ($dbconnect->connect_error) {
    die('Database Not Connect. Error : ' . $dbconnect->connect_error);
}