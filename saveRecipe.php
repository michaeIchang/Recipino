<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 5:17 PM
 */

session_start();
$recipeSteps = $_POST['recipeSteps'];

$db_user = 'root';
$db_password = 'root';

$db = 'recipino';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
    $link,
    $host,
    $db_user,
    $db_password,
    $db,
    $port
);

$stmt = $link->prepare("INSERT INTO recipes (username, recipe_steps) VALUES (?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $SESSION['username'], $recipeSteps);
$stmt->execute();
$stmt->close();

$arr = array("user" => $_SESSION['username'], "steps" => $recipeSteps);

echo json_encode($arr);
?>