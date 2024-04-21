<?php
include("../system_config.php");
?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ATHANG SOLUTIONS PRIVATE LIMITED</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/admin.css">
  <!-- Skins -->
  <style type="text/css">
    .fa {
      font-size: 20px;
    }

    .form-group {
      margin-top: 20px !important;
    }
  </style>

  <!-- sweet alert  -->
  <script src="<?php echo SITEPATH; ?>admin/plugins/sweetalert/sweetalert2.all.min.js"></script>
  <link href="<?php echo SITEPATH; ?>admin/plugins/sweetalert/sweetalert2.min.css" rel="stylesheet">

</head>

<body style="background:url(images/123456789.jpg) top right no-repeat;background-size: cover;">
  <div class="container login-container">
    <div class="row">
      <div class="col-sm-7" style="border:0px solid "> </div>
      <div class="col-sm-5" style="border:0px solid ">
        <div class="login-box">
          <div class="login-logo"> 
            <a href="">
              <img src="<?php echo SITEPATH; ?>upload/logo.png" class="img-responsive center-block">
          </a> 
          </div>
        </div>
        <form class='input-form' action='action/login.php?action=login' method="post" name="form">
          <div class="login-box-body" style="padding: 10px;">
            <h1>Login</h1>
            <?php
            if (isset($_SESSION['msg'])) {
              $message = $_SESSION['msg'];
              unset($_SESSION['msg']);

              // Display the flash message using SweetAlert
              echo "<script>
              Swal.fire({
              icon: 'error',
              title: '" . $message . "',
              position: 'top',
              timer: 3000, // Display for 3 seconds
              showConfirmButton: false,
              timerProgressBar: true
              });
              </script>";
            }
            ?>
            <div class="form-group has-feedback">
              <input name="txt_userId" type="text" required maxlength="50" class="form-control" placeholder="Username">
              <span class="fa fa-unlock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input name="txt_password" type="password" required maxlength="50" class="form-control" placeholder="Password">
              <span class="fa fa-key form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="clearfix"></div>
              <div class="col-sm-12">
                <div class="btn-submit-active">
                  <input value="Login" type="submit">
                  <span></span>
                </div>
              </div>
            </div>
            <div style="font-size: 15px;margin-top: 27px;">© <?php echo date("Y"); ?> ATHANG SOLUTIONS PRIVATE LIMITED. </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>