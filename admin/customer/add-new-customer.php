<?php
include("../../system_config.php");
include_once("../common/head.php");
$name = "Add New Customer";
if (isset($_GET['id'])) {
  $name = "Update Customer";
  $id = decryptIt($_GET['id']);
  $res = getcustomer_byID($id);
}

if ($per['user']['add'] == 0) { ?>
  <script>
    window.location.href = "../dashboard.php";
  </script>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#cust_email").change(function() {
      var cust_email = $("#cust_email").val();
      var msgbox = $("#status");

      if (cust_email.length > 3) {
        $("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');

        $.ajax({
          type: "POST",
          url: "check_ajax.php",
          data: "cust_email=" + cust_email,
          success: function(msg) {

            $("#status").ajaxComplete(function(event, request) {

              if (msg == 'OK') {

                $("#cust_email").removeClass("red");
                $("#cust_email").addClass("green");
                msgbox.html('<img src="yes.png" align="absmiddle"> <font color="Green"> Available </font>  ');
              } else {
                $("#cust_email").removeClass("green");
                $("#cust_email").addClass("red");
                msgbox.html(msg);
              }

            });
          }

        });

      } else {
        $("#cust_email").addClass("red");
        $("#status").html('<font color="#cc0000">Enter valid User Name</font>');
      }

      return false;
    });

  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#cust_phone").change(function() {

      var cust_phone = $("#cust_phone").val();
      var msgbox = $("#status2");


      if (cust_phone.length > 3) {
        $("#status2").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');

        $.ajax({
          type: "POST",
          url: "check_ajax2.php",
          data: "cust_phone=" + cust_phone,
          success: function(msg) {

            $("#status2").ajaxComplete(function(event, request) {

              if (msg == 'OK') {

                $("#cust_phone").removeClass("red");
                $("#cust_phone").addClass("green");
                msgbox.html('<img src="yes.png" align="absmiddle"> <font color="Green"> Available </font>  ');
              } else {
                $("#cust_phone").removeClass("green");
                $("#cust_phone").addClass("red");
                msgbox.html(msg);
              }

            });
          }

        });

      } else {
        $("#cust_phone").addClass("red");
        $("#status2").html('<font color="#cc0000">Enter valid User Name</font>');
      }



      return false;
    });

  });
</script>

