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
$password = $_POST['password'];
$crypt = password_hash($password, PASSWORD_DEFAULT);


$stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt);
$stmt->fetch();
$stmt->close();


$alreadyRegistered = false;
if ($cnt == 1){
    $alreadyRegistered = true;
} else {
    $_SESSION['username'] = $username;

    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('ss', $username, $crypt);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}

$recipe_name = 'Chocolate Chip Cookies';
$recipe_steps = '
Method
1. Cream the Butter and Sugars
2. Add Vanilla and Eggs - beat until incorporated
3. Add Flour, Baking Powder, Baking Soda, and Salt
4. When dough comes together, fold in chocolate chips - do not over-mix!
5. Using room-temperature dough, scoop into balls and place on a lined sheet tray, arranging them in a staggered pattern
6. Bake 350 for 10 minutes - when you remove them from the oven, drop the tray on the floor to "flatten" the cookies
7. When cool, store/serve appropriately';
$recipe_ing = 
'Ingredients
5 oz Butter
2/3 cup Brown Sugar
1/2 cup Granulated Sugar
1 ea Eggs
1 tsp Vanilla Extract
1 cup Cake Flour
3/4 cup Bread Flour
2/3 tsp Baking Soda
3/4 tsp Baking Powder
3/4 tsp Salt
8 oz Semi-sweet Chocolate Chips
';

$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps, recipe_ing) VALUES (?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssss', $username, $recipe_name, $recipe_steps, $recipe_ing);
$stmt->execute();
$stmt->close();

$recipe_name = 'Custom Recipe #1';
$recipe_steps = 'Custom Recipe';
$recipe_ing = 'Custom Recipe';

$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps, recipe_ing) VALUES (?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssss', $username, $recipe_name, $recipe_steps, $recipe_ing);
$stmt->execute();
$stmt->close();

$recipe_name = 'Custom Recipe #2';
$recipe_steps = 'Custom Recipe';
$recipe_ing = 'Custom Recipe';

$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps) VALUES (?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}


$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps, recipe_ing) VALUES (?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ssss', $username, $recipe_name, $recipe_steps, $recipe_ing);
$stmt->execute();
$stmt->close();

$recipe_name = 'Custom Recipe #3';
$recipe_steps = 'Custom Recipe';
$recipe_ing = 'Custom Recipe';

$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps, recipe_ing) VALUES (?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssss', $username, $recipe_name, $recipe_steps, $recipe_ing);
$stmt->execute();
$stmt->close();

$recipe_name = 'Custom Recipe #4';
$recipe_steps = 'Custom Recipe';
$recipe_ing = 'Custom Recipe';

$stmt = $mysqli->prepare("INSERT INTO recipes (username, recipe_name, recipe_steps, recipe_ing) VALUES (?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssss', $username, $recipe_name, $recipe_steps, $recipe_ing);
$stmt->execute();
$stmt->close();

$arr = array("alreadyRegistered" => $alreadyRegistered, "crypt" => $crypt);

echo json_encode($arr);
?>