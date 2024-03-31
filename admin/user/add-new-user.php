<?php
include("../../system_config.php");
include_once("../common/head.php");
$name = "Add New Employee";
// pr($_SESSION);exit;
if (isset($_GET['id'])) {
  $name = "Update User";
  $id = decryptIt($_GET['id']);
  $res = getuser_byID($id);
} else {
  if ($per['user']['add'] == 0) { ?>
    <script>
      window.location.href = "../dashboard.php";
    </script>
<?php }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js" type="text/javascript">
</script>


<script type="text/javascript">
  /*input hover effect*/
  function txtFocus(Inp) {
    $(Inp).next(".label-brdr").css("width", "100%");
    $(Inp).parent(".form-group").find("label").css("color", "#06b5ef");
  }

  function txtFocusOut(Inp) {
    $(Inp).next(".label-brdr").css("width", "0%");
    $(Inp).parent(".form-group").find("label").css("color", "#999");
  }

  $(document).ready(function() {

    $("#user_email").change(function() {
      var user_email = $("#user_email").val();
      var msgbox = $("#status");

      if (user_email.length > 3) {
        $("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');

        $.ajax({
          type: "POST",
          url: "check_ajax.php",
          data: "user_email=" + user_email,
          success: function(msg) {

            $("#status").ajaxComplete(function(event, request) {

              if (msg == 'OK') {
                $("#user_email").removeClass("red");
                $("#user_email").addClass("green");
                msgbox.html('<img src="yes.png" align="absmiddle"> <font color="Green"> Available </font>  ');
              } else {
                $("#user_email").removeClass("green");
                $("#user_email").addClass("red");
                msgbox.html(msg);
              }

            });
          }

        });

      } else {
        $("#user_email").addClass("red");
        $("#status").html('<font color="#cc0000">Enter valid User Name</font>');
      }

      return false;
    });

  });
</script>

<script type="text/javascript" src="<?php echo SITEPATH; ?>syspanel/js/custom.js">
</script>

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

  // function getState(countryId) {
  //   var strURL = "<?php //echo SITEPATH; 
                      ?>/admin/user/findState.php?country=" + countryId;
  //   var req = getXMLHTTP();
  //   if (req) {

  //     req.onreadystatechange = function() {
  //       if (req.readyState == 4) {
  //         if (req.status == 200) {
  //           document.getElementById('statediv').innerHTML = req.responseText;
  //           document.getElementById('citydiv').innerHTML = '<select name="city"required class="form-control1">' +
  //             '<option>Select District</option>' +
  //             '</select>';
  //         } else {
  //           alert("Problem while using XMLHTTP:\n" + req.statusText);
  //         }
  //       }
  //     }
  //     req.open("GET", strURL, true);
  //     req.send(null);
  //   }
  // }
</script>


<!-- image validation  -->
<script>
  function validateFileInput(input) {
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    var files = input.files;

    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var fileName = file.name;

      if (!allowedExtensions.test(fileName)) {
        alert("Please select a valid file with extension .jpg, .jpeg, or .png.");
        input.value = ""; // Clear the selected file
        return false;
      }
    }

    return true;
  }
</script>

</head>

<body class="hold-transition skin-blue sidebar-mini fixed">

  <div class="wrapper">
    <?php include_once("../common/left_menu.php"); ?>
    <div class="content-wrapper">
      <!-- Content Header -->
      <section class="content-header">
        <h1>
          <?php if ($per['user']['add'] == 1) { ?>
            <?php echo $name; ?>
          <?php } else {
            echo "&nbsp;";
          } ?>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">
            <?php if ($per['user']['view'] == 1) { ?>
              <?php echo $name; ?>
            <?php } else {
              echo "&nbsp;";
            } ?>
          </li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="box box-info">
          <form id="form" name="form" action="<?php echo SITEPATH; ?>admin/action/user.php?action=save" method="post" enctype="multipart/form-data">
            <input id="data_id" name="data_id" type="hidden" value="<?php echo $id ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Login Detail</h4>
                </div>
              </div>

              <div class="clearfix"></div>
              <?php if ($r['user_type'] == "1") { ?>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" id="user_email" name="user_email" placeholder="" value="<?php echo $res['user_email']; ?>" type="text">
                  </div>
                </div>
              <?php } else {
              ?>
                <div class="col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label><?php echo $res['user_email']; ?></label>
                  </div>
                </div>
              <?php } ?>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                  <label> <span id="status"></span></label>
                </div>
              </div>
              <h2 id='result'></h2>
              <div class="clearfix"></div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Password</label>
                  <input class="form-control" name="password" id="password" placeholder="" minlength=6 value="<?php if (!$res['user_pass'] == "") {
                                                                                                                echo decryptIt($res['user_pass']);
                                                                                                              } ?>" type="password">
                </div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input class="form-control" name="confirm_password" id="confirm_password" minlength=6 placeholder="" value="<?php if (!$res['user_pass'] == "") {
                                                                                                                                echo decryptIt($res['user_pass']);
                                                                                                                              } ?>" type="password">
                </div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                  <label> <span id='message'></span></label>
                </div>
              </div>
              <div style=" <?php if ($per['user']['add'] == 1) { ?> display:block;<?php } else { ?> display:none;<?php } ?>">
                <div class="col-sm-12 col-md-12 col-lg-12"> </div>
              </div>
              <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Profile Detail</h4>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Name</label>
                  <input class="form-control" required name="first_name" placeholder="" type="text" value="<?php echo $res['first_name']; ?>">
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Mobile Number </label>
                  <input class="form-control" required name="user_phone" placeholder="" value="<?php echo $res['user_phone']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Address</h4>
              </div>

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

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>State Name</label>
                  <select id="user_state" name="user_state" onchange="getDistrict(this.value)" class="form-control">
                    <?php
                    $rows_list = getState_list(101);
                    foreach ($rows_list as $rows) { ?>
                      <option value="<?php echo $rows['id']; ?>" <?php if ($rows['id'] == $res['user_state'])  echo "selected"; ?>><?php echo $rows['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>District Name</label>
                  <select id="district_id" name="district_id" class="form-control" onchange="getTaluka(this.value)" required <?php echo empty($res['user_district']) ? 'disabled' : ''; ?>>
                    <option>Select a State first</option>
                    <?php
                    if (!empty($res['user_district'])) {
                      $rows_list = getdistrict_list();
                      foreach ($rows_list as $distDetails) { ?>
                        <option value="<?php echo $distDetails['district_id']; ?>" <?php if ($distDetails['district_id'] == $res['user_district'])  echo "selected"; ?>><?php echo $distDetails['district_name']; ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Taluka</label>
                  <select id="taluka_id" name="taluka_id" class="form-control" required>
                    <option>Select a District first</option>
                    <?php
                    if (!empty($res['taluka_id'])) {
                      $gettaluka_list = gettaluka_list();
                      foreach ($gettaluka_list as $talukaDetails) { ?>
                        <option value="<?php echo $talukaDetails['taluka_id']; ?>" <?php if ($talukaDetails['taluka_id'] == $res['taluka_id'])  echo "selected"; ?>><?php echo $talukaDetails['taluka_name']; ?></option>
                    <?php }
                    } ?>
                  </select>

                </div>
              </div>

              <div class="clearfix"></div>


              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Pincode</label>
                  <input class="form-control" name="user_tel" placeholder="" value="<?php echo $res['user_tel']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Full Address</label>
                  <input class="form-control" required name="user_address" placeholder="" value="<?php echo $res['user_address']; ?>" type="text">
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Salary</h4>
              </div>

              <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                  <label>Basic Salary</label>
                  <input class="form-control" name="basic_salary" min="0" placeholder="Basic Salary" value="<?php echo $res['basic_salary']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                  <label>Petrol</label>
                  <input class="form-control" name="petrol" min="0" placeholder="Petrol Expense" value="<?php echo $res['petrol']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                  <label>Mobile Recharge</label>
                  <input class="form-control" name="mobile_recharge" min="0" placeholder="Mobile Recharge Expense" value="<?php echo $res['mobile_recharge']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                  <label>Extra Allowance</label>
                  <input class="form-control" name="extra_allowance" min="0" placeholder="Extra Allowance" value="<?php echo $res['extra_allowance']; ?>" type="number">
                </div>
              </div>

              <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                  <label>Working Target(Point)</label>
                  <input class="form-control" name="working_target" min="0" placeholder="Working Target (Point)" value="<?php echo $res['working_target']; ?>" type="number">
                </div>
              </div>


              <div class="clearfix"></div>

              <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Other Information</h4>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-4" style=" <?php if ($per['user']['add'] == 1) { ?> display:block;<?php } else { ?> display:none;<?php } ?>">
                <div class="form-group">
                  <label>Status</label>
                  <select id="user_status" name="user_status" class="form-control">
                    <?php foreach ($config['display_status'] as $key => $value) {
                      $selected = ($key == $res['user_status']) ? ' selected="selected"' : '';
                      echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>User Role</label>
                  <select id="user_type" name="user_type" class="form-control">
                    <?php foreach ($config['user_type'] as $key => $value) {
                      $selected = ($key == $res['user_type']) ? ' selected="selected"' : '';
                      echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Profile</label>
                  <input type="file" name="user_logo" accept=".jpg, .jpeg, .png" onchange="validateFileInput(this);" id="user_logo" class="form-control">
                </div>
              </div>

              <div class="clearfix"></div>
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label>Description</label>
                  <input class="form-control" maxlength="500" required name="user_desc" placeholder="" value="<?php echo $res['user_desc']; ?>" type="text">
                </div>
              </div>

              <?php if ($id == 1) { ?>

                <div class="clearfix"></div>

                <div class="col-sm-12 col-md-12 col-lg-12">
                  <h4 class="divd">Settings</h4>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12">

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>Food License</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="food_license_point" placeholder="Point" value="<?= isset($res['food_license_point']) ? $res['food_license_point'] : '' ?>">
                  </div>

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>Shop Act License</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="shop_act_license_point" placeholder="Point" value="<?= isset($res['shop_act_license_point']) ? $res['shop_act_license_point'] : '' ?>">
                  </div>

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>Bank Account</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="bank_acc_point" placeholder="Point" value="<?= isset($res['bank_acc_point']) ? $res['bank_acc_point'] : '' ?>">
                  </div>

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>Demat Account</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="demat_acc_point" placeholder="Point" value="<?= isset($res['demat_acc_point']) ? $res['demat_acc_point'] : '' ?>">
                  </div>

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>ITR Management</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="itr_management_point" placeholder="Point" value="<?= isset($res['itr_management_point']) ? $res['itr_management_point'] : '' ?>">
                  </div>

                  <div class="col-sm-2 col-md-2 col-lg-2">
                    <label>BS</label>
                    <input type="number" step="any" oninput="validateNonNegativeNumber(this)" required name="bs_point" placeholder="Point" value="<?= isset($res['bs_point']) ? $res['bs_point'] : '' ?>">
                  </div>

                  <div class="clearfix"></div>

                <?php }  ?>
                <div class="btn-submit-active">
                  <input type="submit" id="validate" value="Submit" onClick="ValidateEmail(document.form.user_email)" />
                  <span></span>
                </div>
                <a href="<?php echo SITEPATH; ?>admin/user" class="btn btn-cancel">Cancel</a>
                </div>
            </div>
          </form>
          <div class="box-footer clearfix"> </div>
      </section>
    </div>
  </div>

  <script>
    function validateNonNegativeNumber(input) {
      let value = input.value.replace(/[^0-9.]/g, '');
      if (value !== '' && parseFloat(value) < 0) {
        input.value = '';
      } else {
        input.value = value;
      }
    }
  </script>

  <!--close page contets , start footer-->
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
    if ($r['user_type'] == "1") {
    ?>

      function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }
    <?php } ?>

    function validate() {
      var email = $("#user_email").val();

      if (validateEmail(email)) {
        return true;
      } else {
        alert(email + " is not valid");
        return false;
      }

    }

    $("#validate").on("click", validate);
  </script>

  <script type="text/javascript">
    function changetextbox() {
      var id = document.getElementById("user_type").value;
      if (id == "0") {
        document.getElementById('salesman').style.display = 'none';
        document.getElementById('supplier').style.display = 'none';
        document.getElementById('salesman').style.display = 'none';
        document.getElementById('customer').style.display = 'none';
      }
      if (id == "1") {
        document.getElementById('supplier').style.display = 'none';
        document.getElementById('salesman').style.display = 'none';
        document.getElementById('customer').style.display = 'none';
      }
      if (id == "2") {
        document.getElementById('supplier').style.display = 'block';
        document.getElementById('salesman').style.display = 'none';
        document.getElementById('customer').style.display = 'none';
      }

      if (id == "3") {
        document.getElementById('salesman').style.display = 'block';
        document.getElementById('supplier').style.display = 'none';
        document.getElementById('customer').style.display = 'none';
      }

      if (id == "4") {
        document.getElementById('customer').style.display = 'block';
        document.getElementById('supplier').style.display = 'none';
        document.getElementById('salesman').style.display = 'none';
      }

    }
  </script>

  <footer class="main-footer">
    <?php include_once("../common/copyright.php"); ?>
  </footer>

  </div>
  <?php include_once("../common/footer.php"); ?>
</body>

</html>