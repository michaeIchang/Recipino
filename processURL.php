<?php
include('./simple_html_dom.php');
$url = $_POST['url'];

// $url = 'http://www.geniuskitchen.com/recipe/kosher-perfect-matzo-balls-94412';
// $url = 'https://www.epicurious.com/recipes/food/views/classic-omelette-15068';
// $url = 'https://www.foodnetwork.com/recipes/food-network-kitchen/cadbury-deviled-eggs-5119490';
// $url = 'https://www.foodnetwork.com/recipes/amy-thielen/maple-bread-with-soft-cheese-2224757';
// $url = 'https://www.chowhound.com/recipes/chinese-garlic-eggplant-32058';
$host = parse_url($url, PHP_URL_HOST);
// echo $host;
// get DOM from URL or file
$html = file_get_html($url);
// echo $html;

// $ingGroups = $html->find('ol[class=ingredient-groups]');
//
// foreach($ingGroups->find('li[class=ingredient-group]') as $ingGroup)
//   foreach($ingGroup->find('ul') as $ingredients)
//     foreach($ingredients->find('li') as $ingredient)
//       echo $ingredient;

$ingredients = array();
$steps = array();

if ($host == 'www.epicurious.com') {
  //Epicurious
  foreach($html->find('li[class=ingredient]') as $element) {
         $ingredients[] = trim($element -> plaintext);
  }

  //Epicurious
  foreach($html->find('li[class=preparation-step]') as $element) {
         $steps[] = trim($element -> plaintext);
  }
}

else if ($host == 'www.foodnetwork.com') {
  // food-network-kitchen
  foreach($html->find('label[class=o-Ingredients__a-ListItemText]') as $ingredient) {
    $ingredients[] = trim($ingredient -> plaintext);
    // echo trim($ingredient -> plaintext);
  }

  //food-network-kitchen
  // $stepSection = $html->find('section[id=mod-recipe-method-1]');
  // $stepDiv = $html->find('div');
  foreach($html->find('p') as $step) {
    // echo "step";
    // if ($step) != 'Watch how to make this recipe.') {
      // $steps = explode('\n', $stepDiv -> plaintext);
      $stepText = ($step->plaintext);
      if (strpos($stepText, 'Copyright 2018 Television Food Network')) {
        break;
      }
      if (!strpos($stepText, 'Watch how to make this recipe')) {
        $steps[] = trim($stepText);
        // echo trim($stepText);
      }
    // }
    // echo "step";
  }
}
// echo "        ";

else if ($host == 'www.allrecipes.com') {
  foreach($html->find('span[class=recipe-ingred_txt]') as $element) {
      // $ingredients[] = trim($element -> plaintext);
      if (!(strpos(($element -> plaintext), 'Add all ingredients to list') !== false)) {
        $ingredients[] = trim($element -> plaintext);
      }
  }
  foreach($html->find('span[class=recipe-directions__list--item]') as $element) {
      $steps[] = trim($element -> plaintext);
  }
}

else if ($host == 'www.chowhound.com') {
  // $ingredientDiv = $html -> find('div[class=tasty-recipe-ingredients]');
  foreach($html->find('li[itemprop=ingredients]') as $element) {
    $ingredients[] = trim($element -> plaintext);
    // echo $ingredients[0];
  }
  // $step = $html -> find('.frr_wrap > ol:nth-child(1) > li:nth-child(1)');

  foreach($step->find('li') as $element) {
    $steps[] = $step -> plaintext;
  }
}

else if ($host == 'www.geniuskitchen.com') {
  $i = 0;
  foreach($html->find('ul[class=ingredient-list]') as $element) {
    foreach($element->find('li') as $item) {
      if ($i != 0) {
        $ingredients[] = trim($item -> plaintext);
      }
      else {
        ++$i;
      }

    }
    // echo trim($element -> plaintext);
    // echo "||||||||||||||||||||";
  }
  foreach($html->find('div[class=directions]') as $element) {
    foreach($element->find('li') as $item) {
      if (!(strpos(($item -> plaintext), 'Follow these instructions carefully.') !== false)) {
        if (!(strpos(($item -> plaintext), 'Submit a Correction') !== false)) {
          $steps[] = ($item -> plaintext);
        }
      }
    }
    // echo $element;
  }
}

// else if ($host == 'www.thekitchn.com')
//   foreach($html->find('ul[class=PostRecipeIngredientGroup__ingredients]') as $element) {
//     $ingredients[] = ($element -> plaintext);
//   }
//   foreach($html->find('div[class=typeset--longform]') as $element) {
//     $steps[] = ($element -> plaintext);
//   }
// }

