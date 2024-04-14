<?php
include("../../system_config.php");
include_once("../common/head.php");
// if ($r['user_type'] == "1") {
$rows_list = getuser_byList();
// } else {
//   $rows_list = getuser_byID($_SESSION['AdminLogin']);
// }

if ($per['salary_management']['view'] == 0) { ?>
  <script>
    window.location.href = "../dashboard.php";
  </script>
<?php } ?>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../common/left_menu.php"); ?>
    <div class="content-wrapper">
      <!-- Content Header -->
      <section class="content-header">

       <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
            <?php if ($per['salary_management']['view'] == 1) { ?>
              View All Employee
            <?php } ?>
          </li>
        </ol>
      </section>
      <!-- Main content -->
      <?php
      // Display the flash message using SweetAlert
      if (isset($_SESSION['msg'])) {
        $message = $_SESSION['msg'];
        unset($_SESSION['msg']);

        echo "<script>
          Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '" . $message . "',
          timer: 3000, // Display for 3 seconds
          showConfirmButton: false
          });
          </script>";
      }
      ?>

      <section class="content"> <br />
        <div class="table-responsive" style="overflow-x: auto;">
          <table id="exportable" align="center" class="table table-bordered table-condensed table-hover">
            <thead>
              <tr>
                <td><strong>Sr No</strong></td>
                <td>Image</td>
                <td><strong>Name</strong></td>
                <td><strong>Email</strong></td>
                <td><strong>Password</strong></td>
                <td><strong>Number</strong></td>
                <td><strong>Address</strong></td>
                <td><strong>State</strong></td>
                <td><strong>District</strong></td>
                <td><strong>Status</strong></td>
                <!-- <td><strong>Action</strong></td> -->

              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($rows_list as $rows) {
                $userState = getState_byID($rows['user_state']);
                $user_district = getdistrict_byID($rows['user_district']);


              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><a href="javascript:void(0)">
                      <img src="<?= SITEPATH; ?><?= ($rows['user_logo']) ? $config['Images'] . $rows['user_logo'] : NOIMAGE; ?>" style="width: 80px;height: 80px;border-radius: 20px;">
                    </a>
                  </td>
                  <td><b><?php echo $rows['first_name']; ?></b></td>
                  <td><?php echo $rows['user_email']; ?></td>
                  <td><?php echo decryptIt($rows['user_pass']); ?></td>
                  <td><?php echo $rows['user_phone']; ?></td>
                  <td><?php echo $rows['user_address'] ?></td>
                  <td><?php echo $userState['name']; ?></td>
                  <td><?php echo $user_district['district_name']; ?></td>
                  <td>
                    <?php if ($rows['user_status'] == 0) { ?>
                      <i class="fa fa-check-circle" title="Active" style="color: green;"></i>
                    <?php } else { ?>
                      <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                    <?php  } ?>
                  </td>


                  <!-- <td id="font12">
                    <?php if ($per['salary_management']['edit'] == 1) { ?>

                    <?php } ?>
                  </td> -->

                </tr>
              <?php
                $i++;
              } ?>
            </tbody>
          </table>

          <script>
            function confirmDelete(id) {
              // console.log(id);
              Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
              }).then((result) => {
                if (result.isConfirmed) {
                  var deleteUrl = "<?php echo SITEPATH; ?>admin/action/user.php?action=del&id=" + id;
                  window.location.href = deleteUrl;
                }
              });

              return false;
            }
          </script>


        </div>
      </section>
    </div>
    <!--close page contets , start footer-->
    <footer class="main-footer">
      <?php include_once("../common/copyright.php"); ?>
    </footer>
  </div>
  <?php include_once("../common/footer.php"); ?>
</body>

</html>