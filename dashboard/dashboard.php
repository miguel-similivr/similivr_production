<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/upload_url.inc.php';
include_once '../../includes/functions.php';
 
sec_session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>simili.io Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link href="../css/sidebar.css" rel="stylesheet">
    <link href="../css/dashboard-style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="createcontentpanels.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

</head>

<body>

  <?php if (login_check($mysqli) == false) : ?>
    <p>
        <span class="error">You are not authorized to access this page.</span> Please <a href="../login/login.php">login</a>.
    </p>
  <?php else : ?>

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
            <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
            <li><a href="#">Account Settings</a></li>
            <li><a href="../contact/contact.html">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav> <!-- /end of nav -->
        <!-- Sidebar -->
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
    
    <div class="container">
      <div class="row">
        <?php echo '<h1 class="col-lg-12" style="text-align: center;">Hello '.$_SESSION['username'].'</h1>';?>
        <?php include('getmax.php');?>
        <form class="col-lg-6" action="upload_img.php" method="post" enctype="multipart/form-data">
          <label>Upload an image: </label>
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="hidden" name="username" id="username" value="<?php echo $_SESSION['username'];?>"/>
          <input class="btn" type="submit" value="Upload Image" name="submit">
          <h3 class="error" id="img_error"></h3>
        </form>
      </div>
      <div class="row" id="contentcontainer">
          <?php include('showimages.php'); ?>
          <script type="text/javascript">
          var objects = <?php echo json_encode($contentarray);?>;
          for (var p in objects) {
            createcontentpanel(objects[p], p);
          }
          </script>
          
      </div>
    </div>
        <!-- /#page-content-wrapper -->
      <!-- /#wrapper -->

      <!-- jQuery -->
    

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="error.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    
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


  <?php endif; ?>
</body>

</html>
