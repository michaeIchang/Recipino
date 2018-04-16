<?php
$postIngredients = $_POST['ingredients'];
$postSteps = $_POST['steps'];
$ingredients = explode("\n", $postIngredients);
$steps = explode("\n", $postSteps);

$lineLength = 36;

// echo $ingredients[0];
// echo $steps[0];

//MC
//Format ingredients and steps to fit onto display

// $ingredientHeader = "Ingredients";

$allIngredientPages = array();
$ingredientPage = array();
// $ingredientPage[] = $ingredientHeader;
for ($i = 0; $i < count($ingredients); $i++) {
   // $ingredients[$i] = utf8_decode($ingredients[$i]);
   $ingredients[$i] = str_replace("\n", '', $ingredients[$i]);
   $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);
   $ingredients[$i] = str_replace("®", "", $ingredients[$i]);
   // $ingredients[$i] = str_replace("\\u00a0", "", $ingredients[$i]);
   // echo $ingredients[$i];

   $lineCnt = (int) ((mb_strlen($ingredients[$i]) / $lineLength) + 1);

   $words = explode(' ', $ingredients[$i]);
   array_unshift($words, "" . ($i + 1) . ". ");
   for ($j = 0; $j < $lineCnt; ++$j) {
       $line = "";
       while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
           $line = $line . array_shift($words) . ' ';
       }
       //If line is not empty, add it.
       if (!empty(trim($line))) {
         $ingredientPage [] = trim($line);
       }
   }

   if (count($ingredientPage) >= 11 || ($i == count($ingredients) - 1)) {
     $allIngredientPages[] = $ingredientPage;
     $ingredientPage = array();
     // $ingredientPage[] = $ingredientHeader;
   }
}

$allStepPages = array();
$stepPage = array();
$stepHeader = "                                          Steps                            ";
$stepPage[] = $stepHeader;
for ($i = 0; $i < count($steps); $i++) {
    $steps[$i] = str_replace("\n", '', $steps[$i]);
    $steps[$i] = str_replace("\\", '', $steps[$i]);
    $steps[$i] = str_replace('&quot;', '"', $steps[$i]);
    $ingredients[$i] = str_replace("®", '', $ingredients[$i]);
    $lineCnt = (int) ((mb_strlen($steps[$i]) / $lineLength) + 1);

    $words = explode(' ', $steps[$i]);
    array_unshift($words, "" . ($i + 1) . ". ");
    for ($j = 0; $j < $lineCnt; ++$j) {
        $line = "";
        while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
            $line = $line . array_shift($words) . ' ';
        }
        if (!empty(trim($line))) {
          $stepPage [] = $line;
        }
        if (count($stepPage) >= 11) {
          $allStepPages[] = $stepPage;
          $stepPage = array();
          // $stepPage[] = $stepHeader;
        }
    }
    if ($i == (count($steps) - 1)) {
      $allStepPages[] = $stepPage;
      $stepPage = array();
      // $stepPage[] = $stepHeader;
    }
}

$ingredients = array_filter($allIngredientPages);
$steps = array_filter($allStepPages);
$arr["Pages"] = array_merge($ingredients, $steps);

for ($i = 0; $i < count($arr["Pages"]); ++$i) {
  $pageIndex = ($i + 1) . "/" . count($arr["Pages"]);
  $numLines = count($arr["Pages"][$i]);
  // echo $numLines . " ";
  // echo "here";
  for ($j = 0; (11 - ($numLines + $j)) > 0; ++$j) {
        $arr["Pages"][$i][] = " ";
  }

  $arr["Pages"][$i][] = str_repeat(" ", 93 - strlen($pageIndex)) . $pageIndex;
}


// $allIngredientPages = array();
// $ingredientPage = array();
// for ($i = 0; $i < count($ingredients); $i++) {
//    $ingredients[$i] = str_replace("\n", '', $ingredients[$i]);
//    $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);
//
//    $lineCnt = (int) ((mb_strlen($ingredients[$i]) / $lineLength) + 1);
//
//    $words = explode(' ', $ingredients[$i]);
//
//    for ($j = 0; $j < $lineCnt; ++$j) {
//        $line = "";
//        while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
//            $line = $line . array_shift($words) . ' ';
//        }
//        $ingredientPage [] = $line;
//        if (count($ingredientPage) >= 8) {
//          $allIngredientPages[] = $ingredientPage;
//          $ingredientPage = array();
//        }
//    }
//
//    if (($i == count($ingredients) - 1)) {
//      $allIngredientPages[] = $ingredientPage;
//      $ingredientPage = array();
//    }
// }
//
// $allStepPages = array();
// $stepPage = array();
// for ($i = 0; $i < count($steps); $i++) {
//     $steps[$i] = str_replace("\n", '', $steps[$i]);
//     $steps[$i] = str_replace("\\", '', $steps[$i]);
//     $lineCnt = (int) ((mb_strlen($steps[$i]) / $lineLength) + 1);
//
//     $words = explode(' ', $steps[$i]);
//
//     for ($j = 0; $j < $lineCnt; ++$j) {
//       if (count($stepPage) >= 8) {
//         $allStepPages[] = $stepPage;
//         $stepPage = array();
//       }
//         $line = "";
//         while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
//             $line = $line . array_shift($words) . ' ';
//         }
//         if ($line != "") {
//           $stepPage [] = $line;
//         }
//
//     }
//
//     if (($i == (count($steps) - 1)) {
//       $allStepPages[] = $stepPage;
//       $stepPage = array();
//     }
// }

// $ingredients = array_filter($allIngredientPages);
// $steps = array_filter($allStepPages);
// $arr["Pages"] = array_merge($ingredients, $steps);
file_put_contents('recipe.json', json_encode($arr));
echo json_encode($arr);
?>
