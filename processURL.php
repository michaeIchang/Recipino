<?php
include('./simple_html_dom.php');
$url = $_POST['url'];
$host = parse_url($url, PHP_URL_HOST);

// $url = 'http://www.geniuskitchen.com/recipe/kosher-perfect-matzo-balls-94412';
// $host = parse_url($url, PHP_URL_HOST);
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
  foreach($html->find('li[class=o-Ingredients__a-ListItem]') as $ingredient) {
    $ingredients[] = trim($ingredient -> plaintext);
    // echo "ingredient";
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
        $steps[] = trim($step -> plaintext);
      }
    // }
    // echo "step";
  }
}

else if ($host == 'www.allrecipes.com') {
  foreach($html->find('span[class=recipe-ingred_txt added]') as $element) {
      $ingredients[] = trim($element -> plaintext);
  }
  foreach($html->find('span[class=recipe-directions__list--item]') as $element) {
      $steps[] = trim($element -> plaintext);
  }
}

else if ($host == 'www.chowhound.com') {
  // $ingredientDiv = $html -> find('div[class=tasty-recipe-ingredients]');
  foreach($html->find('li[itemprop=ingredients]') as $element) {
    $ingredients[] = trim($element -> plaintext);
    echo $ingredients[0];
  }
  $stepDiv = $html -> find('div[itemprop=recipeInstructions]');
  // foreach($stepDiv->find('li') as $element) {
    $steps[] = explode('\n', trim($stepDiv->plaintext));
  // }
}

else if ($host == 'www.geniuskitchen.com') {
  foreach($html->find('ul[class=ingredient-list]') as $element) {
    $ingredients[] = trim($element -> plaintext);
  }
  foreach($html->find('ol[class=expanded]') as $element) {
    // $steps[] = ($element -> plaintext);
    echo $element;
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

$lineLength = 30;


//MC
//Format ingredients and steps to fit onto display

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
       //If line is not empty, add it.
       if (!empty(trim($line))) {
         $ingredientPage [] = trim($line);
       }
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
        if (!empty(trim($line))) {
          $stepPage [] = $line;
        }
        if (count($stepPage) >= 8) {
          $allStepPages[] = $stepPage;
          $stepPage = array();
        }
    }
    if ($i == (count($steps) - 1)) {
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
