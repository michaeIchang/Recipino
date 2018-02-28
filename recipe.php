<?php
$recipe = $_POST['recipeSteps'];

$myfile = fopen("recipe.html", "w") or die("Unable to open file!");
fwrite($myfile, $recipe);
fclose($myfile);

$arr = array("steps" => $recipe);

echo $arr;

?>