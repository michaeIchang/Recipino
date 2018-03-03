<?php
$recipe = $_POST['recipeSteps'];
$stepNo = $_POST['stepNo'];

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
//$ingredients = $recipeArr[0];
//$steps = $recipeArr[1];

//$realIngredients = array();
for ($i = 0; $i < count($ingredients); $i++) {

    $ingredients[$i] = str_replace("\n", '', $ingredients[$i]);
    $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);

//    $lineCnt = (strlen($ingredients[$i]) / 32) + 1;
//    $realIngredient = array();
//    for ($j = 1; $j < $lineCnt; ++$j) {
//        $temp = substr($ingredients[$i], 0, 32 * $j);
//        $realIngredient[] = $temp;
//    }
//    $realIngredients[] = $realIngredient;
}

$realSteps = array();
for ($i = 0; $i < count($steps); $i++) {
    $steps[$i] = str_replace("\n", '', $steps[$i]);
    $steps[$i] = str_replace("\\", '', $steps[$i]);

    $lineCnt = (int) ((strlen($steps[$i]) / 37) + 1);
    $realStep = array();
//    if ($lineCnt > 1 ) {
        for ($j = 0; $j < $lineCnt; ++$j) {
            $realStep[] = substr($steps[$i], 32 * ($j), 32 * ($j+1));
        }
//    }
    $realSteps[] = $realStep;
}

$ingredients = array_filter($ingredients);
$steps = array_filter($realSteps);


$arr["Step Number"] = $stepNo;
$arr["Ingredients"] = $ingredients;
$arr["Steps"] = $realSteps;

//$fp = fopen('recipe.json', 'w');
//fwrite($fp, json_encode($arr));
//fclose($fp)

file_put_contents('recipe.json', json_encode($arr));

echo json_encode($arr);
//header("recipe.json");

?>