<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
    header('Location: ../dashboard/dashboard.php');
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login to simili.io</title>

    <!-- CSS -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/form-elements.css">
    <link rel="stylesheet" href="../css/loginreg-style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="../images/icons/favicon.png">
    <!--
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/icons/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/icons/apple-touch-icon-57-precomposed.png">
    -->

    <!-- Login Scripts -->
    <script type="text/JavaScript" src="../js/sha512.js"></script> 
    <script type="text/JavaScript" src="../js/forms.js"></script> 

  </head>

  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">
                <img src="../images/simili_io_logo_v2.png" alt="brand" style="border: none; padding: 5px;" >
              </a>
            </div>

            
                <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="../contact/contact.html">Contact Us</a></li>
                <li><a href="../register/register.php">Sign Up</a></li>
                <li><a href="../login/login.php">Log In</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav> <!-- /end of nav -->
      <!-- Top content -->
    <div class="top-content">
      <div class="inner-bg">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
            	<div class="form-top">
            		<div class="form-top-left">
            			<h3>Login to simili.io</h3>
                		<p>Enter your email and password to log in:</p>
            		</div>
            		<div class="form-top-right">
            			<i class="fa fa-lock"></i>
            		</div>
                </div>
                <div class="form-bottom">
              <form role="form" action="process_login.php" method="post" class="login_form">
              	<div class="form-group">
              		<label class="sr-only" for="email">Username</label>
                  	<input type="text" name="email" placeholder="Email..." class="form-username form-control" id="email">
                  </div>
                  <div class="form-group">
                  	<label class="sr-only" for="password">Password</label>
                  	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
                  </div>
                  <input type="button" class="btn" value="Login" onclick="formhash(this.form, this.form.password);" /> 
              </form>
            </div>
            </div>
          </div>
        </div>
        <p>Don't have an account? Click here to go to our <a href="../register/register.php">registration page</a>.</p>
        <footer>
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <p>Copyright &copy; Simili Virtual Reality Inc. 2016</p>
                <p><a href="../terms_of_service.html">Terms of Service</a></p>
                <p><a href="../privacy_policy.html">Privacy Policy</a></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

      <!-- Javascript -->
      <script src="assets/js/jquery-1.11.1.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/js/jquery.backstretch.min.js"></script>
      <script src="assets/js/scripts.js"></script>
      
      <!--[if lt IE 10]>
          <script src="assets/js/placeholder.js"></script>
      <![endif]-->

  </body>

</html>
