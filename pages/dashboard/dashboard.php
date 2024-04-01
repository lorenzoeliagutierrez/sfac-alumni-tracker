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
include '../../includes/head.php';
include '../../includes/graph-data.php';

?>

<title>
  Dashboard
</title>

<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include "../../includes/sidebar.php"?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../../includes/navbar.php"?>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin" || $_SESSION['role'] == "Registrar") {?>
        <h2 class="mb-1">Analytics</h2>
        <div class="row">
            <div class="col-lg-6 mt-4 mt-lg-0 ">
              <div class="card mb-5">
                <div class="card-header pb-0 p-3">
                  <div class="d-flex align-items-center">
                  <h6 class="mb-0">Analytics Insights (Per Department)</h6>

                  </div>
                </div>
        <div class="row">
        <div class="card-body p-3">
                <div class="row">
                  <div class="col-5 text-center">
                    <div class="chart">
                      <canvas id="chart-consumption2" class="chart-canvas" height="200"></canvas>
                    </div>
                    <h4 class="font-weight-bold mt-n8">
                      <span><?php echo $alumni_total; ?></span>
                      <span class="d-block text-body text-sm">ALUMNI</span>
                    </h4>
                    </div>
                <div class="col-7">
                  <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                      <tbody>
                      <tr>
                      <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-primary me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">CS Department</h6>
                  </div>
                </div>
                      </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"> <?php echo $total_CS; ?> </span>
                </td>
                    </tr>
                <tr>
                <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-secondary me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">BA Department</h6>
                  </div>
                </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"><?php echo $total_BA; ?></span>
                </td>
                </tr>
                <tr>
                <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-info me-3"> </span>
                <div class="d-flex flex-column justify-content-center">
                  <h6 class="mb-0 text-sm">EDUC Department</h6>
                </div>
                </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"> <?php echo $total_EDUC; ?></span>
                </td>
                </tr>
                <tr>
                <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-success me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">HM / HRM Department</h6>
                  </div>
                </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"> <?php echo $total_HM; ?> </span>
                </td>
                </tr>

                <tr>
                      <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-warning me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">LA Department</h6>
                  </div>
                </div>
                      </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"><?php echo $total_LA; ?></span>
                </td>
                    </tr>
                    <tr>
                      <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-dark me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">ENG Department</h6>
                  </div>
                </div>
                      </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"><?php echo $total_ENG; ?></span>
                </td>
                    </tr>
                    <tr>
                      <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-danger me-3" > </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">NURS Department</h6>
                  </div>
                </div>
                      </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"><?php echo $total_NURS; ?></span>
                </td>
                    </tr>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
        </div>

        <div class="col-lg-6 mt-4 mt-lg-0 ">
              <div class="card mb-5">
                <div class="card-header pb-0  p-3">
                <div class="d-flex align-items-center">
                <h6 class="mb-0">Analytics Insights (Work Status)</h6>

              </div>
            </div>
        <div class="row">
        <div class="card-body p-3 ">
            <div class="row">
              <div class="col-5 text-center">
                <div class="chart">
                  <canvas id="chart-consumption" class="chart-canvas" height="197"></canvas>
                </div>
                  <h4 class="font-weight-bold mt-n8">
                    <span><?php echo $alumni_total; ?></span>
                  <span class="d-block text-body text-sm">ALUMNI</span>
                  </h4>
              </div>
          <div class="col-7">
            <div class="table-responsive">
            <table class="table align-items-center mb-0">
            <tbody>
              <tr>
                <td>
                  <div class="d-flex px-2 py-0">
                    <span class="badge bg-gradient-primary me-3"> </span>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Full-time</h6>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs"><?php echo $total_ft; ?></span>
                </td>
              </tr>
              <tr>
              <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-secondary me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">Part-time</h6>
                  </div>
                </div>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="text-xs"><?php echo $total_pt; ?></span>
              </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-0">
                    <span class="badge bg-gradient-info me-3"> </span>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Self-employed</h6>
                    </div>
                  </div>
                </td>
              <td class="align-middle text-center text-sm">
                <span class="text-xs"> <?php echo $total_se; ?> </span>
              </td>
              </tr>
              <tr>
              <td>
                <div class="d-flex px-2 py-0">
                  <span class="badge bg-gradient-warning me-3"> </span>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">Unemployed</h6>
                  </div>
                </div>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="text-xs"><?php echo $total_ue; ?></span>
              </td>
              </tr>
              <td>
                <div class="d-flex px-2 py-0">

                  </div>
                </div>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="text-xs"> <?php echo $alumni_total; ?> </span>
              </td>
              </tr>
                  <td>
                    <div class="d-flex px-2 py-4">
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                  </td>
                  </tr>

            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
        </div>
        <div class="row">
    <div class="col-lg-4 col-md-2 mt-2 mb-5 mx-auto">
        <div class="card z-index-2">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg border-radius-lg py-3 pe-1" style="background: #b5cbff;">
                    <div class="chart">
                        <canvas id="chart-bars2" class="chart-canvas" style="display: block; box-sizing: border-box; width: 268.7px;" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-0">Job Alignment Analytics</h6>
                <p id="percentageDisplay" class="text-sm"></p>
                <hr class="dark horizontal">
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-2 mt-2 mb-5 mx-auto">
        <div class="card z-index-2">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg border-radius-lg py-3 pe-1" style="background: #FFFAAB;">
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas" style="display: block; box-sizing: border-box; width: 268.7px;" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-0">Satisfactory Ratings</h6>
                <p id="meanDisplay" class="text-sm"></p>
                <hr class="dark horizontal">
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-xl-3 col-sm-6 mb-xl-0">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Total Alumni</p>
                  <?php
                    $alumni_query = "SELECT alumni_id from tbl_form";
                        $user_query_run = mysqli_query($db, $alumni_query);

                        if ($user_total = mysqli_num_rows($user_query_run)) {
                            echo '<h4 class="mb-0">' . $user_total . '</h4>';
                        } else {
                            echo '<h4 class="mb-0">0</h4>';
                        }
                  ?>

                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../alumni/alumni-form.php"  target="_blank" role="button"><button class="btn btn-icon btn-3 btn-dark" type="button">
                  
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0">
          <div class="card">
              <div class="card-header p-3 pt-2">
                  <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                      <i class="material-icons opacity-10">groups</i>
                  </div>
                  <div class="text-end pt-1">
                      <p class="text-sm mb-0 text-capitalize">Employed</p>

                      <?php
                      $alumni_query = "SELECT COUNT(*) AS total_users FROM tbl_form WHERE emp_status_id IN (1, 2, 3)";
                      $user_query_run = mysqli_query($db, $alumni_query);

                      if ($user_query_run) {
                          $user_total = mysqli_fetch_assoc($user_query_run)['total_users'];
                          echo '<h4 class="mb-0">' . $user_total . '</h4>';
                      } else {
                          echo '<h4 class="mb-0">0</h4>';
                      }

                      ?>
                  </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                  <a href="../Employment_Status/employment-list.php" target="_blank" role="button"><button class="btn btn-icon btn-3 btn-dark" type="button">
                          <span class="btn-inner--text">See more</span>
                          <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                      </button></a>
              </div>
          </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-xl-0">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Unemployed</p>
                  <?php
                  $alumni_query = "SELECT emp_status_id FROM tbl_form WHERE emp_status_id = 4";
                      $user_query_run = mysqli_query($db, $alumni_query);

                      if ($user_total = mysqli_num_rows($user_query_run)) {
                          echo '<h4 class="mb-0">' . $user_total . '</h4>';
                      } else {
                          echo '<h4 class="mb-0">0</h4>';
                      }

                  ?>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../Employment_Status/unemployed-list.php"  target="_blank"><button class="btn btn-icon btn-3 btn-dark" type="button">
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>
      </div>

      <?php $select_campus = mysqli_query($db, "SELECT * FROM tbl_campus ORDER BY campus ASC");
        while ($row = mysqli_fetch_array($select_campus)) { ?>
        <h2 class="mb-4 mt-3"><b><?php echo $row['campus']?></b> Graduates</h2>
        <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Total Users</p>
                  <?php
                    $alumni_query = "SELECT alumni_id from tbl_form WHERE campus_id = '$row[campus_id]'";
                        $user_query_run = mysqli_query($db, $alumni_query);

                        if ($user_total = mysqli_num_rows($user_query_run)) {
                            echo '<h4 class="mb-0">' . $user_total . '</h4>';
                        } else {
                            echo '<h4 class="mb-0">0</h4>';
                        }
                  ?>

                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../alumni/alumni-form.php?campus=<?php echo $row['campus']?>"  target="_blank" role="button"><button class="btn btn-icon btn-3 btn-dark" type="button">
                  
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-xl-0">
          <div class="card">
              <div class="card-header p-3 pt-2">
                  <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                      <i class="material-icons opacity-10">groups</i>
                  </div>
                  <div class="text-end pt-1">
                      <p class="text-sm mb-0 text-capitalize">Employed</p>

                      <?php
                      $alumni_query = "SELECT COUNT(*) AS total_users FROM tbl_form WHERE emp_status_id IN (1, 2, 3) AND campus_id = '$row[campus_id]'";
                      $user_query_run = mysqli_query($db, $alumni_query);

                      if ($user_query_run) {
                          $user_total = mysqli_fetch_assoc($user_query_run)['total_users'];
                          echo '<h4 class="mb-0">' . $user_total . '</h4>';
                      } else {
                          echo '<h4 class="mb-0">0</h4>';
                      }

                      ?>
                  </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                  <a href="../Employment_Status/employment-list.php?campus=<?php echo $row['campus']?>" target="_blank" role="button"><button class="btn btn-icon btn-3 btn-dark" type="button">
                          <span class="btn-inner--text">See more</span>
                          <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                      </button></a>
              </div>
          </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-xl-0">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Unemployed</p>
                  <?php
                  $alumni_query = "SELECT emp_status_id FROM tbl_form WHERE emp_status_id = 4 AND campus_id = '$row[campus_id]'";
                      $user_query_run = mysqli_query($db, $alumni_query);

                      if ($user_total = mysqli_num_rows($user_query_run)) {
                          echo '<h4 class="mb-0">' . $user_total . '</h4>';
                      } else {
                          echo '<h4 class="mb-0">0</h4>';
                      }

                  ?>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../Employment_Status/unemployed-list.php?campus=<?php echo $row['campus']?>"  target="_blank"><button class="btn btn-icon btn-3 btn-dark" type="button">
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>
        </div>
        <?php }?>
    
        <?php } else if ($_SESSION['role'] == "Alum Stud") {
    ?><div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Total Alumni</p>
                  <?php
                    $alumni_query = "SELECT alumni_id from tbl_form WHERE program_id='$program_id'";
                    $user_query_run = mysqli_query($db, $alumni_query);

                  if ($user_total = mysqli_num_rows($user_query_run)) {
                    echo '<h4 class="mb-0">' . $user_total . '</h4>';
                } else {
                    echo '<h4 class="mb-0">No data</h4>';
                    }
                  ?>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../alumni/total-alumni-dash.php"  target="_blank"><button class="btn btn-icon btn-3 bg-gradient-dark" type="button">
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>
                </div>

    <?php } else if ($_SESSION['role'] == "Student") {
    ?><div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="material-icons opacity-10">groups</i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Total Student</p>
                  <?php
                    $student_query = "SELECT student_id from tbl_student WHERE student_id ='$student_id'";
                    $user_query_run = mysqli_query($db, $student_query);

                  if ($user_total = mysqli_num_rows($user_query_run)) {
                    echo '<h4 class="mb-0">' . $user_total . '</h4>';
                } else {
                    echo '<h4 class="mb-0">No data</h4>';
                    }
                  ?>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <a href="../student/student-list.php"  target="_blank"><button class="btn btn-icon btn-3 bg-gradient-dark" type="button">
                  <span class="btn-inner--text">See more</span>
                  <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                </button></a>
              </div>
            </div>
          </div>
        </div>

        <?php }?>

      <?php include "../../includes/footer.php";?>
    </div>
  </main>
  <?php include "../../includes/fixed-plugin.php";?>
</body>
<?php include '../../includes/script.php';?>
</html>