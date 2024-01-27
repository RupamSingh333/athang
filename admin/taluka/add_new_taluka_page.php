<?php
include("../../system_config.php");
include_once("../common/head.php");

$name = "Add New Taluka";
if (isset($_GET['id'])) {
  $name = "Update Taluka";
  $id = urlencode(decryptIt($_GET['id']));
  $res = gettaluka_byID($id);
  // pr($res);exit;
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
          <form id="form" name="form" action="<?php echo SITEPATH; ?>admin/action/taluka.php?action=save" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">

                    <label>State</label>
                    <select id="cust_state" name="taluka_state_id" onchange="getDistrict(this.value)" class="form-control">
                      <?php
                      $rows_list = getState_list(101);
                      foreach ($rows_list as $stateDetail) {
                        $selected = ($stateDetail['id'] == $res['taluka_state_id']) ? 'selected' : '';
                        echo '<option value="' . $stateDetail['id'] . '" ' . $selected . '>' . $stateDetail['name'] . '</option>';
                      }

                      ?>
                    </select>

                  </div>
                </div>
                <!-- Get district by state  -->
                <script>
                  function getDistrict(stateId) {
                    var stateDropdown = document.getElementById('cust_state');
                    var districtDropdown = document.getElementById('district_id');

                    if (stateId) {
                      districtDropdown.disabled = false;

                      fetchDistrict(stateId)
                        .then(function(response) {
                          populateDistrict(response.districts);
                        })
                        .catch(function(error) {
                          console.log('Error:', error);
                        });
                    } else {
                      stateDropdown.disabled = true;
                      districtDropdown.disabled = true;
                      stateDropdown.innerHTML = '<option value="">Select a State first</option>';
                      districtDropdown.innerHTML = '<option value="">Select a State first</option>';
                    }
                  }

                  function fetchDistrict(stateId) {
                    return fetch('get_states_cites.php?district=' + stateId)
                      .then(function(response) {
                        if (!response.ok) {
                          throw new Error('Failed to fetch districts');
                        }
                        return response.json();
                      });
                  }

                  function populateDistrict(districts) {
                    var districtDropdown = document.getElementById('district_id');
                    districtDropdown.innerHTML = '<option value="">Select a District</option>';
                    districts.forEach(function(district) {
                      var option = document.createElement('option');
                      option.value = district.district_id;
                      option.textContent = district.district_name;
                      districtDropdown.appendChild(option);
                    });
                  }
                </script>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>District Name</label>
                    <select id="district_id" name="taluka_district_id" class="form-control" required <?php echo empty($res['taluka_district_id']) ? 'disabled' : ''; ?>>
                      <option>Select a State first</option>
                      <?php
                      if (!empty($res['taluka_district_id'])) {
                        $rows_list = getdistrict_list();
                        foreach ($rows_list as $distDetails) { ?>
                          <option value="<?php echo $distDetails['district_id']; ?>" <?php if ($distDetails['district_id'] == $res['taluka_district_id'])  echo "selected"; ?>><?php echo $distDetails['district_name']; ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Taluka Name</label>
                    <input id="taluka-id" class="form-control" name="taluka_name" type="text" required value="<?php echo (isset($res['taluka_name'])) ? $res['taluka_name'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Description</label>
                    <input id="district_description" class="form-control" name="taluka_desc" type="text" required value="<?php echo (isset($res['taluka_desc'])) ? $res['taluka_desc'] : ''; ?>" />
                  </div>
                </div>

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
                    <select id="select" name="taluka_status" class="form-control">
                      <?php
                      foreach ($config['display_status'] as $key => $value) {
                        $selected = ($key == $res['taluka_status']) ? ' selected="selected"' : '';
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
                <a href="<?php echo SITEPATH; ?>/admin/taluka" class="btn btn-cancel">Cancel</a>
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