<!--
=========================================================
* Material Dashboard 2 - v3.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<?php
include '../../includes/session.php';
// End Session 
include '../../includes/head.php';
include '../../includes/fetchData.php';
?>



<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include "../../includes/sidebar.php" ?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../../includes/navbar.php" ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div id="add-alumni">
      </div>
      <div id="alum_notMatchPass">
      </div>

      <div class="row">
        <div class="containerr">
          <div class="card">
            <div class="form">
              <div class="left-side">
                <div class="left-heading">
                  <img class="img-left" src="../../assets/img/sfac.png">
                </div>
                <div class="steps-content">
                </div>
                <ul class="ul_progress">
                  <li class="active">Add account for an alumnni</li>
                </ul>
              </div>
              <div class="right-side">
                <form method="POST" action="userData/ctrl.add-alumni.php">
                  
                  <div class="main active">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Account</h2>
                      <p></p>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" id="username" required name="username">
                        <span class="form-label" for="username">Username</span>
                      </div>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      
                      <input type="password" class="form-control" id="pwd" name="password">
                      <span class="form-label" for="pwd">Password</span>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      
                      <input type="password" class="form-control" id="pwd" name="confirm_pass">
                        <label class="form-label" for="pwd">Confirm Password</label>
                    </div>

                    <div class="buttons button_space">
                      <button class="submit_button" name="submit">Submit</button>
                    </div>
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include "../../includes/footer.php" ?>
    </div>
  </main>
  <?php include "../../includes/fixed-plugin.php" ?>
  <!--   Core JS Files   -->
  <?php include "../../includes/script.php" ?>
</body>
<script>
  <?php
  if (!empty($_SESSION['studAdded'])) { ?>
  Swal.fire("Alumni","Added Successfully ", "success");
  <?php
  unset($_SESSION['studAdded']);
  }?>
  <?php
  if (!empty($_SESSION['notMatch'])) {
    ?>
  Swal.fire("Error","Password does not Match ", "error")
  <?php
  unset($_SESSION['notMatch']);
  } ?>


</script>

</html>