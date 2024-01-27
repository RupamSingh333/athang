<?php
error_reporting(0);

include("../../system_config.php");
include_once("../common/head.php");
$name = "Add New User";

if (isset($_GET['id'])) {
  $name = "Update Settings";
  $id = decryptIt($_GET['id']);
  $user_id =  decryptIt($_GET['id']);
  $res = getuser_byID($id);
}
extract($_REQUEST);

$modules_query = mysqli_query($link, "SELECT * FROM `user_permission` GROUP BY module");
$modules = mysqli_fetch_all($modules_query, MYSQLI_ASSOC);


if ($_REQUEST['Submit']) {

  foreach ($modules as $module) {
    $q = mysqli_query($link, "SELECT * FROM `user_permission` WHERE user_id='" . $user_id . "' AND module='" . $module['module'] . "'");

    if (!mysqli_num_rows($q)) {
      $qq = "INSERT INTO `user_permission` (`user_id`, `module`, `add`, `view`, `edit`, `del`)
            VALUES
            ('" . $user_id . "', '" . $module['module'] . "', '0', '0', '0', '0');";
      mysqli_query($link, $qq);
    }
  }

  mysqli_query($link, "UPDATE `user_permission` SET `add` = '0', `view` = '0', `edit` = '0', `del` = '0' WHERE `user_permission`.`user_id` = '" . $user_id . "'");

  // Update permissions based on the submitted data
  foreach ($modules as $module) {
    $module_name = $module['module'];

    if (isset($_REQUEST[$module_name])) {
      $query = "UPDATE `user_permission` SET `module` = '" . $module_name . "'";

      foreach ($_REQUEST[$module_name] as $action) {
        $field = explode("_", $action);
        $query .= ", `" . $field[0] . "` = '1'";
      }

      $query .= " WHERE `user_id` = '" . $user_id . "' AND `module` = '" . $module_name . "'";
      mysqli_query($link, $query);
    }
  }
}
?>


<?php
if (isset($_GET['id'])) {
  $id = decryptIt($_GET['id']);
  $user_id =  decryptIt($_GET['id']);
  $res = getuser_byID($id);
  $name = "Update Settings For (" . $res['first_name'] . ")";
  // pr($res);die;
} ?>

<style>
  .check {
    height: 17px;
    width: 17px;
  }
  .form-group {
    position: relative;
    margin-bottom: 0px!important;
    margin-top: 0px!important;
}


</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js" type="text/javascript"></script>
</head>

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
          <form id="form" name="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">


                <!-- All Managers Start -->

                <?php foreach ($modules as $module) : ?>
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <h4 class="divd"><?= ucwords(strtolower($module['module'])) ?> Management</h4>

                    <?php
                    $permission_query = mysqli_query($link, "SELECT * FROM `user_permission` WHERE user_id='" . $id . "' AND module='" . $module['module'] . "'");
                    $permissions = mysqli_fetch_array($permission_query);

                    $actions = ['add', 'view', 'edit', 'del'];
                    ?>

                    <!-- Add a "Select All" checkbox -->
                    <div class="col-sm-3 col-md-3 col-lg-3">
                      <div class="form-group">
                        <input type="checkbox" class="check-all check" data-module="<?= $module['module'] ?>" />
                        <label>&nbsp;&nbsp; Select All</label>
                      </div>
                    </div>

                    <?php foreach ($actions as $action) : ?>
                      <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                          <input type="checkbox" class="check" name="<?= $module['module'] ?>[]" value="<?= $action . '_' . $module['module'] ?>" <?= ($permissions[$action] == 1) ? 'checked="checked"' : '' ?> />
                          <label>&nbsp;&nbsp; <?= ucfirst($action) ?> <?= ucwords(strtolower($module['module'])) ?></label>
                        </div>
                      </div>
                    <?php endforeach; ?>

                  </div>
                <?php endforeach; ?>

                <!-- Add JavaScript to handle "Select All" functionality -->
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const checkAllButtons = document.querySelectorAll('.check-all');

                    checkAllButtons.forEach(function(checkAllButton) {
                      checkAllButton.addEventListener('change', function() {
                        const moduleName = this.getAttribute('data-module');
                        const checkboxes = document.querySelectorAll(`[name="${moduleName}[]"]`);

                        checkboxes.forEach(function(checkbox) {
                          checkbox.checked = checkAllButton.checked;
                        });
                      });
                    });
                  });
                </script>


                <!-- User Manager End -->


                <div class="btn-submit-active">
                  <input type="submit" id="validate" value="Submit" name="Submit" />
                  <span></span>
                </div>
                <a href="<?php echo SITEPATH; ?>admin/user" class="btn btn-cancel">Cancel</a>
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