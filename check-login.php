<?php
session_start();
require 'config.php';
 
if ( isset($_POST['username']) && isset($_POST['password']) ) {
    
    $sql_check = "SELECT nama
                  FROM admin 
                  WHERE 
                       username=? 
                       AND 
                       password=? 
                  LIMIT 1";
 
    $check_log = $dbconnect->prepare($sql_check);
    $check_log->bind_param('ss', $username, $password);
 
    $username = $_POST['username'];
    $password = md5( $_POST['password'] );
 
    $check_log->execute();
 
    $check_log->store_result();
 
    if ( $check_log->num_rows == 1 ) {
        $check_log->bind_result($nama);
 
        while ( $check_log->fetch() ) {
            $_SESSION['nama'] = $nama;
            $_SESSION['username'] = $username;
        }
		$_SESSION['user_login']='admin';
        $check_log->close();
 
        header('location:admin');
        exit();
 
    } else {
        header('location: login.php?error='.base64_encode('Username dan Password Invalid!!!'));
        exit();
    }
 
   
} else {
    header('location:login.php');
    exit();
}