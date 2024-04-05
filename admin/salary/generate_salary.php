<?php
include("../../system_config.php");
include_once("../common/head.php");
$rows_list = getuser_byList();
if ($per['salary_management']['view'] == 0) { ?>
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
                <h3>
                    Generate Salary
                </h3>
                <ol class="breadcrumb">
                    <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">
                        <?php if ($per['salary_management']['view'] == 1) { ?>
                            Generate Salary
                        <?php } ?>
                    </li>
                </ol>
            </section>
            <!-- Main content -->

            <?php
            if (isset($_SESSION['msg'])) {
                $message = $_SESSION['msg'];
                $errorType = $_SESSION['errorType'];
                unset($_SESSION['msg']);

                echo "<script>
                Swal.fire({
                icon: '" . $errorType . "',
                title: '" . ucfirst($errorType) . "',
                text: '" . $message . "',
                // timer: 3000, // Display for 3 seconds
                showConfirmButton: true
                });
                </script>";
            }
            ?>


            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Search Employee</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->

                            <?php
                            $currentMonth = isset($_GET['month-year']) ? date('m', strtotime($_GET['month-year'])) : date('m');
                            $currentYear = isset($_GET['month-year']) ? date('Y', strtotime($_GET['month-year'])) : date('Y');
                            ?>

                            <form role="form" id="salaryForm">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="employee">Select Employee:</label>
                                                <select class="form-control" name="employee" required id="employee">
                                                    <option value="">Select Employee</option>
                                                    <?php
                                                    foreach ($rows_list as $row) {
                                                        if ($row['user_id'] == 1) {
                                                            continue;
                                                        }
                                                        echo '<option value="' . $row['user_id'] . '">' . $row['first_name'] . '-(' . $config['user_type'][$row['user_type']] . ')</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="month">Select Month:</label>
                                                <input type="month" id="month" value="<?= date('Y-m'); ?>" max="<?= date('Y-m'); ?>" name="month" maximum required>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>

            <div id="employeeDetails"></div>

            <?php
            $getSalaryData = getSalaryData();
            ?>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Salary Data</h3>
                            </div>
                            <div class="box-body">
                                <?php if (!empty($getSalaryData)) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Employee Name</th>
                                                    <th>Selected Month</th>
                                                    <th>Working Target(Point)</th>
                                                    <th>Achieved Total Point</th>
                                                    <th>Total Working Days</th>
                                                    <th>Total Salary</th>
                                                    <th>Calculated Salary</th>
                                                    <th>Other Pay Amount</th>
                                                    <th>Action</th>
                                                    <!-- Add more table headers for other columns as needed -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($getSalaryData as $data) :
                                                    $empData = getuser_byID($data['employee_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo $empData['first_name']; ?></td>
                                                        <td><?php echo date('m-Y', strtotime($data['selected_month'])); ?></td>
                                                        <td><?php echo $data['working_target']; ?></td>
                                                        <td><?php echo $data['total_point']; ?></td>
                                                        <td><?php echo $data['total_working_days']; ?></td>
                                                        <td><?php echo $data['total_salary']; ?></td>
                                                        <td><?php echo $data['total_calculated_salary']; ?></td>
                                                        <td><?php echo $data['other_pay_amount']; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($per['salary_management']['del'] == 1) { ?>
                                                                <a href="javascript:void(0);" onclick="return confirmDelete('<?php echo urlencode($data['id']); ?>');" onMouseOver="showbox('Delete<?php echo $i; ?>')" onMouseOut="hidebox('Delete<?php echo $i; ?>')">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                                <div id="Delete<?php echo $i; ?>" class="hide1">
                                                                    <p>Delete</p>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-info">No salary data available.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script>
                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Are you sure you want to delete this salary?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: 'calculate_salary.php',
                                data: {
                                    id: id,
                                    action: "delete"
                                },
                                success: function(response) {
                                    if (response.status) {
                                        Swal.fire({
                                            title: "Success",
                                            text: response.msg,
                                            icon: "success",
                                            showCancelButton: false,
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "OK",
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload(); // Reload the page
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: "Failed to delete data",
                                            icon: "error",
                                            confirmButtonColor: "#3085d6",
                                            confirmButtonText: "OK",
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: "Error",
                                        text: "Failed to delete data",
                                        icon: "error",
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "OK",
                                    });
                                }

                            });

                        }
                    });

                    return false;
                }
            </script>


            <script>
                function calculateTotalPoint() {
                    let Food_License = parseFloat($('input[name="Food_License"]').val()) || 0;
                    let Shop_Act = parseFloat($('input[name="Shop_Act"]').val()) || 0;
                    let Bank_Account = parseFloat($('input[name="Bank_Account"]').val()) || 0;
                    let Demat_Account = parseFloat($('input[name="Demat_Account"]').val()) || 0;
                    let ITR = parseFloat($('input[name="ITR"]').val()) || 0;
                    let B_S = parseFloat($('input[name="BS"]').val()) || 0;
                    let totalPoint = Food_License + Shop_Act + Bank_Account + Demat_Account + ITR + B_S;
                    $('input[name="total_point"]').val(totalPoint);
                    calculateSalary();
                }

                function sumOfTotalSalary() {
                    let basic_salary = parseFloat($('input[name="basic_salary"]').val()) || 0;
                    let petrol = parseFloat($('input[name="petrol"]').val()) || 0;
                    let mobile_recharge = parseFloat($('input[name="mobile_recharge"]').val()) || 0;
                    let extra_allowance = parseFloat($('input[name="extra_allowance"]').val()) || 0;
                    let totalSalary = basic_salary + petrol + mobile_recharge + extra_allowance;
                    $('input[name="total_salary"]').val(totalSalary);
                    calculateSalary();
                }


                // function calculateSalary() {
                //     let totalPoint = parseFloat($('input[name="total_point"]').val()) || 0;
                //     let salary = parseFloat($('input[name="total_salary"]').val()) || 0;
                //     // Calculate percentage achieved
                //     let workingTarget = parseFloat($('input[name="working_target"]').val()) || 0;
                //     let percentageAchieved = (totalPoint / workingTarget) * 100;
                //     percentageAchieved = Math.min(percentageAchieved, 100); // Ensure it doesn't exceed 100%
                //     let totalCalculateSalary = salary * (percentageAchieved / 100);
                //     $('input[name="total_calculated_salary"]').val(totalCalculateSalary.toFixed(2));
                // }

                function calculateSalary() {
                    let totalPoint = parseFloat($('input[name="total_point"]').val()) || 0;
                    let salary = parseFloat($('input[name="total_salary"]').val()) || 0;
                    let workingTarget = parseFloat($('input[name="working_target"]').val()) || 0;
                    let percentageAchieved = (totalPoint / workingTarget) * 100;
                    percentageAchieved = Math.min(percentageAchieved, 100);
                    let totalCalculateSalary = 0;
                    if (totalPoint > workingTarget) {
                        let excessPoints = totalPoint - workingTarget;
                        let excessSalary = excessPoints * (salary / workingTarget);
                        totalCalculateSalary = salary + excessSalary;
                    } else {
                        totalCalculateSalary = salary * (percentageAchieved / 100);
                    }

                    $('input[name="total_calculated_salary"]').val(totalCalculateSalary.toFixed(2));
                }
            </script>

            <script>
                $(document).ready(function() {
                    $('#salaryForm').submit(function(event) {
                        event.preventDefault();
                        $.ajax({
                            type: 'POST',
                            url: 'process_salary.php', // URL to your backend script
                            data: $(this).serialize(), // Serialize form data
                            success: function(response) {
                                $('#employeeDetails').html(response); // Update the employee details div with response
                            }
                        });
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#salaryFormCalculate').submit(function(event) {
                        event.preventDefault();
                        $.ajax({
                            type: 'POST',
                            url: 'calculate_salary.php', // URL to your backend script
                            data: $(this).serialize(), // Serialize form data
                            success: function(response) {
                                $('#employeeDetails').html(response); // Update the employee details div with response
                            }
                        });
                    });
                });
            </script>

        </div>
        <footer class="main-footer">
            <?php include_once("../common/copyright.php"); ?>
        </footer>
    </div>
    <?php include_once("../common/footer.php"); ?>
</body>

</html>