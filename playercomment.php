<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
    header('Location: login/login.php');
}
?>

<!doctype html>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>simili.io Player</title>

    <!--
      This sample demonstrates how to render a 360 degree panoramic image in VR.
    -->

    <style>
      #webgl-canvas {
        box-sizing: border-box;
        height: 100%;
        left: 0;
        margin: 0;
        position: absolute;
        top: 0;
        width: 100%;
      }
    </style>

    <style>
      .similivr-button-togglevr {
        bottom: 0;
        right: 0;
      }
      .similivr-button-fullscreen{
        top: 0;
        right: 0;
      }
      .similivr-button-reset{
        bottom: 0;
        left: 0;
      }
    </style>
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
          <a class="navbar-brand" href="http://try.simili.io/">
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
    <div class="container">
      <script>
        function getParameterByName(name, url) {
          if (!url) url = window.location.href;
          name = name.replace(/[\[\]]/g, "\\$&");
          var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
              results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return '';
          return decodeURIComponent(results[2].replace(/\+/g, " "));
          }
        var idPrvw = getParameterByName('id');
        var userPrvw = getParameterByName('user');

        var heightdiv = document.createElement('div');
        heightdiv.style.height = '300px';
        heightdiv.style.position = 'relative';
        document.body.appendChild(heightdiv);

        var containerdiv = document.createElement('div');
        containerdiv.id='similivr-player-container-'+userPrvw+'-'+idPrvw;
        heightdiv.appendChild(containerdiv);

        var playerscript = document.createElement('script');
        playerscript.src="player/similivr.player.js?id="+idPrvw+"&user="+userPrvw;
        heightdiv.appendChild(playerscript);
      </script>
    </div>
    <div class="container">
      <div class="row">
        <form class="col-lg-6" action="comment/add_comment.php" method="post">
          <label>Add a comment:</label>
          <input type="text" name="commentbody" id="commentbody">
          <input type="hidden" name="parentid" id="parentid" value=""/>
          <input class="btn" type="submit" value="Post" name="submit">
          <h3 class="error" id="com_error"></h3>
        </form>
      </div>
    </div>

    <div class="container" id="displaycomments">
      <?php include('comment/show_comment.php'); ?>
    </div>

    <script type="text/javascript">
      document.getElementById('parentid').value = getParameterByName('id');
    </script>
  </body>
</html>