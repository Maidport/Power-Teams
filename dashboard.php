<?php
//Start a new session;
session_start();
require(dirname(__FILE__)."/linker.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Teams <?php echo $User[1]['Firstname'] ?> </title>
    <!-- Get JQuery ready for precomplete calls -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./assets/css/shared/style.css">
    <!-- endinject -->
    <link rel="stylesheet" href="./assets/css/demo_1/style.css">
    <!-- Layout style -->
    <link rel="shortcut icon" href="../asssets/images/favicon.ico" />

    <style type="text/css">
      *,i{
        color: #fff;
      }
    </style>
  </head>
  <body class="header-fixed">
    <!-- partial:partials/_header.html -->
    <nav class="t-header bg-dark">
      <div class="t-header-brand-wrapper">
        <a href="dashboard bg-dark ">
          <img class="logo" src="./img/Logo dark.png" alt="" width="150px">
          <img class="logo-mini" src="./img/Logo dark.png" alt="" width="150px" >
        </a>
      </div>
      <div class="t-header-content-wrapper">
        <div class="t-header-content">
          <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
            <i class="mdi mdi-menu text-light"></i>
          </button>
          <ul class="nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="messageDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-information-variant mdi-1x text-light "></i>
                <span class="notification-indicator notification-indicator-primary notification-indicator-ripple"></span>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="messageDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title text-dark">Maidport <small><small class="text-dark" >WEB</small></small> </h6>
                </div>
                <div class="dropdown-body">
                  <div class="dropdown-list" data-toggle="modal" data-target="#About_us">
                    <div class="image-wrapper">
                      <img class="profile-img" src="./img/Maidport New LOGO.png" alt="profile image" width="100px" height="50px">
                      <div class="status-indicator rounded-indicator bg-success"></div>
                    </div>
                    <div class="content-wrapper">
                      <small class="content-text">About Us</small>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- partial -->
    <div class="page-body">
      <!-- partial:partials/_sidebar.html -->
      <div class="sidebar bg-dark text-light">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle bg-dark" src="img/<?php echo $User[1]['photo']; ?>" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name"><?php echo $User[1]['Firstname']." ".$User[1]['Lastname']; ?></p>
          </div>
        </div>
        <ul class="navigation-menu">

          <li class="nav-category-divider bg-dark text-light">MAIN</li>
          <li>
            <a href="dashboard">
              <span class="link-title">Home</span>
              <i class="mdi mdi-home link-icon text-light"></i>
            </a>
          </li>
<?php  
  //Get and use the user team variable
  $teams = ['technical','choir','mc'];
  $_User_team = $User[1]['team'];
  if(in_array($_User_team, $teams)){
    switch ($_User_team) {
      case 'choir':
              echo    '<li>
                  <a href="uploads">
                    <span class="link-title">Uploads</span>
                    <i class="mdi mdi-upload link-icon text-light"></i>
                  </a>
                </li>';
              echo '<li>
                  <a href="choir" aria-expanded="false">
                    <span class="link-title">Choir</span>
                    <i class="mdi mdi-microphone link-icon text-light"></i>
                  </a>
                </li>';
        break;
      case 'technical':
            echo '<li>
                  <a href="today">
                    <span class="link-title">Today</span>
                    <i class="mdi mdi-calendar link-icon text-light"></i>
                  </a>
                </li>';
              echo '<li>
                  <a href="uploads">
                    <span class="link-title">Uploads</span>
                    <i class="mdi mdi-upload link-icon text-light"></i>
                  </a>
                </li>';
              echo '<li>
                  <a href="choir" aria-expanded="false">
                    <span class="link-title">Choir</span>
                    <i class="mdi mdi-microphone link-icon text-light"></i>
                  </a>
                </li>';
        break;
      case 'mc':
              echo '<li>
                    <a href="uploads">
                      <span class="link-title">Uploads</span>
                      <i class="mdi mdi-upload link-icon text-light"></i>
                    </a>
                  </li>';
              echo '<li>
                    <a href="today">
                      <span class="link-title">Today</span>
                      <i class="mdi mdi-calendar link-icon text-light"></i>
                    </a>
                  </li>';
        break;
      default:
        # code...
        break;
    }
  }
?>
          <li>
            <a href="teams">
              <span class="link-title">Teams</span>
              <i class="mdi mdi-account-multiple link-icon text-light"></i>
            </a>
          </li>

          <li>
            <a href="issues">
              <span class="link-title">Issues</span>
              <i class="mdi mdi-ghost link-icon text-light"></i>
            </a>
          </li>
          <li>
            <a href="profile">
              <span class="link-title">My Profile</span>
              <i class="mdi mdi-account-circle-outline link-icon text-light"></i>
            </a>
          </li>
          <hr class="featurette-divider bg-danger" />
          <li>
            <a href="logout" aria-expanded="false">
              <span class="link-title">Logout</span>
              <i class="mdi mdi-power link-icon text-danger"></i>
            </a>
          </li>
        </ul>
      </div>
      <!-- partial -->
      <div class="page-content-wrapper text-light" style="background: url('img/BG.jpg') center no-repeat;background-size: cover; background-attachment: fixed;">
        <div class="page-content-wrapper-inner">
          <div class="content-viewport">
            <div class="row">
              <div class="col-12 py-0">
                <h4>Maidport <small><small>Teams</small></small></h4>
                <p class="text-light">Welcome aboard, <?php echo $User[1]['Firstname']." ".$User[1]['Lastname']; ?></p>
              </div>
            </div>
          </div>
        </div>
        <!-- content viewport starts -->
<?php

if (isset($View) & sizeof(explode("/",$View)) == 2) {
  $Rendered_Role = $User[1]['role'];
  $R_role = "admin";
  $View_split = explode("/", $View);
  $View = implode("/", [$View_split[0],$R_role,$View_split[1]]);

  if(file_exists($View)){
    include($View);
    }
}
?>
        <!--Message reading modal-->
        <div class="modal fade" id="About_us">
          <div class="modal-dialog">
            <div class="modal-content bg-dark">
              <div class="modal-header">
                <div class="image-wrapper">
                  <img class="profile-img" src="./img/Maidport New LOGO.png" alt="profile image">
                  <div class="status-indicator rounded-indicator bg-success"></div>
                  <small class="name">Maidport <small><small>WEB</small></small></small>
                </div>
              </div>
              <div class="modal-body">
                <div class="grid">
                  <div class="grid-body text-center">
                    <img src="./img/Maidport New LOGO.png" width="250px" height="125px">
                  </div>
                </div>
                <p>
                  <b>POWER </b> Teams is a Product of Maidport <small>web</small>.
                </p>

                <div class="grid border-dark">
                  <div class="table-responive border-dark">
                    <table class="table bg-dark border-dark" >
                      <tr>
                        <td class="text-light" >Developer :</td>
                        <td class="text-light" >Ronald .T. Ngwenya</td>
                      </tr>
                    </table>
                  </div>
                </div>

                <p>
                  Signing key:
                  <br>
                  <i>2a6063614a26a671c3643407cb7e86d4</i>
                </p>
                <hr class="featurette-divider bg-light">
                <button class="btn btn-danger btn-xs has-icon btn-rounded" data-dismiss="modal" >Close <i class="mdi mdi-close mdi-xs" ></i></button>
              </div>
            </div>
          </div>
        </div>

        <!-- content viewport ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="row">
            <div class="col-sm-6 text-center text-sm-right order-sm-1">
              <ul class="text-gray">
                <li><a href="#">Terms of use</a></li>
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </div>
            <div class="col-sm-6 text-center text-sm-left mt-3 mt-sm-0">
              <small class="text-muted d-block">Copyright © 2019 <a href="#" target="_blank">Maidport</a>. All rights reserved</small>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="./assets/vendors/js/core.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.24.0/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="./assets/js/charts/chartjs.addon.js"></script>
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="./assets/js/template.js"></script>
    <script src="./assets/js/dashboard.js"></script>
    <script src="./dash.js"></script>
    <!-- endbuild -->
  </body>
</html>
