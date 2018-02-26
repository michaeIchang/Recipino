<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/25/2018
 * Time: 5:17 PM
 */

session_start();
$recipeName = $_POST['recipeName'];
$recipeSteps = $_POST['recipeSteps'];

//$recipeName = 'Chocolate Chip Cookies';
//$recipeSteps = 'test2';

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

$stmt = $link->prepare("SELECT COUNT(*) FROM recipes WHERE username=? AND recipe_name=?");
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
    $stmt2 = $link->prepare("UPDATE recipes SET recipe_steps=? WHERE username=? AND recipe_name=?");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('sss', $recipeSteps, $_SESSION['username'], $recipeName);
    $stmt2->execute();
    $stmt2->close();
}
else {
    $stmt2 = $link->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps) VALUES (?, ?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('sss', $_SESSION['username'], $recipeName, $recipeSteps);
    $stmt2->execute();
    $stmt2->close();
}





$arr = array("steps" => $recipeSteps);

echo json_encode($arr);
?>