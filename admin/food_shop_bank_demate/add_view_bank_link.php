<?php
include("../../system_config.php");
include_once("../common/head.php");
$getBankLink_list = getBankLink_list();

if ($per['bank_account']['add'] == 0) { ?>
    <script>
        window.location.href = "../dashboard.php";
    </script>
<?php } ?>

</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("../common/left_menu.php"); ?>
        <div class="content-wrapper">

            <?php
            // Display the flash message using SweetAlert
            if (isset($_SESSION['msg'])) {
                $message = $_SESSION['msg'];
                $status = ($_SESSION['status']) ? $_SESSION['status'] : 'success';
                unset($_SESSION['msg']);
                unset($_SESSION['status']);

                echo "<script>
                Swal.fire({
                icon: '" . $status . "',
                title: 'Success!',
                position: 'top',
                text: '" . $message . "',
                timer: 3000, // Display for 3 seconds
                showConfirmButton: false
                });
                </script>";
            }
            ?>

            <!-- Content Header -->
            <section class="content-header">
                <h1>View Bank Links</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">View Bank Links</li>
                </ol>

                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLinkModal">
                    Add New Bank Link
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="addLinkModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addLinkModalLabel">Add New Bank Link</h4>
                            </div>
                            <div class="modal-body">
                                <form id="addLinkForm" action="<?php echo SITEPATH; ?>admin/action/bank_link.php?action=save" method="post">
                                    <div class="form-group">
                                        <label for="newLink">Link:</label>
                                        <input type="url" class="form-control" id="newLink" name="newLink" required>
                                        <input class="form-control" maxlength="500" name="link_desc" placeholder="Write something here........"type="text">

                                        <input type="hidden" name="action" value="save">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" value="Submit" class="btn btn-primary">Add Link</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- Main content -->

            <section class="content">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table id="exportable" align="center" class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <td><strong>Sr.No</strong></td>
                                <td><strong>Link</strong></td>
                                <td><strong>Desc</strong></td>
                                <td><strong>Status</strong></td>
                                <!-- <td><strong>Action</strong></td> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($getBankLink_list as $rows) {

                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php echo ($rows['link']); ?>
                                    </td>
                                    <td><?=$rows['link_desc'];?></td>
                                    <td>

                                        <?php if ($rows['status'] == 'Y') { ?>
                                            <i class="fa fa-check-circle" title="Approved" style="color: green;"></i>
                                        <?php } else if ($rows['status'] == 'N') { ?>
                                            <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-question-circle" title="Pending" style="color: orange;"></i>
                                        <?php } ?>
                                    </td>

                                    <!-- <td id="font12" style="width:10%">

                                        <?php if ($per['bank_account']['del'] == 1) { ?>
                                            <a href="javascript:void(0)" onclick="return confirmDelete('<?php echo urlencode(encryptIt($rows['bank_link_id'])); ?>');" onMouseOver="showbox('Delete<?php echo $i; ?>')" onMouseOut="hidebox('Delete<?php echo $i; ?>')"><i class="fa fa-times"></i></a>
                                            <div id="Delete<?php echo $i; ?>" class="hide1">
                                                <p>Delete</p>
                                            </div>


                                        <?php } ?>
                                    </td> -->
                                </tr>

                            <?php
                                $i++;
                            } ?>
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
                                    var deleteUrl = "<?php echo SITEPATH; ?>admin/action/bank_link.php?action=del&id=" + id;
                                    window.location.href = deleteUrl;
                                }
                            });

                            return false;
                        }
                    </script>


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