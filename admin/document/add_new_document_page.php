<?php
include("../../system_config.php");
include_once("../common/head.php");
$name = "Add New Document";
if (isset($_GET['id'])) {
  $name = "Update Document";
  $id = urlencode(decryptIt($_GET['id']));
  $row = getdocument_byID($id);
}
?>
<script type="text/javascript" src="<?php echo SITEPATH; ?>syspanel/js/custom.js"></script>
<script language="javascript" type="text/javascript">
  function getXMLHTTP() {
    var xmlhttp = false;
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e1) {
          xmlhttp = false;
        }
      }
    }

    return xmlhttp;
  }

  function getState(countryId) {
    var strURL = "<?php echo SITEPATH; ?>admin/user/findState.php?country=" + countryId;
    var req = getXMLHTTP();
    if (req) {

      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          if (req.status == 200) {
            document.getElementById('statediv').innerHTML = req.responseText;
            document.getElementById('citydiv').innerHTML = '<select name="city"required class="form-control1">' +
              '<option>Select District</option>' +
              '</select>';
          } else {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  }
</script>


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
          <form id="form" name="form" action="<?php echo SITEPATH; ?>admin/action/document.php?action=save" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">


                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Category Name</label>
                    <select id="cat_id" name="cat_id" class="form-control">
                      <?php
                      $rows_list = getCategory_list();
                      $i = 1;
                      foreach ($rows_list as $rows) { ?>
                        <option value="<?php echo $rows['cat_id']; ?>" <?php if ($rows['cat_id'] == $row['cat_id'])  echo "selected"; ?>><?php echo $rows['cat_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Record Count</label>
                    <input id="count" class="form-control" name="count" type="text" REQUIRED value="<?php echo (isset($row['count'])) ? $row['count'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Price</label>
                    <input id="price" class="form-control" name="price" type="text" REQUIRED value="<?php echo (isset($row['price'])) ? $row['price'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Document Title</label>
                    <input id="document_name" class="form-control" name="document_name" type="text" REQUIRED value="<?php echo (isset($row['document_name'])) ? $row['document_name'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>
                <div class="col-sm-8 col-md-8 col-lg-8">
                  <div class="form-group">
                    <label>Short Description</label>
                    <input id="s_desc" class="form-control" name="s_desc" type="text" REQUIRED value="<?php echo (isset($row['s_desc'])) ? $row['s_desc'] : ''; ?>" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="document_description" id="editor"><?php echo (isset($row['document_description'])) ? stripslashes($row['document_description']) : ''; ?></textarea>
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Upload Sample :</label>
                    <input type="file" name="document_sample" id="document_sample" class="form-control" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Upload File :</label>
                    <input type="file" name="document_file" id="document_file" class="form-control" />
                    <label class="label-brdr" style="width: 0%;"></label>
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Status</label>
                    <select id="document_status" name="document_status" class="form-control">
                      <?php
                      foreach ($config['display_status'] as $key => $value) {
                        $selected = ($key == $row['document_status']) ? ' selected="selected"' : '';
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
                <a href="<?php echo SITEPATH; ?>admin/News" class="btn btn-cancel">Cancel</a>
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
  <script>
    initSample();
  </script>
</body>

</html>