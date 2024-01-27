<?php
include("../../system_config.php");
include_once("../common/head.php");
$customer_list = getcustomer_byList();

if ($per['bs']['view'] == 0) { ?>
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
                <h1>B/S</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">B/S</li>
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
                                <td><strong>Aadhar Link Mobile</strong></td>
                                <td><strong>Documents</strong></td>
                                <td><strong>Approved By</strong></td>
                                <td><strong>Status</strong></td>
                                <td><strong>Action</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($customer_list as $rows) {
                                $custState = getState_byID($rows['cust_state']);
                                $cust_taluka = gettaluka_byID($rows['cust_taluka_id']);
                                $getdistrict_byID = getdistrict_byID($rows['cust_district_id']);
                                $bs_approvedby = getuser_byID($rows['bs_approvedby']);
                                // pr($bs_approvedby);exit;

                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                  <td><a href="javascript:void(0)">
                      <img src="<?php echo SITEPATH; ?><?php echo ($rows['cust_selfie']) ? 'upload/Images/' . $rows['cust_selfie'] : NOIMAGE; ?>" style="width: 80px;height: 80px;border-radius: 20px;">
                    </a>
                  </td>
                                    <td><b><?php echo $rows['cust_first_name']; ?></b></td>
                                    <td><?php echo $rows['cust_email']; ?></td>
                                    <td><?php echo $rows['aadhar_link_mobile']; ?></td>
                                    <td>
                                        <?php
                                        if ($rows['proof_of_buiseness']) { ?>
                                            <a href="<?php echo SITEPATH; ?><?php echo ($rows['proof_of_buiseness']) ? 'upload/Images/' . $rows['proof_of_buiseness'] : NOIMAGE; ?>" target="_blank">View Business Proof</a>
                                        <?php } ?>
                                        <br>
                                        <?php if ($rows['bs_bank_statemenet']) { ?>
                                            <a href="<?php echo SITEPATH; ?><?php echo ($rows['bs_bank_statemenet']) ? 'upload/Images/' . $rows['bs_bank_statemenet'] : NOIMAGE; ?>" target="_blank">View Bank Statement</a>
                                        <?php } ?>
                                    </td>


                                    <td><?php echo $bs_approvedby['first_name']; ?></td>

                                    <td>

                                        <?php if ($rows['bs'] == 'Y') { ?>
                                            <i class="fa fa-check-circle" title="Approved" style="color: green;"></i>
                                        <?php } else if ($rows['bs'] == 'N') { ?>
                                            <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-question-circle" title="Pending" style="color: orange;"></i>
                                        <?php } ?>


                                    <td id="font12" style="width:10%">

                                        <?php if ($per['customer']['edit'] == 1) { ?>

                                            <a href="<?php echo SITEPATH; ?>admin/customer/add-new-customer.php?id=<?php echo urlencode(encryptIt($rows['cust_id'])); ?>" onMouseOver="showbox('Edit<?php echo $i; ?>')" onMouseOut="hidebox('Edit<?php echo $i; ?>')"> <i class="fa fa-pencil"></i>
                                            </a>
                                            <div id="Edit<?php echo $i; ?>" class="hide1">
                                                <p>Edit</p>
                                            </div>

                                        <?php } ?>
                                    </td>
                                </tr>

                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>


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