</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
  <div class="wrapper">
    <?php
    include_once("../common/left_menu.php"); ?>
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
          <div class="box-header with-border"> </div>
          <form id="form" name="form" action="<?php echo SITEPATH; ?>admin/action/customer.php?action=save" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Login Detail</h4>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" id="cust_email" name="cust_email" placeholder="" value="<?php echo $res['cust_email']; ?>" type="text" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                
                </div>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label> <span id="status"></span></label>
                </div>
              </div>
              <h2 id='result'></h2>
              <div class="clearfix"></div>

              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Mobile Number</label>
                  <input class="form-control" id="cust_phone" name="cust_phone" placeholder="Enter Mobile" value="<?php echo $res['cust_phone']; ?>" type="number" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                
                </div>
              </div>

              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Alternate Number</label>
                  <input class="form-control" id="cust_alter_phone" name="cust_alter_phone" placeholder="Alter Mobile" value="<?php echo $res['cust_alter_phone']; ?>" type="number" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                
                </div>
              </div>

              <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label> <span id="status2"></span></label>
                </div>
              </div>

              <h2 id='result2'></h2>
              <div class="clearfix"></div>

              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Password</label>
                  <input class="form-control" name="cust_password" id="password" placeholder="Enter Password" minlength="6" value="<?= !empty($res['cust_password']) ? decryptIt($res['cust_password']) : '' ?>" type="password" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">

                
                </div>
              </div>

              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input class="form-control" name="confirm_password" id="confirm_password" minlength="6" placeholder="Confirm Password" value="<?= !empty($res['cust_password']) ? decryptIt($res['cust_password']) : '' ?>" type="password" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                
                </div>
              </div>

              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label> <span id='message'></span></label>
                </div>
              </div>

              <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Profile Detail</h4>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Name of Person</label>
                    <input class="form-control" required name="cust_first_name" placeholder="Name of Person" type="text" value="<?php echo $res['cust_first_name']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="cust_org_name">
                  <div class="form-group">
                    <label>Name of Business</label>
                    <input class="form-control" id="cust_org_name_val" required name="cust_org_name" placeholder="Name of Business" type="text" value="<?php echo $res['cust_org_name']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="cust_org_type">
                  <div class="form-group">
                    <label>Business Activity Or Type of Business</label>
                    <input class="form-control" id="cust_org_type_val" required name="cust_org_type" placeholder="Business Activity Or Type of Business" type="text" value="<?php echo $res['cust_org_type']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="cust_aadhar_no">
                  <div class="form-group">
                    <label>Aadhar Number</label>
                    <input class="form-control" required id="cust_aadhar_no_val" name="cust_aadhar_no" placeholder="Aadhar Number" type="number" value="<?php echo $res['cust_aadhar_no']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Aadhar Link Mobile</label>
                    <input class="form-control" required id="aadhar_link_mobile" name="aadhar_link_mobile" placeholder="Aadhar Link Mobile" type="number" value="<?php echo $res['aadhar_link_mobile']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="cust_gst_no">
                  <div class="form-group">
                    <label>GST Number</label>
                    <input class="form-control" id="cust_gst_no_val" name="cust_gst_no" placeholder="GST Number" type="text" value="<?php echo $res['cust_gst_no']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="b_acc_name_of_link">
                  <div class="form-group">
                    <label>Bank Acc Name of Link</label>
                    <input class="form-control" id="b_acc_name_of_link" name="b_acc_name_of_link" placeholder="Bank Acc Name of Link" type="link" value="<?php echo $res['b_acc_name_of_link']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3" id="dmt_acc_name_of_link">
                  <div class="form-group">
                    <label>Demat Acc Name of Link</label>
                    <input class="form-control" id="dmt_acc_name_of_link" name="dmt_acc_name_of_link" placeholder="Bank Acc Name of Link" type="link" value="<?php echo $res['dmt_acc_name_of_link']; ?>" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="cust_selfie">Selfee</label>
                    <input type="file" name="cust_selfie" id="cust_selfie" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_selfie'])) { ?>
                      <a target="" href="<?php echo SITEPATH; ?><?php echo ($res['cust_selfie']) ? 'upload/Images/' . $res['cust_selfie'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Aadhar Card(Front)</label>
                    <input type="file" name="cust_aadhar_card_front" id="cust_aadhar_card_front" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_aadhar_card_front'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['cust_aadhar_card_front']) ? 'upload/Images/' . $res['cust_aadhar_card_front'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Aadhar Card(Back)</label>
                    <input type="file" name="cust_aadhar_card_back" id="cust_aadhar_card_back" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_aadhar_card_back'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['cust_aadhar_card_back']) ? 'upload/Images/' . $res['cust_aadhar_card_back'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="cust_pan_card">Pan Card</label>
                    <input type="file" name="cust_pan_card" id="cust_pan_card" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_pan_card'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['cust_pan_card']) ? 'upload/Images/' . $res['cust_pan_card'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>


                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Signature</label>
                    <input type="file" name="cust_signature" id="cust_signature" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_signature'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['cust_signature']) ? 'upload/Images/' . $res['cust_signature'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Agreement Copy</label>
                    <input type="file" name="cust_agreement_copy" id="cust_agreement" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['cust_agreement_copy'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['cust_agreement_copy']) ? 'upload/Images/' . $res['cust_agreement_copy'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Bank Account Screenshot</label>
                    <input type="file" multiple name="b_acc_screenshot[]" id="b_acc_screenshot" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['b_acc_screenshot'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['b_acc_screenshot']) ? 'upload/Images/' . $res['b_acc_screenshot'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Demat Account Screenshot</label>
                    <input type="file" multiple name="dmt_acc_screenshot[]" id="dmt_acc_screenshot" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['dmt_acc_screenshot'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['dmt_acc_screenshot']) ? 'upload/Images/' . $res['dmt_acc_screenshot'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>ITR Bank Statement</label>
                    <input type="file" multiple name="itr_bank_statement[]" id="itr_bank_statement" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['itr_bank_statement'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['itr_bank_statement']) ? 'upload/Images/' . $res['itr_bank_statement'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Salary Sheet</label>
                    <input type="file" multiple name="salary_sheet[]" id="salary_sheet" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['salary_sheet'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['salary_sheet']) ? 'upload/Images/' . $res['salary_sheet'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Form16</label>
                    <input type="file" name="form16" id="form16" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['form16'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['form16']) ? 'upload/Images/' . $res['form16'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>B/S Bank Statement</label>
                    <input type="file" multiple name="bs_bank_statemenet[]" id="bs_bank_statemenet" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['bs_bank_statemenet'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['bs_bank_statemenet']) ? 'upload/Images/' . $res['bs_bank_statemenet'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Proof of Business</label>
                    <input type="file" multiple name="proof_of_buiseness[]" id="proof_of_buiseness" accept=".jpg, .jpeg, .png" class="form-control">
                    <?php if (!empty($res['proof_of_buiseness'])) { ?>
                      <a target="_blank" href="<?php echo SITEPATH; ?><?php echo ($res['proof_of_buiseness']) ? 'upload/Images/' . $res['proof_of_buiseness'] : NOIMAGE; ?>">View File uploaded</a>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Address</h4>
                </div>

                <script>
                  function getDistrict(stateId) {
                    var stateDropdown = document.getElementById('user_state');
                    var districtDropdown = document.getElementById('district_id');
                    var talukaDropdown = document.getElementById('taluka_id');

                    if (stateId) {
                      districtDropdown.disabled = false;
                      talukaDropdown.disabled = true;
                      talukaDropdown.innerHTML = '<option value="">Select a District first</option>';

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
                      talukaDropdown.disabled = true;
                      talukaDropdown.innerHTML = '<option value="">Select a District first</option>';
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

                  function getTaluka(distId) {
                    var districtDropdown = document.getElementById('district_id');
                    var talukaDropdown = document.getElementById('taluka_id');

                    if (distId) {
                      talukaDropdown.disabled = false;

                      fetchTaluka(distId)
                        .then(function(response) {
                          populateTaluka(response.talukas);
                        })
                        .catch(function(error) {
                          console.log('Error:', error);
                        });
                    } else {
                      districtDropdown.disabled = true;
                      talukaDropdown.disabled = true;
                      districtDropdown.innerHTML = '<option value="">Select a State first</option>';
                      talukaDropdown.innerHTML = '<option value="">Select a District first</option>';
                    }
                  }

                  function fetchTaluka(distId) {
                    return fetch('get_states_cites.php?distId=' + distId)
                      .then(function(response) {
                        if (!response.ok) {
                          throw new Error('Failed to fetch talukas');
                        }
                        return response.json();
                      });
                  }

                  function populateTaluka(talukas) {
                    var talukaDropdown = document.getElementById('taluka_id');
                    talukaDropdown.innerHTML = '<option value="">Select a Taluka</option>';
                    talukas.forEach(function(taluka) {
                      var option = document.createElement('option');
                      option.value = taluka.taluka_id;
                      option.textContent = taluka.taluka_name;
                      talukaDropdown.appendChild(option);
                    });
                  }
                </script>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>State Name</label>
                    <select id="cust_state" name="cust_state" onchange="getDistrict(this.value)" class="form-control">
                      <?php
                      $rows_list = getState_list(101);
                      foreach ($rows_list as $rows) { ?>
                        <option value="<?php echo $rows['id']; ?>" <?php if ($rows['id'] == $res['cust_state'])  echo "selected"; ?>><?php echo $rows['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>District Name</label>
                    <select id="district_id" name="cust_district_id" class="form-control" onchange="getTaluka(this.value)" required <?php echo empty($res['cust_district_id']) ? 'disabled' : ''; ?>>
                      <option>Select a State first</option>
                      <?php
                      if (!empty($res['cust_district_id'])) {
                        $rows_list = getdistrict_list();
                        foreach ($rows_list as $distDetails) { ?>
                          <option value="<?php echo $distDetails['district_id']; ?>" <?php if ($distDetails['district_id'] == $res['cust_district_id'])  echo "selected"; ?>><?php echo $distDetails['district_name']; ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Taluka</label>
                    <select id="taluka_id" name="cust_taluka_id" class="form-control" required>
                      <option>Select a District first</option>
                      <?php
                      if (!empty($res['cust_taluka_id'])) {
                        $gettaluka_list = gettaluka_list();
                        foreach ($gettaluka_list as $talukaDetails) { ?>
                          <option value="<?php echo $talukaDetails['taluka_id']; ?>" <?php if ($talukaDetails['taluka_id'] == $res['cust_taluka_id'])  echo "selected"; ?>><?php echo $talukaDetails['taluka_name']; ?></option>
                      <?php }
                      } ?>
                    </select>

                  </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>Pincode</label>
                    <input class="form-control" name="cust_pincode" placeholder="Pincode" value="<?php echo $res['cust_pincode']; ?>" type="number" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Full Address</label>
                    <input class="form-control" required name="cust_address" placeholder="Full Address" value="<?php echo $res['cust_address']; ?>" type="text" onFocus="txtFocus(this);" onfocusout="txtFocusOut(this);">
                  
                  </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Other Information</h4>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>Shop Act License</label>
                    <select id="shop_act_licence" name="shop_act_licence" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['shop_act_licence'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>Food License</label>
                    <select id="food_licence" name="food_licence" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['food_licence'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>Bank Acc Opening</label>
                    <select id="bank_acc_opening" name="bank_acc_opening" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['bank_acc_opening'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>Demat Acc Opening</label>
                    <select id="demate_acc_opening" name="demate_acc_opening" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['demate_acc_opening'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>ITR</label>
                    <select id="itr" name="itr" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['itr'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>B/S</label>
                    <select id="bs" name="bs" class="form-control">
                      <option value="N">N</option>
                      <option value="Y" <?= ($res['bs'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select id="cust_status" name="cust_status" class="form-control">
                      <?php
                      foreach ($config['display_status'] as $key => $value) {
                        $selected = ($key == $res['cust_status']) ? ' selected="selected"' : '';
                        echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>


                <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="cust_desc" id="cust_desc" placeholder="Write something here ......" cols="168" rows="5"><?php echo $res['cust_desc']; ?></textarea>
                  </div>
                </div>


                <!--buttons-->
                <div class="clearfix"></div>

                <div class="btn-submit-active">
                  <input type="submit" value="Submit" />
                  <span></span>
                </div>

                <a href="<?php echo SITEPATH; ?>admin/customer" class="btn btn-cancel">Cancel</a>

              </div>

            </div>
          </form>
          <div class="box-footer clearfix"> </div>
        </div>
      </section>
    </div>
    <script>
      function myFunction() {
        if (document.getElementById("cust_member_type").value == "1") {
          document.getElementById("cust_org_name").style.display = 'none';
          document.getElementById("cust_gst_no").style.display = 'none';
          document.getElementById("cust_org_name_val").required = false;
          document.getElementById("cust_gst_no_val").required = false;

        } else {
          document.getElementById("cust_org_name").style.display = 'block';
          document.getElementById("cust_gst_no").style.display = 'block';
          document.getElementById("cust_org_name_val").required = true;
          document.getElementById("cust_gst_no_val").required = true;
        }

      }
    </script>
    <!--close page contets , start footer-->
    <footer class="main-footer">
      <?php include_once("../common/copyright.php"); ?>
    </footer>
  </div>
  <script>
    $('#password, #confirm_password').on('keyup', function() {
      if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
      } else
        $('#message').html('Not Matching').css('color', 'red');
    });
  </script>
  <script type="text/javascript">
    <?php
    if ($r['cust_member_type'] == "1") {
    ?>

      function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }
    <?php } ?>

    function validate() {
      var email = $("#cust_email").val();

      if (validateEmail(email)) {
        return true;
      } else {
        alert(email + " is not valid");
        return false;
      }

    }

    $("#validate").on("click", validate);
  </script>
  <?php include_once("../common/footer.php"); ?>
</body>

</html>