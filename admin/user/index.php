<?php
include("../../system_config.php");
include_once("../common/head.php");
if ($r['user_type'] == "1") {
  $rows_list = getuser_byList();
} else {
  $rows_list = getuser_byID($_SESSION['AdminLogin']);
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


              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><a href="javascript:void(0)">
                      <img src="<?php echo SITEPATH; ?><?php echo ($rows['user_logo']) ? '/upload/thumb/' . $rows['user_logo'] : NOIMAGE; ?>" style="width: 80px;height: 80px;border-radius: 20px;">

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


                  <td id="font12"><?php if ($per['user']['edit'] == 1) { ?>
                      <a href="<?php echo SITEPATH; ?>admin/action/user.php?action=status&id=<?php echo  urlencode(encryptIt($rows['user_id'])); ?>" <?php if ($rows['user_status'] == "0") { ?> onMouseOver="showbox('active<?php echo $i; ?>')" onMouseOut="hidebox('active<?php echo $i; ?>')"><i class="fa fa-angle-double-up" style="color: green;"></i>
                      <?php } else { ?>
                        onMouseOver="showbox('inactive<?php echo $i; ?>')" onMouseOut="hidebox('inactive<?php echo $i; ?>')"> <i class="fa fa-angle-double-down" style="color: red;"></i>
                      <?php } ?>
                      </a>
                      <div id="active<?php echo $i; ?>" class="hide1">
                        <p>Active</p>
                      </div>
                      <div id="inactive<?php echo $i; ?>" class="hide1">
                        <p>Inactive</p>
                      </div>

                      <?php if ($r['user_id'] == "1") { ?>
                        <?php ?> &nbsp;&nbsp; <a href="<?php echo SITEPATH; ?>admin/user/setting.php?id=<?php echo  urlencode(encryptIt($rows['user_id'])); ?>" onMouseOver="showbox('Setting<?php echo $i; ?>')" onMouseOut="hidebox('Setting<?php echo $i; ?>')"> <i class="fa fa-cogs"></i></a>
                        <div id="Setting<?php echo $i; ?>" class="hide1">
                          <p>Setting</p>
                        </div><?php } ?>
                      &nbsp;&nbsp; <a href="<?php echo SITEPATH; ?>admin/user/add-new-user.php?id=<?php echo  urlencode(encryptIt($rows['user_id'])); ?>" onMouseOver="showbox('Edit<?php echo $i; ?>')" onMouseOut="hidebox('Edit<?php echo $i; ?>')"> <i class="fa fa-pencil"></i></a>
                      <div id="Edit<?php echo $i; ?>" class="hide1">
                        <p>Edit</p>
                      </div>
                    <?php } ?>
                    &nbsp;&nbsp;
                    <?php if ($per['user']['del'] == 1 && $rows['user_id'] != 1) { ?>
                      <a href="<?php echo SITEPATH; ?>admin/action/user.php?action=del&id=<?php echo urlencode(encryptIt($rows['user_id'])); ?>" onclick="return confirmDelete('<?php echo urlencode(encryptIt($rows['user_id'])); ?>');" onMouseOver="showbox('Delete<?php echo $i; ?>')" onMouseOut="hidebox('Delete<?php echo $i; ?>')"><i class="fa fa-times"></i></a>
                      <div id="Delete<?php echo $i; ?>" class="hide1">
                        <p>Delete</p>
                      </div>


                    <?php } ?>

                  </td>

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