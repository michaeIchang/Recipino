<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 5:17 PM
 */
include('./simple_html_dom.php');
session_start();

$recipeName = $_POST['recipeName'];
// $recipeName = 'Slow Cooker Corned Beef Brisket with Cabbage, Potatoes & Dill';
if (filter_var($recipeName, FILTER_VALIDATE_URL)) {
  $html = file_get_html($recipeName);
  $recipeName = trim(($html->find('title', 0))->plaintext);
}
$recipeSteps = $_POST['recipeSteps'];
$recipeIngredients = $_POST['recipeIngredients'];

//$recipeName = 'Chocolate Chip Cookies';
//$recipeSteps = 'test2';

require 'database.php';

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM recipes WHERE username=? AND recipe_name=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $_SESSION['username'], $recipeName);
$stmt->execute();
$stmt->bind_result($cnt);
$stmt->fetch();
$stmt->close();

if($cnt == 1) {
    $stmt2 = $mysqli->prepare("UPDATE recipes SET recipe_steps=?, recipe_ingredients=? WHERE username=? AND recipe_name=?");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('ssss', $recipeSteps, $recipeIngredients, $_SESSION['username'], $recipeName);
    $stmt2->execute();
    $stmt2->close();
}
else {
    $stmt2 = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_ingredients, recipe_steps) VALUES (?, ?, ?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('ssss', $_SESSION['username'], $recipeName, $recipeIngredients, $recipeSteps);
    $stmt2->execute();
    $stmt2->close();
}

// $arr = array("steps" => $recipeSteps);
// echo htmlspecialchars($recipeName);

// echo json_encode($arr);
?>
