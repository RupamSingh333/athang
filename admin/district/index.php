<?php
include("../../system_config.php");
include_once("../common/head.php");
$rows_list = getdistrict_list();
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
      <section class="content-header">
        <h1>District Management</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
          <li class="active">View All Districts</li>
        </ol>
      </section>

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


      <section class="content">
        <h1 align="center" style="color: #337ab7;"><?php echo $_SESSION['message'];
                                                    unset($_SESSION['message']); ?></h1>
        <div class="table-responsive" style="overflow-x: auto;">
          <table id="exportable" align="center" class="table table-bordered table-condensed table-hover">
            <thead>
              <tr>
                <td><strong>Sr No</strong></td>
                <!-- <td><strong>Image</strong></td> -->
                <td><strong>District Name</strong></td>
                <td><strong>State Name</strong></td>
                <!-- <td><strong>District Start Date</strong></td> -->
                <td><strong>Description</strong></td>
                <td><strong>Status</strong></td>
                <td><strong>Action</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($rows_list as $rows) {
                $res = getState_byID($rows['state_id']);
              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <!-- <td>
                    <a class="iframe" href="#"><img src="<?php //echo SITEPATH; 
                                                          ?>upload/thumb/<?php //echo $rows['district_img']; 
                                                                          ?>" width="50px" height="50px"></a>
                  </td> -->
                  <td><?php echo $rows['district_name']; ?></td>
                  <td><?php echo $res['name']; ?></td>
                  <!-- <td><?php echo $rows['district_startfrom']; ?></td> -->
                  <td><?php echo $rows['district_description']; ?></td>
                  <td>

                    <?php if ($rows['district_status'] == 0) { ?>
                      <i class="fa fa-check-circle" title="Active" style="color: green;"></i>
                    <?php } else { ?>
                      <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                    <?php  } ?>
                  </td>
                  <td id="font12" width="15%"><a href="javascript:void(0)" onclick="return confirmStatus('<?= urlencode(encryptIt($rows['district_id'])); ?>');" <?php if ($rows['district_status'] == "0") { ?> onMouseOver="showbox('active<?php echo $i; ?>')" onMouseOut="hidebox('active<?php echo $i; ?>')"><i class="fa fa-angle-double-up"></i>
                    <?php } else { ?>
                      onMouseOver="showbox('inactive<?php echo $i; ?>')" onMouseOut="hidebox('inactive<?php echo $i; ?>')"> <i class="fa fa-angle-double-down"></i>
                    <?php } ?>
                    </a>
                    <div id="active<?php echo $i; ?>" class="hide1">
                      <p>Active</p>
                    </div>
                    <div id="inactive<?php echo $i; ?>" class="hide1">
                      <p>Inactive</p>
                    </div>

                    &nbsp;&nbsp;
                    <a href="<?php echo SITEPATH; ?>admin/district/add-new-district-page.php?id=<?= urlencode(encryptIt($rows['district_id'])); ?>" onMouseOver="showbox('Edit<?php echo $i; ?>')" onMouseOut="hidebox('Edit<?php echo $i; ?>')"> <i class="fa fa-pencil"></i>
                    </a>

                    <div id="Edit<?php echo $i; ?>" class="hide1">
                      <p>Edit</p>
                    </div>
                    &nbsp;&nbsp;

                    <!-- <a href="#" onClick="return confirmDelete('<?php echo  urlencode(encryptIt($rows['district_id'])); ?>');" onMouseOver="showbox('Delete<?php echo $i; ?>')" onMouseOut="hidebox('Delete<?php echo $i; ?>')"><i class="fa fa-times"></i>
                    </a>
                    <div id="Delete<?php echo $i; ?>" class="hide1">
                      <p>Delete</p>
                    </div> -->
                  </td>
                </tr>
              <?php
                $i++;
              }
              ?>
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
                  var deleteUrl = "<?php echo SITEPATH; ?>admin/action/district.php?action=del&id=" + id;
                  window.location.href = deleteUrl;
                }
              });

              return false;
            }

            function confirmStatus(id) {
              Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to change the status of this district ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  var statusChange = `<?= SITEPATH; ?>admin/action/district.php?action=status&id=${id}`;

                  window.location.href = statusChange;
                }
              });

            }
          </script>


        </div>
      </section>
    </div>
    <footer class="main-footer">
      <?php include_once("../common/copyright.php"); ?>
    </footer>
  </div>
  <?php include_once("../common/footer.php"); ?>
</body>

</html>