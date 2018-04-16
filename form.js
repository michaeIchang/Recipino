
    // $("#submit").click(function () {
    //     console.log("here");
    //     $.post('recipe.php', 'val=' + document.getElementById("recipe").innerText, function (response) {
    //         alert(response);
    //     });
    // });
    // Variable to hold request
    var request;

    // Bind to the submit event of our form
    $("#foo").submit(function(event){

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();

        // Abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);

        // Let's select and cache all the fields
        var $inputs = $form.find("input, select, button, textarea");

        // Serialize the data in the form
        var serializedData = $form.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);

        // Fire off the request to /form.php
        request = $.ajax({
            url: "/form.php",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            console.log("Hooray, it worked!");
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });

    });

    // $('#myList a[href="#profile"]').on('click', function (e) {
    //     e.preventDefault();
    //     selectedRecipe = this.id;
    //     $(this).tab('show');
    // });
    //
    // $('#myList a:first-child').on('click', function (e) {
    //     e.preventDefault();
    //     selectedRecipe = this.id;
    //     $(this).tab('show');
    // });
    //
    // $('#myList a:last-child').on('click', function (e) {
    //     e.preventDefault();
    //     selectedRecipe = this.id;
    //     $(this).tab('show');
    // });
    //
    // $('#myList a:nth-child(3)').on('click', function (e) {
    //     e.preventDefault();
    //     selectedRecipe = this.id;
    //     $(this).tab('show');
    // });


    // $('#myList a[href="#profile"]').tab('show') // Select tab by name
    // $('#myList a:first-child').tab('show') // Select first tab
    // $('#myList a:last-child').tab('show') // Select last tab
    // $('#myList a:nth-child(3)').tab('show') // Select third tab

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
            // alert( "Handler for .click() called." );
            // e.preventDefault()
            // document.getElementById("main-nav").style.display = 'none';
            // document.getElementsByClassName("jumbotron")[0].style.display = 'block';
            // document.getElementById("sign-out").style.display = 'none';
            // document.getElementById("register").style.display = 'inline-block';
            // document.getElementById("sign-in").style.display = 'inline-block';
            // document.getElementById("carousel").style.display = 'block';
            // document.getElementById("recipes").style.display = 'none';
            // document.getElementById("save-recipe").style.display = 'none';
            // document.getElementById("submit-recipe").style.display = 'none';
            // document.getElementById("url-input").style.display = 'none';
            // document.getElementById("recipe-steps").style.display = 'none';
            // var xmlHttp = new XMLHttpRequest();
            // xmlHttp.open("POST", "signOut.php", true);
            // xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // xmlHttp.send();
            window.location.href = "/";

        });

        $("#submit-recipe").click(function () {
            // alert( "Handler for .click() called." );
            // e.preventDefault()

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
            var defaultStepNo = '0';
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

            var recipes = document.getElementsByClassName("list-group-item");
            var i = 0;
            for (i; i < recipes.length; ++i) {
                if (recipes[i].classList.contains('active')) {
                    break;
                }
            }

            var recipeName = recipes[i].innerText;
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
        console.log(jsonData.steps);
    }

    function regCallBack (event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.regStatus);
        console.log(jsonData.alreadyRegistered);
        console.log(jsonData.crypt);
        if (jsonData.alreadyRegistered == false) {
            document.getElementById("carousel").style.display = 'none';
            document.getElementById("register").style.display = 'none';
            document.getElementById("sign-in").style.display = 'none';
            document.getElementById("recipes").style.display = 'block';
            document.getElementById("sign-out").style.display = 'inline-block';
            document.getElementById("save-recipe").style.display = 'inline-block';
            document.getElementById("submit-recipe").style.display = 'inline-block';
            document.getElementsByClassName("jumbotron")[0].style.display = 'none';
            document.getElementById("main-nav").style.display = 'block';
            getRecipes();
        }
    }

    function getRecipes() {
        var username = document.getElementById("login-username").value;
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("POST", "getRecipes.php", true);
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlHttp.addEventListener("load", getRecipeCallBack, false);
        xmlHttp.send("username=" + username);
    }

    function getRecipeCallBack(event) {
        var plainText = event.target.responseText;
        var jsonData = JSON.parse(plainText);
        // console.log(jsonData.recipe1);
        // console.log(jsonData.steps1);
        // console.log(jsonData.recipe2);
        // console.log(jsonData.steps2);
        var ingredientsList = document.getElementsByClassName("ingredients");
        var stepList = document.getElementsByClassName("steps");
        var i = 0;
        // for (i; i < recipeList.length; ++i) {
            // if (recipeList[i].id == jsonData[2*i + 1]) {
                stepList[0].value = jsonData.steps1;
                stepList[1].value = jsonData.steps2;
                stepList[2].value = jsonData.steps3;
                stepList[3].value = jsonData.steps4;
                stepList[4].value = jsonData.steps5;
                stepList[5].value = jsonData.steps6;

                ingredientsList[0].value = jsonData.ingredients1;
                ingredientsList[1].value = jsonData.ingredients2;
                ingredientsList[2].value = jsonData.ingredients3;
                ingredientsList[3].value = jsonData.ingredients4;
                ingredientsList[4].value = jsonData.ingredients5;
                ingredientsList[5].value = jsonData.ingredients6;
                // console.log(jsonData[2*i+1]);
            // }
        // }
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
      // document.getElementById("preview").innerText = "";
      document.getElementById("list-links").innerText = "";
      document.getElementById("list-pages").innerText = "";
      // console.log(jsonData.Pages.length);
      // var counter = 1;
      for (var i = 0; i < jsonData.Pages.length; ++i) {
        var page = jsonData.Pages[i];
        var newLink = document.createElement('a');
        newLink.className = 'list-group-item list-group-item-action';
        newLink.href = "#list-item-" + (i+1);
        newLink.innerText = "Page " + (i+1);
        var newHeader = document.createElement('h4');
        newHeader.id = "list-item-" + (i+1);
        newHeader.innerText = "Page " + (i+1);
        var newParagraph = document.createElement('p');
        for (var j = 0; j < page.length; ++j) {
          // var newLine = document.createElement('p');
          var textNode = $('<p/>').html(page[j]).text();         // Create a text node
          // var newContent = ;
          newParagraph.innerText += textNode;
          newParagraph.innerText += "\n";
          // var newBreak = document.createElement('br');

          // document.getElementById("preview").appendChild(newBreak);
          // newPage.appendChild(newLine);
        }
        document.getElementById("list-links").appendChild(newLink);
        document.getElementById("list-pages").appendChild(newHeader);
        document.getElementById("list-pages").appendChild(newParagraph);
        // document.getElementById("preview").appendChild(document.createElement("br"));
      }
      // document.getElementById("preview").style.display = 'block';
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
      document.getElementById('recipes').style.display = 'none';
      document.getElementById('url-input').style.display = 'inline-block';
      // document.getElementById('save-recipe').style.display = 'none';
      // document.getElementById('submit-recipe').style.display = 'none';
      // document.getElementById('add-url-recipe').style.display = 'none';
      // document.getElementById('preview').style.display = 'none';
      // document.getElementById('url-next').style.display = 'inline-block';
    });

    $('#manual-label').click(function () {
      document.getElementById('recipes').style.display = 'inline-block';
      document.getElementById('url-input').style.display = 'none';
      // document.getElementById('save-recipe').style.display = 'inline-block';
      // document.getElementById('submit-recipe').style.display = 'inline-block';
      // document.getElementById('add-url-recipe').style.display = 'none';
      // document.getElementById('preview').style.display = 'none';
      // document.getElementById('url-next').style.display = 'none';
    });
    function changeRecipe () {
      let e = document.getElementById("recipe_state").value;
      var selectedRecipe = e.options[e.selectedIndex].text;

    }

    var offset = 180;

    $('.navbar li a').click(function(event) {
        event.preventDefault();
        $($(this).attr('h1'))[0].scrollIntoView();
        scrollBy(0, -offset);
    });
