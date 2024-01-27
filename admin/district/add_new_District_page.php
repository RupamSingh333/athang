<?php
include("../../system_config.php");
include_once("../common/head.php");

$name = "Add New District";
if (isset($_GET['id'])) {
  $name = "Update District";
  $id = urlencode(decryptIt($_GET['id']));
  $row = getdistrict_byID($id);
}
?>

<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php include_once("../common/left_menu.php"); ?>
    <div class="content-wrapper">
      <!-- Content Header -->
      <section class="content-header">
        <h1><?php echo $name; ?></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><?php echo $name; ?></li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="box box-info">
          <form id="form" name="form" action="<?php echo SITEPATH; ?>admin/action/district.php?action=save" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>State Name</label>
                    <select id="state_id" name="state_id" class="form-control">
                      <?php
                      $rows_list = getState_list(101);
                      foreach ($rows_list as $rows) { ?>
                        <option value="<?php echo $rows['id']; ?>" <?php if ($rows['id'] == $row['state_id'])  echo "selected"; ?>><?php echo $rows['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>District Name</label>
                    <input id="title" class="form-control" name="title" type="text" REQUIRED value="<?php echo (isset($row['district_name'])) ? $row['district_name'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Description</label>
                    <input id="district_description" class="form-control" name="district_description" type="text" REQUIRED value="<?php echo (isset($row['district_description'])) ? $row['district_description'] : ''; ?>" />
                  </div>
                </div>
                <div class="clearfix"></div>
                <!-- <div class="clearfix"></div> -->
                <!-- <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Upload Image :</label>
                    <input type="file" name="images" id="images" accept="image/*" class="form-control" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div> -->
                
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Status</label>
                    <select id="select" name="select" class="form-control">
                      <?php
                      foreach ($config['display_status'] as $key => $value) {
                        $selected = ($key == $row['district_status']) ? ' selected="selected"' : '';
                        echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>

                <!--buttons-->
                <div class="clearfix"></div>
                <div class="btn-submit-active">
                  <input type="submit" value="Submit" />
                  <span></span>
                </div>
                <a href="<?php echo SITEPATH; ?>/admin/District" class="btn btn-cancel">Cancel</a>
              </div>
            </div>
          </form>
          <div class="box-footer clearfix"> </div>
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