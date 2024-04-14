<?php
include("../../system_config.php");
include_once("../common/head.php");
if ($r['user_type'] == "1") {
  $rows_list = getuser_byList();
} else {
  $rows_list = getuser_byList($_SESSION['AdminLogin']);
}
if ($per['user']['view'] == 0) { ?>
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
        <h1>
          <?php if ($r['user_type'] == "1") { ?>
            <a style="text-decoration: underline;" href="<?php echo SITEPATH; ?>admin/user/add-new-user.php">Add New Employee</a>
          <?php } ?>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
            <?php if ($per['user']['view'] == 1) { ?>
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
                <td><strong>Role</strong></td>
                <td><strong>Address</strong></td>
                <td><strong>State</strong></td>
                <td><strong>District</strong></td>
                <td><strong>Status</strong></td>
                <td><strong>Action</strong></td>

              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($rows_list as $rows) {
                $userState = getState_byID($rows['user_state']);
                $user_district = getdistrict_byID($rows['user_district']);

                // admin edit only self 
                if ($rows['user_id'] == 1 && $_SESSION['AdminLogin'] != 1) {
                  continue;
                }
              ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><a href="javascript:void(0)">
                      <img src="<?= SITEPATH; ?><?= ($rows['user_logo']) ? $config['Images'] . $rows['user_logo'] : NOIMAGE; ?>" style="width: 80px;height: 80px;border-radius: 20px;">
                    </a>
                  </td>
                  <td><b><?= $rows['first_name']; ?></b></td>
                  <td><?= $rows['user_email']; ?></td>
                  <td><?= decryptIt($rows['user_pass']); ?></td>
                  <td><?= $rows['user_phone']; ?></td>
                  <td><?= $config['user_type'][$rows['user_type']]; ?></td>
                  <td><?= $rows['user_address'] ?></td>
                  <td><?= $userState['name']; ?></td>
                  <td><?= $user_district['district_name']; ?></td>
                  <td>
                    <?php if ($rows['user_status'] == 0) { ?>
                      <i class="fa fa-check-circle" title="Active" style="color: green;"></i>
                    <?php } else { ?>
                      <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                    <?php  } ?>
                  </td>


                  <td id="font12">
                    <?php if ($per['user']['edit'] == 1) { ?>

                      <?php if ($rows['user_id'] != 1) { ?>
                        <a href="javascript:void(0)" onmouseover="showbox('status<?= $i ?>')" onmouseout="hidebox('status<?= $i ?>')" onclick="return confirmStatus('<?= urlencode(encryptIt($rows['user_id'])); ?>');">
                          <?php if ($rows['user_status'] == "0") : ?>
                            <i class="fa fa-angle-double-up" style="color: green;"></i>
                          <?php else : ?>
                            <i class="fa fa-angle-double-down" style="color: red;"></i>
                          <?php endif; ?>
                        </a>
                        <div id="status<?= $i ?>" class="hide1">
                          <p><?= $rows['user_status'] == "0" ? 'Active' : 'Inactive' ?></p>
                        </div>

                      <?php } ?>

                      <?php if ($r['user_id'] == "1") { ?>
                        &nbsp;&nbsp; <a href="<?= SITEPATH; ?>admin/user/setting.php?id=<?= urlencode(encryptIt($rows['user_id'])); ?>" onMouseOver="showbox('Setting<?= $i; ?>')" onMouseOut="hidebox('Setting<?= $i; ?>')"> <i class="fa fa-cogs"></i></a>
                        <div id="Setting<?= $i; ?>" class="hide1">
                          <p>Setting</p>
                        </div><?php } ?>

                      &nbsp;&nbsp; <a href="<?= SITEPATH; ?>admin/user/add-new-user.php?id=<?= urlencode(encryptIt($rows['user_id'])); ?>" onMouseOver="showbox('Edit<?= $i; ?>')" onMouseOut="hidebox('Edit<?= $i; ?>')"> <i class="fa fa-pencil"></i></a>
                      <div id="Edit<?= $i; ?>" class="hide1">
                        <p>Edit</p>
                      </div>

                    <?php } ?>

                    &nbsp;&nbsp;
                    <?php /* if ($per['user']['del'] == 1 && $rows['user_id'] != 1) { ?>
                      <a href="javascript:void(0)" onclick="return confirmDelete('<?= urlencode(encryptIt($rows['user_id'])); ?>');" onMouseOver="showbox('Delete<?= $i; ?>')" onMouseOut="hidebox('Delete<?= $i; ?>')"><i class="fa fa-times"></i></a>
                      <div id="Delete<?= $i; ?>" class="hide1">
                        <p>Delete</p>
                      </div>
                    <?php } */ ?>

                  </td>

                </tr>
              <?php
                $i++;
              } ?>
            </tbody>
          </table>

          <script>
            function confirmDelete(id) {
              Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
              }).then((result) => {
                if (result.isConfirmed) {
                  var deleteUrl = "<?= SITEPATH; ?>admin/action/user.php?action=del&id=" + id;
                  window.location.href = deleteUrl;
                }
              });

              return false;
            }

            function confirmStatus(id) {
              Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to change the status of this user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  var statusChange = `<?= SITEPATH; ?>admin/action/user.php?action=status&id=${id}`;
                  window.location.href = statusChange;
                }
              });

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