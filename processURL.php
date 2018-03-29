<?php
include('./simple_html_dom.php');
// $url = $_POST['url'];

$url = 'https://www.epicurious.com/recipes/food/views/classic-omelette-15068';

// get DOM from URL or file
$html = file_get_html($url);

// $ingGroups = $html->find('ol[class=ingredient-groups]');
//
// foreach($ingGroups->find('li[class=ingredient-group]') as $ingGroup)
//   foreach($ingGroup->find('ul') as $ingredients)
//     foreach($ingredients->find('li') as $ingredient)
//       echo $ingredient;

$ingredients = array();

foreach($html->find('li[class=ingredient]') as $element) {
       $ingredients[] = ($element -> plaintext);
}

$steps = array();

foreach($html->find('li[class=preparation-step]') as $element) {
       $steps[] = ($element -> plaintext);
}

$lineLength = 30;

// echo $html->getElementsByClassName("ingredient");
// echo json_encode($ingredients);
// echo json_encode($steps);

$allIngredientPages = array();
$ingredientPage = array();
for ($i = 0; $i < count($ingredients); $i++) {
   $ingredients[$i] = str_replace("\n", '', $ingredients[$i]);
   $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);

   $lineCnt = (int) ((mb_strlen($ingredients[$i]) / $lineLength) + 1);

   $words = explode(' ', $ingredients[$i]);

   for ($j = 0; $j < $lineCnt; ++$j) {
       $line = "";
       while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
           $line = $line . array_shift($words) . ' ';
       }
       $ingredientPage [] = $line;
   }

   if (count($ingredientPage) >= 8 || ($i == count($ingredients) - 1)) {
     $allIngredientPages[] = $ingredientPage;
     $ingredientPage = array();
   }
}

$allStepPages = array();
$stepPage = array();
for ($i = 0; $i < count($steps); $i++) {
    $steps[$i] = str_replace("\n", '', $steps[$i]);
    $steps[$i] = str_replace("\\", '', $steps[$i]);
    $lineCnt = (int) ((mb_strlen($steps[$i]) / $lineLength) + 1);

    $words = explode(' ', $steps[$i]);

    for ($j = 0; $j < $lineCnt; ++$j) {
        $line = "";
        while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
            $line = $line . array_shift($words) . ' ';
        }
        if ($line != "") {
          $stepPage [] = $line;
        }
    }

    if (count($stepPage) >= 8 || ($i == (count($steps) - 1))) {
      $allStepPages[] = $stepPage;
      $stepPage = array();
    }
}

$ingredients = array_filter($allIngredientPages);
$steps = array_filter($allStepPages);
$arr["Pages"] = array_merge($ingredients, $steps);
file_put_contents('recipe.json', json_encode($arr));
echo json_encode($arr);


?>
