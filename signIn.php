<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/26/2018
 * Time: 1:59 AM
 */
session_start();

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

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT password from users WHERE username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($realPass);
$stmt->fetch();
$stmt->close();


$registered = false;
if (password_verify($password, $realPass)){
    $registered = true;
    $_SESSION['username'] = $username;
}

$arr = array("cnt" => $username,  "registered" => $registered, "check" => password_verify($password, $realPass));

echo json_encode($arr);
?>