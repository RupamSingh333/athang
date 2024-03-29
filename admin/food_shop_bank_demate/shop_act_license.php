<?php
include("../../system_config.php");
include_once("../common/head.php");
$empRole = $_SESSION['type'];
if ($empRole != Vendor) {
  $getAllShopAct = getAllShopAct();
} else {
  $getAllShopAct = getAllShopActById($_SESSION['AdminLogin']);
}


if ($per['shop_act_license']['view'] == 0) { ?>
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
        <h1>Shop Act License</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Shop Act License</li>
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
          position: 'top',
          text: '" . $message . "',
          timer: 3000, // Display for 3 seconds
          showConfirmButton: false
          });
          </script>";
      }
      ?>

      <section class="content">

        <div class="table-responsive" style="overflow-x: auto;">
          <table id="exportable" align="center" class="table table-bordered table-condensed table-hover">
            <thead>
              <tr>
                <td><strong>Sr.No</strong></td>
                <td><strong>Selfie</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>Email</strong></td>
                <td><strong>Organization</strong></td>
                <td><strong>Documents</strong></td>
                <td><strong>Approved By</strong></td>
                <td>Created</td>
                <td><strong>Status</strong></td>
                <td><strong>Action</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($getAllShopAct as $rows) {
                $getCustomerDetails = getCustomerDetails($rows['customer_id']);
                $userTakeThis = getuser_byID($rows['user_updated_by']);


              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td>
                    <a href="javascript:void(0)">
                      <img src="<?php echo SITEPATH; ?><?php echo ($getCustomerDetails[0]['cust_selfie']) ? 'upload/Images/' . $getCustomerDetails[0]['cust_selfie'] : NOIMAGE; ?>" style="width: 80px;height: 80px;border-radius: 20px;">
                    </a>
                  </td>
                  <td><b><?php echo $getCustomerDetails[0]['cust_first_name']; ?></b></td>
                  <td><?php echo $getCustomerDetails[0]['cust_email']; ?></td>
                  <td>
                    <strong>Name:</strong> <?php echo $rows['cust_org_name']; ?> <br>
                    <strong>Type:</strong> <?php echo $rows['cust_org_type']; ?>
                  </td>

                  <td>
                    <?php
                    if ($rows['cust_agreement_copy']) { ?>
                      <a href="<?php echo SITEPATH; ?><?php echo ($rows['cust_agreement_copy']) ? 'upload/Images/' . $rows['cust_agreement_copy'] : NOIMAGE; ?>" target="_blank">View Agreement Copy</a>
                    <?php } ?>
                    <br>
                    <?php if ($rows['cust_signature']) { ?>
                      <a href="<?php echo SITEPATH; ?><?php echo ($rows['cust_signature']) ? 'upload/Images/' . $rows['cust_signature'] : NOIMAGE; ?>" target="_blank">View Customer Signature</a>
                    <?php } ?>
                    <br>

                    <?php
                    if ($rows['form']) {
                      $previousFormImages = explode(',', $rows['form']);

                      foreach ($previousFormImages as $key => $previousImage) {
                        if (!empty($previousImage)) { ?>
                          <a href="<?php echo SITEPATH; ?><?php echo ($rows['form']) ? 'upload/Images/' . $previousImage : NOIMAGE; ?>" target="_blank">View Form - <?= $key + 1; ?></a>
                          <br>
                    <?php   }
                      }
                    } ?>

                    <?php
                    if ($rows['documents']) {
                      $previousDocumentImages = explode(',', $rows['documents']);

                      foreach ($previousDocumentImages as $key => $previousImage) {
                        if (!empty($previousImage)) { ?>
                          <a href="<?php echo SITEPATH; ?><?php echo ($rows['documents']) ? 'upload/Images/' . $previousImage : NOIMAGE; ?>" target="_blank">View Documents - <?= $key + 1; ?></a>
                          <br>
                    <?php   }
                      }
                    } ?>

                  </td>


                  <td><?php echo $userTakeThis['first_name']; ?></td>
                  <td><?php echo date('d-m-Y', strtotime($rows['created_at'])); ?></td>

                  <td>
                    <a href="javascript:void(0)" onclick="trackOrder(<?php echo $rows['status']; ?>,'<?= $getCustomerDetails[0]['cust_first_name']; ?>')">Track</a>

                  </td>

                  <td id="font12" style="width:15%">

                    <?php if ($per['shop_act_license']['edit'] == 1 && ($empRole == Admin || $empRole == Administrative)) : ?>
                      <?php if ($rows['status'] >= 0) : ?>
                        <a href="javascript:void(0)" onclick="uploadFiles(<?= $rows['shop_act_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>')" onMouseOver="showbox('Upload<?= $i; ?>')" onMouseOut="hidebox('Upload<?= $i; ?>')"> <i class="fa fa-upload"></i> </a>
                        <div id="Upload<?= $i; ?>" class="hide1">
                          <p>Upload File</p>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($per['shop_act_license']['edit'] == 1 && ($empRole == Admin || $empRole == Administrative || $empRole == Vendor)) : ?>
                      <?php if ($rows['status'] >= 1) : ?>
                        <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['shop_act_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','vendor')" onMouseOver="showbox('IsPrint<?= $i; ?>')" onMouseOut="hidebox('IsPrint<?= $i; ?>')">
                          <i class="fa fa-print"></i>
                        </a>
                        <div id="IsPrint<?= $i; ?>" class="hide1">
                          <p>Is Print</p>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($per['shop_act_license']['edit'] == 1 && ($empRole == Admin || $empRole == Administrative || $empRole == HeadOffice)) : ?>
                      <?php if ($rows['status'] >= 2) : ?>
                        <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['shop_act_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','head_office')" onMouseOver="showbox('HeadOffice<?= $i; ?>')" onMouseOut="hidebox('HeadOffice<?= $i; ?>')">
                          <i class="fa fa-building" style="color: purple;"></i>
                        </a>
                        <div id="HeadOffice<?= $i; ?>" class="hide1">
                          <p>Head Office</p>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>


                    <?php if ($per['shop_act_license']['edit'] == 1 && ($empRole == Admin || $empRole == Administrative || $empRole == DistricHeadOffice)) : ?>
                      <?php if ($rows['status'] >= 3) : ?>
                        <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['shop_act_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','dist_head')" onMouseOver="showbox('DistHead<?= $i; ?>')" onMouseOut="hidebox('DistHead<?= $i; ?>')">
                          <i class="fa fa-building" style="color: orange;"></i>
                        </a>
                        <div id="DistHead<?= $i; ?>" class="hide1">
                          <p>District Head</p>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($per['shop_act_license']['edit'] == 1 && ($empRole == Admin || $empRole == Administrative || $empRole == Employee)) : ?>
                      <?php if ($rows['status'] >= 4) : ?>
                        <a href="javascript:void(0)" onclick="readyToCustomer(<?= $rows['shop_act_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','ready_to_customer')" onMouseOver="showbox('ready_to_customer<?= $i; ?>')" onMouseOut="hidebox('ready_to_customer<?= $i; ?>')">
                          <i class="fa fa-truck" style="color: orange;"></i>
                        </a>
                        <div id="ready_to_customer<?= $i; ?>" class="hide1">
                          <p>Ready to Customer</p>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>

                  </td>

                </tr>

              <?php
                $i++;
              } ?>
            </tbody>
          </table>


          <!-- For vendor update -->
          <script>
            function showUploadDialog(dataId, customerName, userType) {

              Swal.fire({
                title: "Update Status",
                html: `
                                <div style="align-items: center;margin-bottom: 16px; margin-top: -24px;">
                                    <h3 id="customerName" style="font-weight: bold;">${customerName}</h3>
                                </div>
                                    <textarea rows="3" style="width: 361px" id="statusText" placeholder="Please enter something."></textarea>
                                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                preConfirm: () => {
                  const statusText = document.getElementById('statusText').value;
                  if (!statusText) {
                    Swal.showValidationMessage('Please enter something.');
                    return false;
                  } else {
                    return {
                      statusText: statusText,
                    };
                  }
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  const statusText = result.value.statusText;

                  $.ajax({
                    url: 'shopActLicenseAjex.php',
                    type: 'POST',
                    data: {
                      dataId: dataId,
                      statusText: statusText,
                      key: userType,
                      // module: 'shop_act_license'
                    },
                    success: function(response) {
                      var jsonResponse = JSON.parse(response);
                      Swal.fire({
                        position: "top-bottom",
                        icon: "success",
                        title: "Success!",
                        text: jsonResponse.message,
                        showConfirmButton: false,
                        timer: 2000
                      });
                      setTimeout(() => {
                        location.reload();
                      }, 2000);
                    },
                    error: function(error) {
                      const response = JSON.parse(error.responseText);
                      const errorMessage = response.message;
                      Swal.fire({
                        position: "top-bottom",
                        icon: "error",
                        title: "Error Occurred",
                        text: errorMessage,
                        showConfirmButton: false,
                        timer: 3000
                      });
                    }
                  });
                }
              });
            }
          </script>
          <!-- For vendor update -->

          <!-- For admin upload document and files start -->
          <style>
            .swal2-popup {
              width: 400px;
            }
          </style>

          <?php
          $vendorsList = getAllUsersByRole(4);
          ?>

          <script>
            function uploadFiles(dataId, customerName) {
              Swal.fire({
                title: "Upload Form And Documents",
                html: `
                                <div style="align-items: center;margin-bottom: 16px; margin-top: -24px;">
                                    <h3 id="customerName" style="font-weight: bold;">${customerName}</h3>
                                </div>
                        
                                <div style="display: flex; align-items: center;">
                                    <label for="vendor_id" style="margin-right: 10px; width: 120px; text-align: right;">Assigned To Vendor:</label>
                                    <select name="vendor" id="vendor_id">
                                        <option value="">Select Vendor</option>
                                        <?php foreach ($vendorsList as $vendor) : ?>
                                            <option value="<?php echo $vendor['user_id']; ?>"><?php echo $vendor['first_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        
                                <div style="display: flex; align-items: center;">
                                    <label for="formInput" style="margin-right: 10px; width: 120px; text-align: right;">Form:</label>
                                    <input type="file" id="formInput" name="form[]" required accept="image/*, application/pdf" multiple>
                                </div>
                        
                                <div style="display: flex; align-items: center;">
                                    <label for="documentsInput" style="margin-right: 10px; width: 120px; text-align: right;">Documents:</label>
                                    <input type="file" id="documentsInput" name="documents[]" required accept="image/*, application/pdf" multiple>
                                </div>`,
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                preConfirm: () => {
                  const formFile = document.getElementById('formInput').files;
                  const documentsFiles = document.getElementById('documentsInput').files;
                  const vendorId = document.getElementById('vendor_id').value;

                  if (!formFile || documentsFiles.length === 0 || !vendorId) {
                    Swal.showValidationMessage('Please select files for both Form and Documents and choose a vendor.');
                    return false;
                  } else {
                    return {
                      formFile: Array.from(formFile),
                      documentsFiles: Array.from(documentsFiles),
                      vendorId: vendorId
                    };
                  }
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  const formFile = result.value.formFile;
                  const documentsFiles = result.value.documentsFiles;
                  const vendorId = result.value.vendorId;
                  // Constructing form data
                  const formData = new FormData();
                  formFile.forEach((file, index) => {
                    formData.append(`formFiles[]`, file);
                  });
                  documentsFiles.forEach((file, index) => {
                    formData.append(`documentFiles[]`, file);
                  });
                  formData.append('dataId', dataId);
                  formData.append('vendorId', vendorId);
                  formData.append('key', 'admin');
                  // formData.append('module', 'shop_act_license');

                  $.ajax({
                    url: 'shopActLicenseAjex.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                      // return false;
                      var jsonResponse = JSON.parse(response);
                      Swal.fire({
                        position: "top-bottom",
                        icon: "success",
                        title: "Success!",
                        text: jsonResponse.message,
                        showConfirmButton: false,
                        timer: 2000
                      });
                      setTimeout(() => {
                        location.reload();
                      }, 2000);
                    },
                    error: function(error) {
                      const response = JSON.parse(error.responseText);
                      const errorMessage = response.message;
                      Swal.fire({
                        position: "top-bottom",
                        icon: "error",
                        title: "Error Occurred",
                        text: errorMessage,
                        showConfirmButton: false,
                        timer: 3000
                      });
                    }
                  });
                }

              });
            }
          </script>
          <!-- For admin upload document and files end -->

          <!-- Track Order -->
          <style>
            .stepper-wrapper {
              margin-top: auto;
              display: flex;
              justify-content: space-between;
              margin-bottom: 20px;
            }

            .stepper-item {
              position: relative;
              display: flex;
              flex-direction: column;
              align-items: center;
              flex: 1;

              @media (max-width: 768px) {
                font-size: 12px;
              }
            }

            .stepper-item::before {
              position: absolute;
              content: "";
              border-bottom: 2px solid #ccc;
              width: 100%;
              top: 20px;
              left: -50%;
              z-index: 2;
            }

            .stepper-item::after {
              position: absolute;
              content: "";
              border-bottom: 2px solid #ccc;
              width: 100%;
              top: 20px;
              left: 50%;
              z-index: 2;
            }

            .stepper-item .step-counter {
              position: relative;
              z-index: 5;
              display: flex;
              justify-content: center;
              align-items: center;
              width: 40px;
              height: 40px;
              border-radius: 50%;
              background: #ccc;
              margin-bottom: 6px;
            }

            .stepper-item.active {
              font-weight: bold;
            }

            .stepper-item.completed .step-counter {
              background-color: #4bb543;
            }

            .stepper-item.completed::after {
              position: absolute;
              content: "";
              border-bottom: 2px solid #4bb543;
              width: 100%;
              top: 20px;
              left: 50%;
              z-index: 3;
            }

            .stepper-item:first-child::before {
              content: none;
            }

            .stepper-item:last-child::after {
              content: none;
            }
          </style>

          <script>
            function trackOrder(status, customerName) {
              let stepsHTML = '';
              for (let i = 1; i <= 6; i++) {
                let stepClass = i <= status ? 'completed' : '';
                let activeClass = (status + 1 == i) ? 'active' : '';

                if (status == 5) {
                  stepClass = 'completed'
                  // activeClass = 'active'
                }

                stepsHTML += `
                                <div class="stepper-item ${stepClass} ${activeClass}">
                                    <div class="step-counter">${i}</div>
                                    <div class="step-name">${getStepName(i)}</div>
                                </div>`;
              }

              // Display the steps using SweetAlert
              Swal.fire({
                title: 'Order Tracking',
                html: `<div class="stepper-wrapper">${stepsHTML}</div>`,
                icon: 'info',
                confirmButtonText: 'OK',
              });
            }

            function getStepName(stepNumber) {
              switch (stepNumber) {
                case 1:
                  return 'Admin';
                case 2:
                  return 'Vendor';
                case 3:
                  return 'Head Office';
                case 4:
                  return 'District Head';
                case 5:
                  return 'Ready to Customer';
                case 6:
                  return 'Delivered';
                default:
                  return '';
              }
            }
          </script>
          <!-- Track Order -->

          <!-- readyToCustomer -->
          <script>
            function readyToCustomer(dataId, customerName, userType) {

              Swal.fire({
                title: "Delivered to Customer",
                html: `
                                    <div style="align-items: center;margin-bottom: 16px; margin-top: -24px;">
                                        <h3 id="customerName" style="font-weight: bold;">${customerName}</h3>
                                    </div>
                                    <div style="margin-bottom: 16px;">
                                        <input type="radio" id="cashPayment" name="paymentMethod" value="cash">
                                        <label for="cashPayment">Cash</label>
                                        <input type="radio" id="onlinePayment" name="paymentMethod" value="online">
                                        <label for="onlinePayment">Online</label>
                                    </div>

                                    <div style="margin-bottom: 5px;">
                                        <input type="number" id="payAmount" name="pay_amount" placeholder="Enter Amount">
                                    </div>

                                    <textarea rows="3" style="width: 361px" id="statusText" placeholder="Please enter something."></textarea>
                                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                preConfirm: () => {
                  const statusText = document.getElementById('statusText').value;
                  const payAmount = document.getElementById('payAmount').value;
                  const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
                  if (!statusText || !paymentMethod || !payAmount) {
                    Swal.showValidationMessage('Please enter something , select a payment method and amount.');
                    return false;
                  } else {
                    return {
                      statusText: statusText,
                      paymentMethod: paymentMethod,
                      payAmount: payAmount
                    };
                  }
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  const statusText = result.value.statusText;
                  const paymentMethod = result.value.paymentMethod;
                  const payAmount = result.value.payAmount;

                  $.ajax({
                    url: 'shopActLicenseAjex.php',
                    type: 'POST',
                    data: {
                      dataId: dataId,
                      statusText: statusText,
                      paymentMethod: paymentMethod,
                      payAmount: payAmount,
                      key: userType
                    },
                    success: function(response) {
                      var jsonResponse = JSON.parse(response);
                      Swal.fire({
                        position: "top-bottom",
                        icon: "success",
                        title: "Success!",
                        text: jsonResponse.message,
                        showConfirmButton: false,
                        timer: 2000
                      });
                      setTimeout(() => {
                        location.reload();
                      }, 2000);
                    },
                    error: function(error) {
                      const response = JSON.parse(error.responseText);
                      const errorMessage = response.message;
                      Swal.fire({
                        position: "top-bottom",
                        icon: "error",
                        title: "Error Occurred",
                        text: errorMessage,
                        showConfirmButton: false,
                        timer: 3000
                      });
                    }
                  });
                }
              });
            }
          </script>
          <!-- readyToCustomer -->

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