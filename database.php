<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 5:18 PM
 */

$db_user = 'root';
$db_password = 'root';

$db = 'recipino';
$host = 'localhost';
$port = 8889;

$mysqli = mysqli_init();
$success = mysqli_real_connect(
    $mysqli,
    $host,
    $db_user,
    $db_password,
    $db,
    $port
);
?>