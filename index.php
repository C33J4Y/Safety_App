<?php
require_once('db_connect.php');
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>SchoolSafe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- bootstrap code -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <!--Google Script-->
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!--Add an API key-->
    <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">

    <!-- Mobiscroll JS and CSS Includes -->
    <link rel="stylesheet" href="css/mobiscroll.javascript.min.css">
    <script src="js/mobiscroll.javascript.min.js"></script>

    <!-- Google Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>

<body>


    </div>

    <!-- <div id="content" data-target="#navbarNavAltMarkup"> -->

    <!-- rel="modal:open -->
    <article class="card-body">
        <a class="float-right btn btn-outline-primary id" data-toggle="modal" data-target="#registerForm"> Sign up </a>

        <h4 class=" card-title mb-4 mt-1"> Sign in </h4>
        <!--user login -->
        <form role="form" action="authenticate.php" method="post">
            <div class="form-group">
                <label> Your Username </label>
                <input id="username" name="username" class="form-control" placeholder="Username" type="text" required>
            </div>
            <div class="form-group">
                <a class="float-right" href="#"> Forgot? </a>
                <label> Your password </label>
                <input id="password" name="password" class="form-control" placeholder="******" type="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" value="Submit"> Login </button>
            </div>
        </form>

    </article>
    </div>

    <!-- ------------------------------------------------------------------------------------- -->


    <div class="modal" id="registerForm">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class=" card-title mb-4 mt-1"> Sign Up </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="register-form" action="register.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="password1" name="password1">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="password2" name="password2">
                        </div>

                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" value='Submit' id="registerButton" name='registerButton' class="signup btn btn-primary btn-block mb-4 mt-4" >Sign Up</button>
                        </div>


                    </form>

                </div>

            </div>


</body>

</html>
<script src="fetch.js"></script>