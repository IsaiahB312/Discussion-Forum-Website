<!DOCTYPE html>

<html>
<head>
<title>Everything Forum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <style>
        #layoutMain {
            background-color: #303030;
            width:100vw; height:100vh;
        }

        #header {
            background-color: black;
            color: white;
            text-align: center;
            width: 100%;
            height: 25%;
        }

        #centerButtons {
            width: 25%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        #pageTitle{
            top: 50%;
        }
    </style>

</head>
<body>
    <div id = "layoutMain">
        <div id="header">
            <h1 id = "pageTitle"> Everything Forum</h1>
        </div>
        
        <div id="centerButtons" class="d-grid">
            <button id="logIn" type="button" class="btn btn-primary btn-lg bg-white text-black">Log In</button> 
            <br>
            <br>
            <br>
            <br>
            <button id="signUp" type="button" class="btn btn-primary btn-lg bg-white text-black">Sign Up</button>
        </div>
    </div>

<div class="modal" id="Login-Modal"> <!-- Login Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Login</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <form id = "login-form" action="project_controller.php" method="post">
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='LogIn'>
            <label class='modal-label-input' for='login'>Username:</label>
            <input id='username' type='text' name='username'>
            <?php if (!empty($error_msg_username)) echo $error_msg_username; ?>
            <br><br>
            <label class='modal-label-input' for='password'>Password:</label>
            <input id='password' type='password' name='password'>
            <?php if (!empty($error_msg_password)) echo $error_msg_password; ?>
            <br>
            <div id="login-body"></div>
            <br>
          </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='login-btn' type='button' class="btn btn-outline-primary">Log In</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="SignUp-Modal"> <!-- Login Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Sign Up</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <form id = "signup-form" action="project_controller.php" method="post">
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignUp'>
            <label class='modal-label-input' for='login'>Username:</label>
            <input id='username' type='text' name='username'>
            <?php if (!empty($error_msg_signup)) echo $error_msg_signup; ?>
            <br><br>
            <label class='modal-label-input' for='password'>Password:</label>
            <input id='password' type='password' name='password'>
            <br><br>
            <label class='modal-label-input' for='email'>Email:</label>
            <input id='email' type='text' name='email'>
            <br>
            <div id="signup-body"></div>
            <br>
          </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='signup-btn' type='button' class="btn btn-outline-primary">Sign Up!</button>
      </div>

    </div>
  </div>
</div>
</body>
</html>


<script>

    $('#logIn').click(function() {
        $('#Login-Modal').modal('show');
    });

    $('#login-btn').click(function() {
        document.getElementById("login-form").submit();
    });

    $('#signUp').click(function() {
        $('#SignUp-Modal').modal('show');
    });

    $('#signup-btn').click(function() {
        document.getElementById("signup-form").submit();
    });
    
    function display_login_modal() {
        $('#logIn').click();
    }
    
    function display_signup_modal() {
        $('#signUp').click();
    }

    $(window).on('load', function() {
    <?php
        if ($display_modal_window == 'login') 
            echo "display_login_modal();";
        else if ($display_modal_window == 'signup') 
            echo "display_signup_modal();";
    ?>
    });

</script>
