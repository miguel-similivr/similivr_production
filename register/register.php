<?php
include_once '../../includes/register.inc.php';
include_once '../../includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register for simili.io</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dosis:200,400" type="text/css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/form-elements.css">
        <link rel="stylesheet" href="../css/loginreg-style.css">

        <!--JS-->
        <script type="text/JavaScript" src="../js/sha512.js"></script> 
        <script type="text/JavaScript" src="../js/forms.js"></script>
    </head>
    <body>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <div class="top-content">
          <div class="inner-bg">
            <div class="container">
                <div class="row">
                            <div class="col-sm-8 col-sm-offset-2 text">
                                <h1><strong>simili.io</strong> Registration Form</h1>
                                <div class="description">
                                    <p>Register now and gain access to our beta!</p>
                                </div>
                            </div>
                        </div>
                  <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Register for simili.io</h3>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                  <form role="form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" name="registration_form">
                    <div class="form-group">
                        <label class="sr-only" for="username">Username</label>
                        <input type="text" name="username" placeholder="Username..." class="form-username form-control" id="username">
                        <p>Usernames may contain only digits, upper and lowercase letters and underscores.</p>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="email">Username</label>
                        <input type="text" name="email" placeholder="Email Address..." class="form-username form-control" id="email">
                        <p>Emails must have a valid email format</p>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
                        <p>Passwords must be at least 6 characters long and must contain at least one uppercase letter (A..Z), 
                        at least one lowercase letter (a..z) and at least one number (0..9).</p>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="password">Password</label>
                        <input type="password" name="confirmpwd" placeholder="Confirm Password..." class="form-password form-control" id="confirmpwd">
                        <p>Your password and confirmation must match exactly.</p>
                    </div>
                    <input type="button" class="btn" value="Register" onclick="return regformhash(this.form,this.form.username,
                        this.form.email,this.form.password,this.form.confirmpwd);" />
                  </form>
                </div>
                </div>
              </div>
            </div>
            <p>Already registered? Click here to go to our <a href="../login/login.php">login page</a>.</p>
          </div>
          
        </div>
        
    </body>
</html>
