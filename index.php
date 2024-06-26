<?php
  session_start();
  //find a cookie
if($_COOKIE != null){
  if(isset($_COOKIE['_key'])){
    $_SESSION['sess'] = strrev($_COOKIE['_key']);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Teams Login</title>
    <style type="text/css">
      html,body {
        padding:0px;
        background-color: #111 !important;
      }
    </style>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/vendors/iconfonts/mdi/css/materialdesignicons.css" />
    <link rel="stylesheet" href="./assets/vendors/css/vendor.addons.css" />
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./assets/css/shared/style.css" />
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="./assets/css/demo_1/style.css">
    <!-- Layout style -->
    <link rel="shortcut icon" href="./assets/images/favicon.ico" />
  </head>
  <body>
    <div class="authentication-theme auth-style_1">
      <div class="row">
        <div class="col-12 logo-section">
          <a href="" class="logo">
            <img src="./img/Logo Light.png" alt="logo" />
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
          <div class="grid">
            <div class="grid-body">
              <div class="row">
                <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                  <?php
                    if(isset($_COOKIE)){
                      if(isset($_COOKIE["_front"])|| isset($_COOKIE['_key'])){
                        $_SESSION['sess'] = strrev($_COOKIE['_front']);
                        $redirect = '<div class="col-md-12 text-center"><a class="btn btn-primary btn-lg btn-rounded border border-light" href="dashboard.php">GO !</a></div>';
                        echo $redirect;
                      }else{
                        ?>
                          <form action="dashboard.php" method="post">
                            <input type="text" name="type" value="login" hidden readonly="YES">
                            <div class="form-group input-rounded">
                              <input type="text" class="form-control" name="Username" placeholder="Username" />
                            </div>
                            <div class="form-group input-rounded">
                              <input type="password" class="form-control" name="pwd" placeholder="Password" />
                            </div>
                            <div class="form-inline">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="form-check-input" name="remember_me" />Remember me <i class="input-frame"></i>
                                </label>
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"> Login </button>
                          </form>
                        <?php
                      }
                    }else{
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="">
        <div class="modal-dialog">
          <div class="modal-content" data-role="document">
            <div class="modal-header">
              Login <i class="mdi mdi-account mdi-md border border-warning" ></i>
            </div>
            <form action="dashboard.php" method="post">
              <input type="text" name="type" value="login" hidden readonly="YES">
              <div class="form-group input-rounded">
                <input type="text" class="form-control" name="Username" placeholder="Username" />
              </div>
              <div class="form-group input-rounded">
                <input type="password" class="form-control" name="pwd" placeholder="Password" />
              </div>
              <div class="form-inline">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="form-check-input" name="remember_me" />Remember me <i class="input-frame"></i>
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block"> Login </button>
            </form>
          </div>
        </div>
      </div>

      <div class="auth_footer">
        <p class="text-muted text-center">© Teams Inc 2019</p>
      </div>
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="./assets/vendors/js/core.js"></script>
    <script src="./assets/vendors/js/vendor.addons.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="./assets/js/template.js"></script>
    <!-- endbuild -->
  </body>
</html>
