<?php
$recipe = $_POST['recipeSteps'];

//$myfile = fopen("recipe.html", "w") or die("Unable to open file!");
//fwrite($myfile, $recipe);
//fclose($myfile);

//$recipeWords = str_split($recipe);
//
//$readIngredients = false;
//$readSteps = false;

//$ingredients = array();
//$steps = array();


function isEmpty($var){
    return empty($var);
}

$recipeArr = explode("Ingredients", $recipe);
$recipeArr = explode("Method", $recipeArr[1]);
//$recipeArr = json_encode($recipeArr);
$ingredients = explode("\n", $recipeArr[0]);
$steps = explode("\n", $recipeArr[1]);



for ($i = 0; $i < count($ingredients); $i++) {
    $ingredients[$i] = str_replace("\r", '', $ingredients[$i]);
//    $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);

}

for ($i = 0; $i < count($steps); $i++) {
    $steps[$i] = str_replace("\r", '', $steps[$i]);
//    $steps[$i] = str_replace("\\", '', $steps[$i]);
}

$ingredients = array_filter($ingredients);
$steps = array_filter($steps);

$arr["Ingredients"] = $ingredients;
$arr["Steps"] = $steps;

//$fp = fopen('recipe.json', 'w');
//fwrite($fp, json_encode($arr));
//fclose($fp)

file_put_contents('recipe.json', json_encode($arr));

echo json_encode($arr);
//header("recipe.json");

?>