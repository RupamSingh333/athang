<?php
include("../../system_config.php");
include_once("../common/head.php");
$rows_list = gettaluka_list();
//if ($per['user']['view'] == 0) { 
?>
<!-- <script>
    window.location.href = "../dashboard.php";
  </script> -->
<?php //} 
?>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../common/left_menu.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Taluka Management</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
          <li class="active">View All Taluka</li>
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
                <td><strong>Sr No.</strong></td>
                <!-- <td><strong>Image</strong></td> -->
                <td><strong>Taluka Name</strong></td>
                <td><strong>State Name</strong></td>
                <td><strong>District Name</strong></td>
                <td><strong>District Start Date</strong></td>
                <td><strong>Description</strong></td>
                <td><strong>Action</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($rows_list as $rows) {
                $stateName = getState_byID($rows['taluka_state_id']);
                $taluka_district = getdistrict_byID($rows['taluka_district_id']);

              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <!-- <td><a class="iframe" href="#"><img src="<?php //echo SITEPATH; 
                                                                ?>upload/thumb/<?php //echo $rows['district_img']; 
                                                                                ?>" width="50px" height="50px"></a></td> -->
                  <td><?php echo $rows['taluka_name']; ?></td>
                  <td><?php echo $stateName['name']; ?></td>
                  <td><?php echo $taluka_district['district_name']; ?></td>
                  <td><?php echo $rows['taluka_createdAt']; ?></td>
                  <td><?php echo $rows['taluka_desc']; ?></td>

                  <td id="font12" width="15%">
                    <a href="<?php echo SITEPATH; ?>admin/action/taluka.php?action=status&id=<?php echo  urlencode(encryptIt($rows['taluka_id'])); ?>" <?php if ($rows['taluka_status'] == "0") { ?> onMouseOver="showbox('active<?php echo $i; ?>')" onMouseOut="hidebox('active<?php echo $i; ?>')"><i class="fa fa-angle-double-up"></i>
                    <?php } else { ?>
                      onMouseOver="showbox('inactive<?php echo $i; ?>')" onMouseOut="hidebox('inactive<?php echo $i; ?>')">
                      <i class="fa fa-angle-double-down"></i>
                    <?php } ?>
                    </a>
                    <div id="active<?php echo $i; ?>" class="hide1">
                      <p>Active</p>
                    </div>
                    <div id="inactive<?php echo $i; ?>" class="hide1">
                      <p>Inactive</p>
                    </div>
                    &nbsp;&nbsp;
                    <a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php?id=<?php echo  urlencode(encryptIt($rows['taluka_id'])); ?>" onMouseOver="showbox('Edit<?php echo $i; ?>')" onMouseOut="hidebox('Edit<?php echo $i; ?>')"> <i class="fa fa-pencil"></i>
                    </a>
                    <div id="Edit<?php echo $i; ?>" class="hide1">
                      <p>Edit</p>
                    </div>
                    &nbsp;&nbsp;
                    <a href="#" onClick="return confirmDelete('<?php echo urlencode(encryptIt($rows['taluka_id'])); ?>');" onMouseOver="showbox('Delete<?php echo $i; ?>')" onMouseOut="hidebox('Delete<?php echo $i; ?>')"><i class="fa fa-times"></i>
                    </a>
                    <div id="Delete<?php echo $i; ?>" class="hide1">
                      <p>Delete</p>
                    </div>
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
                  var deleteUrl = "<?php echo SITEPATH; ?>admin/action/taluka.php?action=del&id=" + id;
                  window.location.href = deleteUrl;
                }
              });

              return false;
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