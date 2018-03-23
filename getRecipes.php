<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/26/2018
 * Time: 3:03 AM
 */
session_start();
require 'database.php';

$username = $_POST['username'];

$stmt = $mysqli->prepare("SELECT recipe_name, recipe_steps, recipe_ing FROM recipes WHERE username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($recipe_name, $recipe_steps, $recipe_ing);
//$stmt->fetch();
$arr = array();
$cnt = 1;

while($stmt->fetch()){
//    array_push($arr, "recipe" . $cnt, $recipe_name);
//    array_push($arr, "steps" . $cnt, $recipe_steps);
    $arr["recipe" . $cnt] = $recipe_name;
    $arr["steps" . $cnt] = $recipe_steps;
    $arr["ingredients" .$cnt] = $recipe_ing;
    $cnt = $cnt + 1;
}
$stmt->close();



echo json_encode($arr);
?>