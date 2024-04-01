
<!DOCTYPE html>
<html lang="en">

<?php
include '../../includes/session.php';
include '../../includes/head.php';

if (isset($_GET['campus'])) {
    $_SESSION['campus'] = $_GET['campus'];
  
  } else {
    if (isset($_SESSION['campus']) && $_SESSION['campus'] != "All") {
      $_SESSION['campus'] = $_SESSION['campus'];
  
    } else {
      $_SESSION['campus'] = "All";
  
    }
  }
?>
<head>
<style>
  .form-control {
    border: 1px solid #ddd;
    height: 50px;
  }
  .form-control:focus{
    border: 1px #000;
    outline: none;
  }
  .btn-search {
    height: 50px;
  }
</style>

</head>
<title>
    Alumni Employment Status
</title>

<?php if ($_SESSION['role'] == "Super Administrator" || $_SESSION['role'] == "Admin" || $_SESSION['role'] == "Registrar" ) {?>

<body class="g-sidenav-show  bg-gray-200">

    <!-- sidebar -->
    <?php include "../../includes/sidebar.php" ?>
    <!-- End sidebar -->
 
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php include "../../includes/navbar.php" ?>
        <!-- End Navbar -->

<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card px-4 pb-4">
                <h2 class="text-center mb-0 pt-4">Alumni Unemployed List</h2>
                <h5 class="text-center">
                <b>Campus :</b> <?php echo $_SESSION['campus'] ?><br>
                <?php
                    if ($_SESSION['campus'] == "All") {
                      $result = mysqli_query($db, "SELECT * FROM tbl_form");
                      $num_rows = mysqli_num_rows($result);
                    } else {
                      $result = mysqli_query($db, "SELECT * FROM tbl_form
                                LEFT JOIN tbl_campus ON tbl_campus.campus_id = tbl_form.campus_id
                                WHERE campus = '$_SESSION[campus]'");
                      $num_rows = mysqli_num_rows($result);
                    }
                    ?>
                    <b>Users
                    </b>:
                    <?php echo number_format($num_rows) ?>
                </h5>
                <!-- Search Bar -->
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="GET" class="form-horizontal">
                            <div class="input-group">
                                <input type="search" class="form-control form-control-lg" placeholder="Search for Name, Campus, Batch..." name="search">
                                <button name="submit" type="submit" class="btn btn-lg btn-info btn-search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button type="button" class="btn btn-lg btn-info mx-1" data-toggle="modal"
                                    data-target="#filter">
                                    <i class="fas fa-sliders-h"></i> Filter
                                </button>
                            </div>
                        </form>
                
                <!-- Filter -->
                <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 style="font-weight: bold" class="modal-title" id="myModalLabel"><i
                                class="glyphicon glyphicon-user"></i> Search Filter</h4>
                          </div>
                          <div class="modal-body">
                            <form method="GET">
                              <div class="form-group">
                                <div class="col-md">
                                  <label for="campus">Campus</label>
                                  <select name="campus" class="form-control" tabindex="-1" required="required">
                                    <?php
                                    if ($_SESSION['campus'] == "All") {
                                      ?>
                                      <option value="All">All (Current Selected)
                                      </option>
                                      </option>
                                      <?php
                                      $result = mysqli_query($db, "SELECT * FROM tbl_campus") or die(mysqli_error($db));
                                      while ($row4 = mysqli_fetch_array($result)) {
                                        $id = $row4['campus_id'];
                                        ?>
                                        <option value="<?php echo $row4['campus']; ?>">
                                          <?php echo $row4['campus']; ?>
                                        </option>
                                      <?php } ?>
                                      <?php
                                    } else {
                                      ?>
                                      </option>
                                      <?php
                                      $result = mysqli_query($db, "SELECT * FROM tbl_campus WHERE campus = '$_SESSION[campus]'") or die(mysqli_error($db));
                                      while ($row4 = mysqli_fetch_array($result)) {
                                        $id = $row4['campus_id'];
                                        ?>
                                        <option value="<?php echo $row4['campus']; ?>">
                                          <?php echo $row4['campus']; ?> (Current Selected)
                                        </option>
                                      <?php } ?>
                                      </option>
                                      <?php
                                      $result = mysqli_query($db, "SELECT * FROM tbl_campus WHERE campus NOT IN ('$_SESSION[campus]')") or die(mysqli_error($db));
                                      while ($row4 = mysqli_fetch_array($result)) {
                                        $id = $row4['campus_id'];
                                        ?>
                                        <option value="<?php echo $row4['campus']; ?>">
                                          <?php echo $row4['campus']; ?>
                                        </option>
                                      <?php } ?>
                                      <option value="All"> All
                                      </option>
                                      <?php
                                    }
                                    ?>

                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button class="btn btn-dark" data-dismiss="modal" aria-hidden="true"><i
                                    class="glyphicon glyphicon-remove icon-white"></i> No</button>
                                <button type="submit" class="btn btn-info"><i
                                    class="glyphicon glyphicon-ok icon-white"></i> Yes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>

                <form method="POST" action="userData/ctrl-email.php">
                    <div class="d-flex">
                        <div class="dropdown pt-4">
                            <a href="javascript:;" class="btn btn-icon bg-gradient-primary "
                                data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                <span class="material-icons">email</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                aria-labelledby="navbarDropdownMenuLink2" data-popper-placement="left-start">
                                <li><button type="submit" name="sendEmail"
                                        class="dropdown-item border-radius-md">Email All Alumni</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="searchTable" class="table table-flush" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input mt-1" type="checkbox" value="all" name="all" id="all">
                                        </div>
                                    </th>
                                    <th></th>
                                    <th>Student No.</th>
                                    <th>Fullname</th>
                                    <th>Batch</th>
                                    <th>Program</th>
                                    <th>Position</th>
                                    <th>Employment Status</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Campus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['submit'])) { 
                                    if ($_SESSION['campus'] == "All") {
                                        $return_query = mysqli_query($db, "SELECT * FROM tbl_form 
                                            LEFT JOIN tbl_campus USING (campus_id)
                                            LEFT JOIN tbl_program ON tbl_program.program_id = tbl_form.program_id
                                            LEFT JOIN tbl_alumni ON tbl_alumni.alumni_id = tbl_form.alumni_id
                                            LEFT JOIN tbl_employment_status ON tbl_employment_status.emp_status_id = tbl_form.emp_status_id
                                            LEFT JOIN tbl_batch ON tbl_batch.batch_id = tbl_form.batch_id
                                            WHERE 
                                                tbl_form.emp_status_id IN (4) AND
                                                (
                                                  tbl_alumni.firstname LIKE '%$_GET[search]%' 
                                                    OR tbl_alumni.lastname LIKE '%$_GET[search]%'
                                                    OR tbl_alumni.stud_no LIKE '%$_GET[search]%'
                                                    OR tbl_batch.batch LIKE '%$_GET[search]%'
                                                    OR tbl_program.course_abv LIKE '%$_GET[search]%'
                                                    OR tbl_form.current_title LIKE '%$_GET[search]%'
                                                    OR tbl_employment_status.status LIKE '%$_GET[search]%'
                                                    OR tbl_form.email LIKE '%$_GET[search]%'
                                                    OR tbl_form.contact LIKE '%$_GET[search]%'
                                                    OR tbl_campus.campus LIKE '%$_GET[search]%'
                                                )
                                            ")
                                        or die (mysqli_error($db)); 
                                    } else {
                                        $return_query = mysqli_query($db, "SELECT * FROM tbl_form 
                                            LEFT JOIN tbl_campus USING (campus_id)
                                            LEFT JOIN tbl_program ON tbl_program.program_id = tbl_form.program_id
                                            LEFT JOIN tbl_alumni ON tbl_alumni.alumni_id = tbl_form.alumni_id
                                            LEFT JOIN tbl_employment_status ON tbl_employment_status.emp_status_id = tbl_form.emp_status_id
                                            LEFT JOIN tbl_batch ON tbl_batch.batch_id = tbl_form.batch_id
                                            WHERE
                                                tbl_form.emp_status_id IN (4) AND 
                                                tbl_campus.campus = '$_SESSION[campus]' AND (
                                                  tbl_alumni.firstname LIKE '%$_GET[search]%' 
                                                    OR tbl_alumni.lastname LIKE '%$_GET[search]%'
                                                    OR tbl_alumni.stud_no LIKE '%$_GET[search]%'
                                                    OR tbl_batch.batch LIKE '%$_GET[search]%'
                                                    OR tbl_program.course_abv LIKE '%$_GET[search]%'
                                                    OR tbl_form.current_title LIKE '%$_GET[search]%'
                                                    OR tbl_employment_status.status LIKE '%$_GET[search]%'
                                                    OR tbl_form.email LIKE '%$_GET[search]%'
                                                    OR tbl_form.contact LIKE '%$_GET[search]%'
                                                    OR tbl_campus.campus LIKE '%$_GET[search]%'
                                                )
                                            ")
                                        or die (mysqli_error($db));
                                    }
                                    while ($row = mysqli_fetch_array($return_query)) {
                                        $id = $row['alumni_id']; ?>
                                        <tr>
                                        <td><div class="form-check"><input class="form-check-input mt-1" type="checkbox" value="all" name="all" id="all"></div></td>
                                        <td><?php echo (empty($row['img'])) ? '<img src="../../assets/img/image.png" class="border-radius-lg shadow-sm zoom" style="height:80px; width="80px"; object-fit:cover;" alt="img">' : '<img src="data:image/jpeg;base64,' . base64_encode($row['img']) . '"
                                        class="border-radius-lg shadow-sm zoom" style="height:80px; width="80px"; object-fit:cover;" alt="img">' ?></td></div>
                                        <td><?php echo $row['stud_no']; ?></td>
                                        <td><?php echo $row['firstname'] . " " . $row['middlename'] . " " . $row['lastname'];?></td>
                                        <td><?php echo $row['batch']; ?></td>
                                        <td><?php echo $row['course_abv']; ?></td>
                                        <td><?php echo $row['current_title']; ?></td>
                                        <td><b><?php echo $row['status']; ?></b></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['contact']; ?></td>
                                        <td><?php echo $row['campus']; ?></td>
                                        </tr>
                                    <?php }}
                                }
                                ?>
                            </tbody>
                        </table>
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
    function showDeleteConfirmation(formID) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = "../alumni/userData/ctrl-del-form.php?formID=" + formID;
        } else {
        }
    }
</script>
</body>

</html>