<?php
/**
 * Created by IntelliJ IDEA.
 * User: micha
 * Date: 2/28/2018
 * Time: 4:39 PM
 */

$stepNo = $_POST['stepNo'];

$json = file_get_contents('recipe.json');
$decoded = json_decode($json, true);

$currStepNo = (int) preg_replace('/[^0-9]/', '', $decoded["Step Number"]);

if (count($decoded["Steps"]) >= $stepNo && $stepNo >= 0) {
    $currStepNo = $stepNo;
}

$decoded["Step Number"] = $currStepNo;

file_put_contents('recipe.json', json_encode($decoded));

$arr["stepNo"] = $currStepNo;

echo json_encode($arr);

?>