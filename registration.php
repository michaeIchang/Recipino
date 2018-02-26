<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 3:31 AM
 */
session_start();
require 'database.php';

$username = $_POST['username'];
$_SESSION['username'] = $username;
$password = $_POST['password'];

$stmt = $link->prepare("SELECT COUNT(*) from users WHERE username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $username);
$stmt->bind_result($cnt);
$stmt->execute();

$stmt->close();

$status = "signed-in";
if ($realPass == $password) {
    $status = "signed-out";
} else {
    $stmt = $link->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('ss', $username, $password);
    $stmt->bind_result($cnt);
    $stmt->execute();

    $stmt->close();
}

$arr = array("regStatus" => $status, "username" => $_SESSION['username']);

echo json_encode($arr);

?>