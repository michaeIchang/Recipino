    $(document).ready(function() {

        $( "#register-button").click(function() {
            // alert( "Handler for .click() called." );
            // e.preventDefault()
            var username = document.getElementById("register-username").value;
            var password = document.getElementById("register-password").value;
            // console.log(username);
            // console.log(password);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", "registration.php", true);
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.addEventListener("load", regCallBack, false);
            xmlHttp.send("username=" + username + "&password=" + password);
        });

        $( "#login-button").click(function() {
            // alert( "Handler for .click() called." );
            // e.preventDefault()
            var username = document.getElementById("login-username").value;
            var password = document.getElementById("login-password").value;
            // console.log(username);
            // console.log(password);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", "signIn.php", true);
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.addEventListener("load", loginCallBack, false);
            xmlHttp.send("username=" + username + "&password=" + password);
        });

        $("#sign-out").click(function () {
            window.location.href = "/";
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", "signOut.php", true);
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlHttp.send();
        });

        $("#submit-recipe").click(function () {
            // alert( "Handler for .click() called." );
            // e.preventDefault()

            if (document.getElementById("preview").style.display !== 'none') {
              var ingredients = document.getElementById("ingredients").value;
              var steps = document.getElementById("steps").value;
              var xmlHttp = new XMLHttpRequest();
              xmlHttp.open("POST", "recipe.php", true);
              xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              // xmlHttp.addEventListener("load", sendRecCallBack, false);
              // console.log(recipeSteps);
              // console.log(recipeIngredients);
              xmlHttp.send("steps=" + steps + "&ingredients=" + ingredients);
              return;
            }


            var recipes = document.getElementsByClassName("list-group-item");
            var i = 0;
            for (i; i < recipes.length; ++i) {
                if (recipes[i].classList.contains('active')) {
                    break;
                }
            }

            var allSteps = document.getElementsByClassName("steps");
            var allIngredients = document.getElementsByClassName("ingredients");
            var recipeSteps = allSteps[i].value;
            var recipeIngredients = allIngredients[i].value;
            // var defaultStepNo = '0';
            // console.log(recipeSteps);
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open("POST", "recipe.php", true);
            xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // xmlHttp.addEventListener("load", sendRecCallBack, false);
            console.log(recipeSteps);
            console.log(recipeIngredients);
            xmlHttp.send("steps=" + recipeSteps + "&ingredients=" + recipeIngredients);
        });

        $("#save-recipe").click(function () {
            // alert( "Handler for .click() called." );
            // e.preventDefault()


            if (document.getElementById("preview").style.display != 'none') {
              var recipeName = document.getElementById("recipe-url").value;
              console.log("URL:" + recipeName);
              var recipeSteps = document.getElementById("steps").value;
              var recipeIngredients = document.getElementById("ingredients").value;
              var xmlHttp = new XMLHttpRequest();
              xmlHttp.open("POST", "saveRecipe.php", true);
              xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xmlHttp.addEventListener("load", saveRecCallBack, false);
              xmlHttp.send("recipeName=" + recipeName + "&recipeSteps=" + recipeSteps + "&recipeIngredients=" + recipeIngredients);
              return;
            }
            else {
              var recipes = document.getElementsByClassName("list-group-item");
              var i = 0;
              for (i; i < recipes.length; ++i) {
                  if (recipes[i].classList.contains('active')) {
                      break;
                  }
              }

              var recipeName = decodeURIComponent(recipes[i].innerText);
              console.log(recipeName);
              var recipesSteps = document.getElementsByClassName("steps");
              var recipesIngredients = document.getElementsByClassName("ingredients");
              var recipeSteps = recipesSteps[i].value;
              var recipeIngredients = recipesIngredients[i].value;
              // console.log(recipeSteps);
              var xmlHttp = new XMLHttpRequest();
              xmlHttp.open("POST", "saveRecipe.php", true);
              xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xmlHttp.addEventListener("load", saveRecCallBack, false);
              xmlHttp.send("recipeName=" + recipeName + "&recipeSteps=" + recipeSteps + "&recipeIngredients=" + recipeIngredients);
            }
        });

        $("#add-url-recipe").click(function (){
          // var url = document.getElementById('recipe-url').value;
          //
          // var xmlHttp = new XMLHttpRequest();
          // xmlHttp.open("POST", "processURL.php", true);
          // xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          // xmlHttp.addEventListener("load", urlCallBack, false);
          // xmlHttp.send("url=" + url);

        });

        // $("#step-back").click(function () {
        //     var stepNo = document.getElementById("step-no").innerText;
        //     var stepArr = stepNo.split(" ");
        //
        //     var xmlHttp = new XMLHttpRequest();
        //     xmlHttp.open("POST", "changeStep.php", true);
        //     xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //     xmlHttp.addEventListener("load", changeStepCallBack, false);
        //     var newStep = parseInt(stepArr[1]) - 1;
        //     xmlHttp.send("stepNo=" + newStep);
            // console.log(newStep);
        // });

        // $("#step-next").click(function () {
        //     var stepNo = document.getElementById("step-no").innerText;
        //     var stepArr = stepNo.split(" ");
        //
        //     var xmlHttp = new XMLHttpRequest();
        //     xmlHttp.open("POST", "changeStep.php", true);
        //     xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //     xmlHttp.addEventListener("load", changeStepCallBack, false);
        //     var newStep = parseInt(stepArr[1]) + 1;
        //     xmlHttp.send("stepNo=" + newStep);
        //     // console.log(newStep);
        // });
    });

    // function changeStepCallBack(event) {
    //     var plainText = event.target.responseText;
    //     var jsonData = JSON.parse(plainText);
    //     console.log(jsonData.stepNo);
    //     if (parseInt(jsonData.stepNo) > 0) {
    //         document.getElementById("step-back").disabled = false;
    //     } else {
    //         document.getElementById("step-back").disabled = true;
    //     }
    //
    //     document.getElementById("step-no").innerText = "Step " + jsonData.stepNo;
    // }

    // function sendRecCallBack(event) {
    //     var plainText = event.target.responseText;
    //     var jsonData = JSON.parse(plainText);
        // console.log(jsonData);
        // document.getElementById("step-back").style.display = 'inline-block';
        // document.getElementById("step-no").style.display = 'inline-block';
        // document.getElementById("step-next").style.display = 'inline-block';
    // }



    function saveRecCallBack(event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.user);
        // console.log(jsonData.recipeName);
        // console.log(jsonData.steps);
    }

    function regCallBack (event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.regStatus);
        console.log(jsonData.alreadyRegistered);
        console.log(jsonData.crypt);
        if (jsonData.alreadyRegistered == false) {
            // document.getElementById("carousel").style.display = 'none';
            // document.getElementById("register").style.display = 'none';
            // document.getElementById("sign-in").style.display = 'none';
            // document.getElementById("recipes").style.display = 'block';
            // document.getElementById("sign-out").style.display = 'inline-block';
            // document.getElementById("save-recipe").style.display = 'inline-block';
            // document.getElementById("submit-recipe").style.display = 'inline-block';
            // document.getElementsByClassName("jumbotron")[0].style.display = 'none';
            // document.getElementById("main-nav").style.display = 'block';
            getRecipes();
        }
    }

    function getRecipes() {
        // var username = document.getElementById("login-username").value;
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("POST", "getRecipes.php", true);
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlHttp.addEventListener("load", getRecipeCallBack, false);
        // xmlHttp.send("username=" + username);
    }

    function getRecipeCallBack(event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.recipe1);
        // console.log(jsonData.steps1);
        // console.log(jsonData.recipe2);
        // console.log(jsonData.steps2);
        var tab_list = document.getElementById("list-tab");
        tab_list.innerHTML = "";
        // console.log("hi");
        var tab_content = document.getElementById("nav-tab-content");
        tab_content.innerHTML = "";

      //   <div class="tab-pane fade show active" id="list-custom" role="tabpanel" aria-labelledby="default-recipe">
      //     <div class="form-row">
      //       <div class="form-group col-md-6">
      //         <label for="recipe-ing-0"><b>Ingredients</b></label>
      //         <textarea class="form-control ingredients" id="recipe-ing-1" rows="9"></textarea>
      //       </div>
      //       <div class="form-group col-md-6">
      //         <label for="recipe-steps-0"><b>Steps</b></label>
      //         <textarea class="form-control steps" id="recipe-steps-1" rows="9"></textarea>
      //       </div>
      //     </div>
      // </div>
      //
      // <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">

        // var ingredientsList = "";

        // for (i; i < recipeList.length; ++i) {
            // if (recipeList[i].id == jsonData[2*i + 1]) {
                if (jsonData.recipe.length > 7) {
                  $("#list-tab-div").attr("style", "height: 400px; overflow-y: scroll;");
                }

                for (var i = 0; i < jsonData.recipe.length; ++i) {
                  //create tab
                  var tab = document.createElement("a");
                  var tab_text = document.createTextNode(jsonData.recipe[i]);
                  tab.appendChild(tab_text);
                  tab.className = "list-group-item list-group-item-action";
                  if (i == 0) {
                    tab.className = "list-group-item list-group-item-action active show";
                  }
                  // $(".list-group-item").attr("class", "list-group-item list-group-item-action");
                  // tab.data-toggle = "list";
                  $(".list-group-item").attr("data-toggle", "list");
                  tab.href = "#recipe-" + (i+1);
                  $(".list-group-item").attr("role", "tab");
                  // tab.role = "tab";
                  tab_list.appendChild(tab);

                  // var br = document.createElement("br");
                  // tab_list.appendO)

                  var tab_pane = document.createElement("div");
                  tab_pane.className = "tab-pane fade";
                  if (i == 0) {
                    tab_pane.className = "tab-pane fade show active";
                  }
                  tab_pane.role = "tabpanel";
                  tab_pane.id = "recipe-" + (i+1);

                  var row = document.createElement("div");
                  row.className = "form-row";

                  var ingDiv = document.createElement("div");
                  ingDiv.className = "form-group col-md-6";
                  var stepDiv = document.createElement("div");
                  stepDiv.className = "form-group col-md-6";

                  var ingLabel = document.createElement("label");
                  ingLabel.for = "ing-label-" + (i + 1);
                  ingLabel.innerText = "Ingredients";
                  var stepLabel = document.createElement("label");
                  stepLabel.for = "step-label-" + (i + 1);
                  stepLabel.innerText = "Steps";

                  var ingText = document.createElement("textarea");
                  ingText.className = "form-control";
                  ingText.className += " ingredients";
                  // $(".list-group-item").attr("role", "tab");
                  ingText.id = "ing-" + (i + 1);
                  ingText.rows = "9";
                  ingText.value = jsonData.ingredients[i];
                  ingText.style.height = "350px";
                  var stepText = document.createElement("textarea");
                  stepText.className = "form-control";
                  stepText.className += " steps";
                  stepText.id = "step-" + (i + 1);
                  stepText.rows = "9";
                  stepText.value = jsonData.steps[i];
                  stepText.style.height = "350px";

                  ingDiv.appendChild(ingLabel);
                  ingDiv.appendChild(ingText);
                  stepDiv.appendChild(stepLabel);
                  stepDiv.appendChild(stepText);

                  row.appendChild(ingDiv);
                  row.appendChild(stepDiv);

                  tab_pane.appendChild(row);

                  tab_content.appendChild(tab_pane);
                }

                // stepList[0].value = jsonData.steps1;
                // stepList[1].value = jsonData.steps2;
                // stepList[2].value = jsonData.steps3;
                // stepList[3].value = jsonData.steps4;
                // stepList[4].value = jsonData.steps5;
                // stepList[5].value = jsonData.steps6;
                //
                // ingredientsList[0].value = jsonData.ingredients1;
                // ingredientsList[1].value = jsonData.ingredients2;
                // ingredientsList[2].value = jsonData.ingredients3;
                // ingredientsList[3].value = jsonData.ingredients4;
                // ingredientsList[4].value = jsonData.ingredients5;
                // ingredientsList[5].value = jsonData.ingredients6;
                // console.log(jsonData[2*i+1]);
            // }
        // }
        $(".list-group-item").attr("data-toggle", "list");
        $(".list-group-item").attr("role", "tab");
    }

    function loginCallBack (event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.regStatus);
        // console.log(jsonData.registered);
        // console.log(jsonData.cnt);
        // console.log(jsonData.check);
        if (jsonData.registered == true) {
            document.getElementById("carousel").style.display = 'none';
            document.getElementById("register").style.display = 'none';
            document.getElementById("sign-in").style.display = 'none';
            // document.getElementById("recipes").style.display = 'block';
            // document.getElementById("sign-out").style.display = 'inline-block';
            // document.getElementById("save-recipe").style.display = 'inline-block';
            // document.getElementById("submit-recipe").style.display = 'inline-block';
            // document.getElementById('mode').style.display = 'block';
            document.getElementsByClassName("jumbotron")[0].style.display = 'none';
            // document.getElementById("main-nav").style.display = 'block';
            // document.getElementById("recipe-steps").style.display = 'block';
            // document.getElementById('url-input').style.display = 'inline-block';
            // getRecipes();
            window.location.href = "/home.html";
        }

    }

    function urlCallBack(event) {
      var plainText = event.target.responseText;
      var jsonData = JSON.parse(plainText);
      console.log(jsonData.ingredients);
      console.log(jsonData.steps);
      document.getElementById("ingredients").value = "";
      document.getElementById("steps").value = "";
      for (var i = 0; i < jsonData.ingredients.length; ++i) {
        document.getElementById("ingredients").value += $("<p/>").html(jsonData.ingredients[i]).text();
        document.getElementById("ingredients").value += "\n";
      }

      for (var i = 0; i < jsonData.steps.length; ++i) {
        document.getElementById("steps").value += $("<p/>").html(jsonData.steps[i]).text();
        document.getElementById("steps").value += "\n\n";
        // document.getElementById("ingredients").value += "\n";
        // document.getElementById("ingredients").value += "\n";
      }

      // document.getElementById("preview").innerText = "";
      // document.getElementById("list-links").innerText = "";
      // document.getElementById("list-pages").innerText = "";
      // console.log(jsonData.Pages.length);
      // var counter = 1;
      // for (var i = 0; i < jsonData.Pages.length; ++i) {
      //   var page = jsonData.Pages[i];
      //   var newLink = document.createElement('a');
      //   newLink.className = 'list-group-item list-group-item-action';
      //   newLink.href = "#list-item-" + (i+1);
      //   newLink.innerText = "Page " + (i+1);
      //   var newHeader = document.createElement('h4');
      //   newHeader.id = "list-item-" + (i+1);
      //   newHeader.innerText = "Page " + (i+1);
      //   var newParagraph = document.createElement('p');
      //   for (var j = 0; j < page.length; ++j) {
          // var newLine = document.createElement('p');
          // var textNode = $('<p/>').html(page[j]).text();         // Create a text node
          // var newContent = ;
          // newParagraph.innerText += textNode;
          // newParagraph.innerText += "\n";
          // var newBreak = document.createElement('br');

          // document.getElementById("preview").appendChild(newBreak);
          // newPage.appendChild(newLine);
        // }
        // document.getElementById("list-links").appendChild(newLink);
        // document.getElementById("list-pages").appendChild(newHeader);
        // document.getElementById("list-pages").appendChild(newParagraph);
        // document.getElementById("preview").appendChild(document.createElement("br"));
      // }
      document.getElementById("preview").style.visibility = 'visible';
      // document.getElementById('url-input').style.display = 'none';
      // document.getElementById("url-next").style.display = 'none';
      // document.getElementById("add-url-recipe").style.display = 'block';
      // document.getElementById("add-url-recipe").style.margin = '0 auto';
      // document.getElementById("list-links").style.display = 'block';
      // document.getElementById("list-pages").style.display = 'block';
    }
    function recipeParse () {
      var url = document.getElementById('recipe-url').value;
      var xmlHttp = new XMLHttpRequest();
      xmlHttp.open("POST", "processURL.php", true);
      xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xmlHttp.addEventListener("load", urlCallBack, false);
      xmlHttp.send("url=" + url);
    }

    $('#url-label').click(function (){
      document.getElementById('user-recipes').style.display = 'none';
      document.getElementById('url-input-form').style.display = 'inline-block';
      // if (document.getElementById('recipe-url').value !== null) {
        document.getElementById('preview').style.display = "block";
      // }
      // document.getElementById('save-recipe').style.display = 'none';
      // document.getElementById('submit-recipe').style.display = 'none';
      // document.getElementById('add-url-recipe').style.display = 'none';
      // document.getElementById('preview').style.display = 'none';
      // document.getElementById('url-next').style.display = 'inline-block';
    });

    $('#text-label').click(function () {
      document.getElementById('url-input-form').style.display = 'none';
      document.getElementById('user-recipes').style.display = 'inline-block';
      document.getElementById('preview').style.display = "none";
      // console.log("henlo");
      // document.getElementById('save-recipe').style.display = 'inline-block';
      // document.getElementById('submit-recipe').style.display = 'inline-block';
      // document.getElementById('add-url-recipe').style.display = 'none';
      // document.getElementById('preview').style.display = 'none';
      // document.getElementById('url-next').style.display = 'none';
      // window.scrollTo(0,1000);
      // document.getElementsByClassName("nav-link")[1].class = "nav-link active";
      // var tab_list = document.getElementById("list-tab");
      // var myNode = document.getElementById("foo");
      // while (tab_list.firstChild) {
      //     tab_list.removeChild(tab_list.firstChild);
      // }
      // var tab_content = document.getElementById("nav-tab-content");
      // tab_content.innerText = "";
      var xmlHttp = new XMLHttpRequest();
      xmlHttp.open("POST", "getRecipes.php", true);
      xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xmlHttp.addEventListener("load", getRecipeCallBack, false);
      xmlHttp.send();
    });

    function matchURL() {
      var e = document.getElementById("inputState");
      var url = e.options[e.selectedIndex].value;
      document.getElementById("recipe-url").value = url;
    }
