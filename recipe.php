<?php
$value = $_POST['recipeSteps'];

$myfile = fopen("recipe.html", "w") or die("Unable to open file!");
fwrite($myfile, $value);
fclose($myfile);

$arr = array("steps" => $value);

echo $arr;

?>