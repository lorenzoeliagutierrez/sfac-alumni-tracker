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
include '../../includes/conn.php';
include '../../includes/fetchData.php';
$_SESSION['alumni_id'] = $alumni_id;
?>

<title>
  Edit Form
</title>

  <?php include '../../includes/head.php';?>

<body class="g-sidenav-show  bg-gray-200">

  <!-- sidebar -->
  <?php include '../../includes/sidebar.php';?>
  <!-- End sidebar -->

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include '../../includes/navbar.php';?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="form-container">
          <div id='success_form'></div>
          <div id='success_fill'></div>        
          <div id="alert-top"></div>
          <div class="card">
            <div class="form">
              <div class="right-side">
                <form method="POST" action="userData/ctrl.edit-form.php">
                  <!-- First Step Form -->
                  <div class="main active">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Edit Personal Information</h2>
                      <h6>(Step 1 out of step 3) Enter your personal information to proceed.</h6>
                    </div>
                   <?php
$listalumni = mysqli_query($db, "SELECT * FROM tbl_alumni WHERE alumni_id = $alumni_id
                  ");
while ($row = mysqli_fetch_array($listalumni)) {
    $id = $row['alumni_id'];
    ?>
                    <div class="input-text">
                      <input type="text" value="<?php echo $alumni_id ?>" hidden name="userid">
                      <div class="input-div">
                        <input type="text" required require id="user_name" name="firstname" value="<?php echo $row['firstname']; ?>">
                        <span>Firstname</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required require name="middlename" value="<?php echo $row['middlename']; ?>" >
                        <span>Middlename</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required require name="lastname" value="<?php echo $row['lastname']; }?>" >
                        <span>Lastname</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select  name="gender" require>
                        <?php
                          $listalumni = mysqli_query($db, "SELECT * FROM tbl_form 
                          LEFT JOIN tbl_gender ON tbl_gender.gender_id = tbl_form.gender_id 
                          LEFT JOIN tbl_campus ON tbl_campus.campus_id = tbl_form.campus_id
                          LEFT JOIN tbl_civil_status ON tbl_civil_status.civil_id = tbl_form.civil_id
                          LEFT JOIN tbl_level ON tbl_level.level_id = tbl_form.level_id
                          LEFT JOIN tbl_program ON tbl_program.program_id = tbl_form.program_id
                          LEFT JOIN tbl_batch ON tbl_batch.batch_id = tbl_form.batch_id
                          LEFT JOIN tbl_attainment ON tbl_attainment.attain_id = tbl_form.attain_id
                          LEFT JOIN tbl_employment_status ON tbl_employment_status.emp_status_id = tbl_form.emp_status_id
                          LEFT JOIN tbl_primary_work_loc ON tbl_primary_work_loc.loc_id = tbl_form.loc_id
                          LEFT JOIN tbl_type_org ON tbl_type_org.type_id = tbl_form.type_id
                          LEFT JOIN tbl_length_employment ON tbl_length_employment.length_id = tbl_form.length_id
                          LEFT JOIN tbl_align ON tbl_align.align_id = tbl_form.align_id
                          LEFT JOIN tbl_satisfy ON tbl_satisfy.sat_id = tbl_form.sat_id
                          LEFT JOIN tbl_collaborate ON tbl_collaborate.collab_id = tbl_form.collab_id
                          LEFT JOIN tbl_consent ON tbl_consent.consent_id = tbl_form.consent_id
                  
                          WHERE alumni_id = $alumni_id
                          ");
while ($row = mysqli_fetch_array($listalumni)) {
    $id = $row['alumni_id'];
    ?>
                          <option value="<?php echo $row['gender_id']?>" selected><?php echo $row['gender'] ?> (Currently Selected)</option>
                          <?php
foreach ($gender as $sex) {
    ?>
                            <option value="<?php echo $sex['gender_id'] ?>">
                              <?php echo $sex['gender'] ?>
                            </option>

                          <?php
}
?>
                        </select>
                      </div>
                      <div class="input-div">
                        <select name="campus" require>
                        <option value="<?php echo $row['campus_id']?>" selected><?php echo $row['campus'] ?> (Currently Selected)</option>
                            <?php
                            foreach ($campus as $branch) {
                            ?>
                                <option value="<?php echo $branch['campus_id'] ?>">
                                    <?php echo $branch['campus'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                      <div class="input-div">
                        <select name="civil" required>
                        <option value="<?php echo $row['civil_id']?>" selected><?php echo $row['civil'] ?> (Currently Selected)</option>
                          <?php
foreach ($civil as $Civil) {
    ?>
                            <option value="<?php echo $Civil['civil_id'] ?>">
                              <?php echo $Civil['civil'] ?>
                            </option>

                          <?php
}
?>
                        </select>
                      </div>
                      <div id="emaill" class="input-div">
                        <input type="text" required require name="email" value="<?php echo $row['email']; ?>">
                        <span>E-mail Address</span>
                      </div>
                      <div class="input-div">
                        <select require name="level" required>
                        <option value="<?php echo $row['level_id']?>" selected>Level Graduated: <?php echo $row['level'] ?> (Current Selected)</option>
                          <?php
                          foreach ($level as $Level) {
                              ?>
                                                      <option value="<?php echo $Level['level_id'] ?>">
                                                        <?php echo $Level['level'] ?>
                                                      </option>

                                                    <?php
                          }
                          ?>
                        </select>
                    </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="pres_address" value="<?php echo $row['address']; ?>">
                        <span>Present Address</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" required require name="date_birth" value="<?php echo $row['date_birth']; ?>">
                        <span>Date of Birth (mm/dd/yyyy)</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required require name="birth_place" value="<?php echo $row['birth_place']; ?>">
                        <span>Birth Place</span>
                      </div>
                      <div class="input-div">
                        <input type="text" required require name="contact" value="<?php echo $row['contact']; ?>">
                        <span>Contact No</span>
                      </div>
                    </div>
                    
                    <div class="buttons mt-3">
                      <button class="next_button">Next Step</button>
                    </div>
                  </div>
                
                  <!-- End of First Step Form -->
                  <!-- Second Step Form -->
                  <div class="main">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Fill up Educational Background</h2>
                      <h6>(Step 2 out of step 3) Enter your Educational Background to proceed.</h6>
                    </div>
                    <div class="input-text">

                      <div class="input-div" >
                        <select name="program" required >
                        <option value="<?php echo $row['program_id']?>" selected><?php echo $row['program'] ?> (Currently Selected)</option>
                          <?php
                            foreach ($program as $Program) {
                                      ?>
                            <option value="<?php echo $Program['program_id'] ?>"><?php echo $Program['program']; ?> </option>
                          <?php
                                }?>
                        </select>
                      </div>
                      <div class="input-div">
                        <select  name="batch">
                        <option value="<?php echo $row['batch_id']?>" selected><?php echo $row['batch'] ?> (Currently Selected)</option>
                          <?php
                            foreach ($batch as $Batch) {?>
                            <option value="<?php echo $Batch['batch_id'] ?>">
                              <?php echo $Batch['batch'] ?>
                            </option>

                          <?php }
                          ?>
                        </select>

                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="attain">
                        <option value="<?php echo $row['attain_id']?>" selected><?php echo $row['attainment'] ?> (Currently Selected)</option>
                          <?php
                            foreach ($attainment as $Attainment) {
                                ?>
                            <option value="<?php echo $Attainment['attain_id'] ?>"><?php echo $Attainment['attainment']; ?> </option>
                          <?php
                                            }
                                ?>
                        </select>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="What specific field?"  name="attain_field" value="<?php echo $row['attain_field']; ?>">

                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Name of School"  name="attain_where" value="<?php echo $row['attain_where']; ?>">
                      </div>
                    </div>
                    <div class="text">
                      <h4>Achievements & Rewards</h4>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" placeholder="Please type in here ..." name="achieve_rewards1" value="<?php echo $row['achieve_rewards1']; ?>">
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Please type in here ..." name="achieve_rewards2" value="<?php echo $row['achieve_rewards2']; ?>">
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Please type in here ..." name="achieve_rewards3" value="<?php echo $row['achieve_rewards3']; ?>">
                      </div>
                    </div>


                    <div class="buttons button_space">
                      <button class="back_button">Back</button>
                      <button class="next_button">Next Step</button>
                    </div>
                  </div>
                  <!-- End of Second Step Form -->
                  <!-- Last Step Form -->
                  <div class="main">
                    <img class="resize" src="../../assets/img/sfac.png">
                    <div class="text">
                      <h2>Fill up Employment Profile</h2>
                      <h6>Incase of unemployed, just fill up the employment status then proceed to submit. Thankyou</h6>

                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="status" required>
                        <option value="<?php echo $row['emp_status_id']?>" selected><?php echo $row['status'] ?> (Currently Selected)</option>
                          <?php
foreach ($employment as $Employment) {
    ?>
                            <option value="<?php echo $Employment['emp_status_id'] ?>"><?php echo $Employment['status']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Current Organization" id="user_name" name="current_org" value="<?php echo $row['current_org']; ?>">
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="location">
                        <option value="<?php echo $row['loc_id']?>" selected><?php echo $row['location'] ?> (Currently Selected)</option>
                          <?php
foreach ($location as $Location) {
    ?>
                            <option value="<?php echo $Location['loc_id'] ?>"><?php echo $Location['location']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>
                      <div class="input-div">
                        <select name="type">
                        <option value="<?php echo $row['type_id']?>" selected><?php echo $row['type'] ?> (Currently Selected)</option>
                          <?php
foreach ($organization as $Organization) {
    ?>
                            <option value="<?php echo $Organization['type_id'] ?>"><?php echo $Organization['type']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Current Job Title / Designation" name="current_title" value="<?php echo $row['current_title']; ?>">
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" placeholder="Company Address" name="company_add" value="<?php echo $row['company_add']; ?>">
                      </div>
                      <div class="input-div">
                        <select name="length">
                        <option value="<?php echo $row['length_id']?>" selected><?php echo $row['length'] ?> (Currently Selected)</option>
                          <?php
foreach ($length as $Length) {
    ?>
                            <option value="<?php echo $Length['length_id'] ?>"><?php echo $Length['length']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="align">
                          <option value="<?php echo $row['align_id']?>" selected>Is job aligned on your course on SFAC? <?php echo $row['align'] ?> (Currently Selected)</option>
                          <?php
foreach ($align as $Align) {
    ?>
                            <option value="<?php echo $Align['align_id'] ?>"><?php echo $Align['align']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>
                      <div class="input-div">
                        <select name="satisfy">
                          <option value="<?php echo $row['sat_id']?>" selected>How satisfied are you with your current job? <?php echo $row['satisfy'] ?> (Currently Selected)</option>
                          <?php
foreach ($satisfy as $Satisfy) {
    ?>
                            <option value="<?php echo $Satisfy['sat_id'] ?>"><?php echo $Satisfy['satisfy']; ?> </option>
                          <?php
}
?>
                        </select>
                      </div>

                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="collab">
                          <option value="<?php echo $row['collab_id']?>" selected>Which of the following would you like to collaborate with us? <?php echo $row['collaborate'] ?> (Currently Selected)</option>
                          <?php
                            foreach ($collaborate as $Collaborate) {?>
                            <option value="<?php echo $Collaborate['collab_id'] ?>"><?php echo $Collaborate['collaborate']; ?> </option>
                          <?php
                              }?>
                        </select>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="topic/area/activity"  name="topic" value="<?php echo $row['topic']; ?>">
                      </div>
                    </div>
                    <h6>In case of self-employment, please answer the following:</h6>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" placeholder="Name of Business" name="buss_name" value="<?php echo $row['buss_name']; ?>">
                        <span>Name of Business</span>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Nature of Business" id="user_name" name="nat_name" autofocus value="<?php echo $row['nat_name']; ?>">
                        <span>Nature of Business</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" placeholder="Role in the Business" name="role_name" value="<?php echo $row['role_name']; ?>">
                        <span>Role in the Business</span>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Approximate Monthly Profit" id="user_name" name="profit" autofocus value="<?php echo $row['profit']; ?>">
                        <span>Approximate Monthly Profit</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <input type="text" placeholder="Business Address" name="buss_address" value="<?php echo $row['buss_addr']; ?>">
                        <span>Business Address</span>
                      </div>
                      <div class="input-div">
                        <input type="text" placeholder="Business Phone Numbers" id="user_name" name="buss_no" autofocus value="<?php echo $row['buss_no']; ?>">
                        <span>Business Phone Numbers</span>
                      </div>
                    </div>
                    <div class="input-text">
                      <div class="input-div">
                        <select name="consent" required>
                          <option value="" selected disabled>I generously give my consent to Alumni Office to use my information for SFAC purposes only.</option>
                          <?php
                                foreach ($consent as $Consent) {
                                                                    ?>
                            <option value="<?php echo $Consent['consent_id'] ?>"><?php echo $Consent['consent']; ?> </option>
                          <?php
                                                    }
                                                        ?>
                        </select>
                      </div>


                    </div>
                    <div class="buttons button_space">
                      <button class="back_button">Back</button>
                      <button  name="submit">Submit</button>
                    </div>
                  </div>
                  <!-- End of Last Step Form -->
                  <?php }?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include "../../includes/footer.php"?>
    </div>
  </main>
  <?php include "../../includes/fixed-plugin.php"?>
  <?php include "../../includes/script.php"?>
  <script>
    <?php 
      if (!empty($_SESSION['eMessage'])) {

       
    ?>
            $("#alert-top").html(
                    '<div class="alert alert-danger text-white" role="alert"><strong><?php echo $_SESSION['eMessage'][0] ?></strong></div>'
                ).fadeIn("fast", function() {
                    setTimeout(function() {
                        $("#alert-top").fadeOut(function() {
                            $("#alert-top").children().remove();
                        });
                    }, 5000);
                });

            

    <?php 

    unset($_SESSION['eMessage']);
  } 
  
  ?>
  </script>
<script>
  <?php 
      if (!empty($_SESSION['success_fill'])) {

       
    ?>
            $("#success_fill").html(
                    '<div class="alert alert-success text-white" role="alert"><strong><?php echo $_SESSION['success_fill'] ?></strong></div>'
                ).fadeIn("fast", function() {
                    setTimeout(function() {
                        $("#success_fill").fadeOut(function() {
                            $("#success_fill").children().remove();
                        });
                    }, 5000);
                });

            

    <?php 

    unset($_SESSION['success_fill']);
  } 
  
  ?>
</script>
<script>
 
            <?php 
      if (!empty($_SESSION['success_updateform'])) {     
    ?>
      Swal.fire("Form", "Updated Successfully", "success");
    <?php 
    unset($_SESSION['success_updateform']);
  }  
  ?>

</script>
  
</body>

</html>