// echo count($ingredients);
// echo count($steps);

// $lineLength = 36;

// echo $ingredients[0];
// echo $steps[0];

//MC
//Format ingredients and steps to fit onto display

// $ingredientHeader = "Ingredients";

// $allIngredientPages = array();
// $ingredientPage = array();
// $ingredientPage[] = $ingredientHeader;
// for ($i = 0; $i < count($ingredients); $i++) {
   // $ingredients[$i] = utf8_decode($ingredients[$i]);
   // $ingredients[$i] = str_replace("\n", '', $ingredients[$i]);
   // $ingredients[$i] = str_replace("\\", '', $ingredients[$i]);
   // $ingredients[$i] = str_replace("®", "", $ingredients[$i]);
   // $ingredients[$i] = str_replace("\\u00a0", "", $ingredients[$i]);
   // echo $ingredients[$i];

//    $lineCnt = (int) ((mb_strlen($ingredients[$i]) / $lineLength) + 1);
//
//    $words = explode(' ', $ingredients[$i]);
//    array_unshift($words, "" . ($i + 1) . ". ");
//    for ($j = 0; $j < $lineCnt; ++$j) {
//        $line = "";
//        while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
//            $line = $line . array_shift($words) . ' ';
//        }
//        //If line is not empty, add it.
//        if (!empty(trim($line))) {
//          $ingredientPage [] = trim($line);
//        }
//    }
//
//    if (count($ingredientPage) >= 11 || ($i == count($ingredients) - 1)) {
//      $allIngredientPages[] = $ingredientPage;
//      $ingredientPage = array();
//      // $ingredientPage[] = $ingredientHeader;
//    }
// }
//
// $allStepPages = array();
// $stepPage = array();
// $stepHeader = "                                          Steps                            ";
// $stepPage[] = $stepHeader;
// for ($i = 0; $i < count($steps); $i++) {
//     $steps[$i] = str_replace("\n", '', $steps[$i]);
//     $steps[$i] = str_replace("\\", '', $steps[$i]);
//     $steps[$i] = str_replace('&quot;', '"', $steps[$i]);
//     $ingredients[$i] = str_replace("®", '', $ingredients[$i]);
//     $lineCnt = (int) ((mb_strlen($steps[$i]) / $lineLength) + 1);
//
//     $words = explode(' ', $steps[$i]);
//     array_unshift($words, "" . ($i + 1) . ". ");
//     for ($j = 0; $j < $lineCnt; ++$j) {
//         $line = "";
//         while (count($words) > 0 && mb_strlen($line . $words[0]) <= $lineLength) {
//             $line = $line . array_shift($words) . ' ';
//         }
//         if (!empty(trim($line))) {
//           $stepPage [] = $line;
//         }
//         if (count($stepPage) >= 11) {
//           $allStepPages[] = $stepPage;
//           $stepPage = array();
//           // $stepPage[] = $stepHeader;
//         }
//     }
//     if ($i == (count($steps) - 1)) {
//       $allStepPages[] = $stepPage;
//       $stepPage = array();
//       // $stepPage[] = $stepHeader;
//     }
// }
//
// $ingredients = array_filter($allIngredientPages);
// $steps = array_filter($allStepPages);
// $arr["Pages"] = array_merge($ingredients, $steps);
//
// for ($i = 0; $i < count($arr["Pages"]); ++$i) {
//   $pageIndex = ($i + 1) . "/" . count($arr["Pages"]);
//   $numLines = count($arr["Pages"][$i]);
//   // echo $numLines . " ";
//   // echo "here";
//   for ($j = 0; (11 - ($numLines + $j)) > 0; ++$j) {
//         $arr["Pages"][$i][] = " ";
//   }
//
//   $arr["Pages"][$i][] = str_repeat(" ", 93 - strlen($pageIndex)) . $pageIndex;
// }

// for ($i = 0; $i < count($ingredients); ++$i) {
//   str_replace("&#8212;", "—", $ingredients[$i]);
// }

// for ($i = 0; $i < count($steps); ++$i) {
//   str_replace("&#8212;", "—", $steps[$i]);
// }

$arr["ingredients"] = $ingredients;
$arr["steps"] = $steps;

// file_put_contents('recipe.json', json_encode($arr));
echo json_encode($arr);
?>
