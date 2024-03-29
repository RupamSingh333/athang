<?php
include("../../system_config.php");
include_once("../common/head.php");
// Usage
$allReportData = getAllDataReport();

// pr($allReportData);exit;
?>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("../common/left_menu.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Report Management</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">View All Report</li>
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
                                <td><strong>Name</strong></td>
                                <td><strong>Mobile</strong></td>
                                <td><strong>Service</strong></td>
                                <td><strong>Amount Pay</strong></td>
                                <td><strong>Method</strong></td>
                                <td><strong>Taluka Name</strong></td>
                                <td><strong>District Name</strong></td>
                                <td><strong>State Name</strong></td>
                                <td><strong>Status</strong></td>
                                <td><strong>Created</strong></td>
                                <!-- <td><strong>Action</strong></td> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($allReportData as $rows) {
                                // pr($rows);
                                $customerDetails = getCustomerDetails($rows['customer_id']);
                                // pr($customerDetails);exit;

                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $customerDetails[0]['cust_first_name']; ?></td>
                                    <td><?php echo $customerDetails[0]['cust_phone']; ?></td>
                                    <td><?php echo $rows['service']; ?></td>
                                    <td><?php echo $rows['pay_amount']; ?></td>
                                    <td><?php echo $rows['payment_method']; ?></td>
                                    <td><?php echo $customerDetails[0]['taluka_name']; ?></td>
                                    <td><?php echo $customerDetails[0]['district_name']; ?></td>
                                    <td><?php echo $customerDetails[0]['statename']; ?></td>

                                    <td>

                                        <?php if ($rows['status'] >= 0) { ?>
                                            <a href="javascript:void(0)" onclick="uploadFiles(<?= $rows['food_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>')" onMouseOver="showbox('Upload<?= $i; ?>')" onMouseOut="hidebox('Upload<?= $i; ?>')"> <i class="fa fa-upload"></i> </a>
                                            <div id="Upload<?= $i; ?>" class="hide1">
                                                <p>Upload File</p>
                                            </div>

                                        <?php } if ($rows['status'] >= 1) { ?>
                                            <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['food_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','vendor')" onMouseOver="showbox('IsPrint<?= $i; ?>')" onMouseOut="hidebox('IsPrint<?= $i; ?>')">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            <div id="IsPrint<?= $i; ?>" class="hide1">
                                                <p>Is Print</p>
                                            </div>

                                        <?php } if ($rows['status'] >= 2) { ?>
                                            <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['food_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','head_office')" onMouseOver="showbox('HeadOffice<?= $i; ?>')" onMouseOut="hidebox('HeadOffice<?= $i; ?>')">
                                                <i class="fa fa-building" style="color: purple;"></i>
                                            </a>
                                            <div id="HeadOffice<?= $i; ?>" class="hide1">
                                                <p>Head Office</p>
                                            </div>

                                        <?php } if ($rows['status'] >= 3) { ?>
                                            <a href="javascript:void(0)" onclick="showUploadDialog(<?= $rows['food_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','dist_head')" onMouseOver="showbox('DistHead<?= $i; ?>')" onMouseOut="hidebox('DistHead<?= $i; ?>')">
                                                <i class="fa fa-building" style="color: orange;"></i>
                                            </a>
                                            <div id="DistHead<?= $i; ?>" class="hide1">
                                                <p>District Head</p>
                                            </div>

                                        <?php } if ($rows['status'] >= 4) { ?>
                                            <a href="javascript:void(0)" onclick="readyToCustomer(<?= $rows['food_licence_id'] ?>, '<?= $getCustomerDetails[0]['cust_first_name']; ?>','ready_to_customer')" onMouseOver="showbox('ready_to_customer<?= $i; ?>')" onMouseOut="hidebox('ready_to_customer<?= $i; ?>')">
                                                <i class="fa fa-truck" style="color: orange;"></i>
                                            </a>
                                            <div id="ready_to_customer<?= $i; ?>" class="hide1">
                                                <p>Ready to Customer</p>
                                            </div>
                                        <?php } ?>

                                    </td>
                                    <td><?php echo date('d-m-Y h:i:s A', strtotime($rows['created_at'])); ?></td>


                                    <!-- <td id="font12" width="15%">
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
                                    </td> -->

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