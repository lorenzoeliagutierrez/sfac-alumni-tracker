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

<title>Add Batch</title>

<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include "../../includes/sidebar.php" ?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <?php include "../../includes/navbar.php" ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-sm-6 mb-xl-0 mb-4">
                <div class="card">   
                    <form method="POST" action="userData/ctrl-batch-transition.php">                          
                        <div class="main active">
                            <img class="resize" src="../../assets/img/sfac.png">
                            <div class="text">
                                <h2>Batch Transition</h2>
                            </div>
                            
                            <div class="input-text">
                                <select name="batch">                   
                                    <option selected disabled>Batch List</option>                         
                                    <?php
                                    foreach ($batch as $Batch) {
                                    ?>
                                        <option value="<?php echo $Batch['batch_id'] ?>">
                                            <?php echo $Batch['batch'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="buttons justify-content-center button_space">             
                                <button type="submit" class="d-sm-inline d-none" name="submit">Submit</button>
                            </div>         
                        </div>           
                    </form>
                </div>
            </div>
        </div>
    </div>

  <?php include "../../includes/footer.php" ?>

</main>

  <?php include "../../includes/fixed-plugin.php" ?>
  <!--   Core JS Files   -->
  <?php include "../../includes/script.php" ?>
  <script>
    <?php 
      if (!empty($_SESSION['transitionBatch'])) {     
    ?>
            Swal.fire("Batch", "Added Successfully", "success");
    <?php 
    unset($_SESSION['transitionBatch']);
  } 
  ?>
  </script>

  <script>
  function confirmSubmit() {
    return confirm("Are you sure you want to submit?");
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
      if (!confirmSubmit()) {
        event.preventDefault();
      }
    });
  });
</script>
</body>

</html>