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
                                                    <th>Total Working</th>
                                                    <th>Total Salary</th>
                                                    <th>Incentive</th>
                                                    <th>Other Deduction</th>
                                                    <th>Advance Pay</th>
                                                    <th>Leave Amount</th>
                                                    <th>Basic Salary(%)</th>
                                                    <th>Calculated Salary</th>
                                                    <th>Descriptions</th>
                                                    <th>Action</th>
                                                    <!-- Add more table headers for other columns as needed -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($getSalaryData as $data) :
                                                    $empData = getuser_byID($data['employee_id']);
                                                ?>
                                                    <tr>
                                                        <td><?= $data['id']; ?></td>
                                                        <td><?= $empData['first_name']; ?></td>
                                                        <td><?= date('m-Y', strtotime($data['selected_month'])); ?></td>
                                                        <td>
                                                            <span>Target(Point):</span> <?= $data['working_target']; ?><br>
                                                            <span>Achieved(Point):<?= $data['total_point']; ?></span><br>
                                                            <span>Working(Days):<?= $data['total_point']; ?></span>
                                                        </td>
                                                        <!-- <td><?= $data['total_point']; ?></td>
                                                        <td><?= $data['total_working_days']; ?></td> -->
                                                        <!-- <td><?= $data['gross_salary']; ?></td> -->
                                                        <td><?= number_format($data['total_salary']); ?></td>
                                                        <td><?= number_format($data['other_pay_amount']); ?></td>
                                                        <td><?= number_format($data['other_deduction']); ?></td>
                                                        <td><?= number_format($data['advance_pay']); ?></td>
                                                        <td><?= number_format($data['leave_amount']); ?></td>
                                                        <td><?= number_format($data['total_calculated_salary_percentage']); ?></td>
                                                        <td><?= number_format($data['total_calculated_salary']); ?></td>
                                                        <td><?= ($data['descriptions']); ?></td>
                                                        <td>
                                                            <a href="salary_slip.php?id=<?= urlencode(encryptIt($data['id'])); ?>" target="_blank" rel="noopener noreferrer">
                                                                <i class="fa fa-file"></i>
                                                            </a>
                                                            <?php
                                                            if ($per['salary_management']['del'] == 1) { ?>
                                                                <a href="javascript:void(0);" onclick="return confirmDelete('<?= urlencode($data['id']); ?>');" onMouseOver="showbox('Delete<?= $i; ?>')" onMouseOut="hidebox('Delete<?= $i; ?>')">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                                <div id="Delete<?= $i; ?>" class="hide1">
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
                $(document).ready(function() {
                    // Document is ready, now bind events and initialize functions
                    $('input[name="Food_License"]').on('input', calculateTotalPoint);
                    $('input[name="Shop_Act"]').on('input', calculateTotalPoint);
                    $('input[name="Bank_Account"]').on('input', calculateTotalPoint);
                    $('input[name="Demat_Account"]').on('input', calculateTotalPoint);
                    $('input[name="ITR"]').on('input', calculateTotalPoint);
                    $('input[name="BS"]').on('input', calculateTotalPoint);

                    $('input[name="basic_salary"]').on('input', sumOfTotalSalary);
                    $('input[name="petrol"]').on('input', sumOfTotalSalary);
                    $('input[name="mobile_recharge"]').on('input', sumOfTotalSalary);
                    $('input[name="extra_allowance"]').on('input', sumOfTotalSalary);

                    // Call calculateSalary initially after all bindings are set
                    calculateSalary();
                });

                function calculateTotalPoint() {
                    try {
                        let Food_License = parseFloat($('input[name="Food_License"]').val()) || 0;
                        let Shop_Act = parseFloat($('input[name="Shop_Act"]').val()) || 0;
                        let Bank_Account = parseFloat($('input[name="Bank_Account"]').val()) || 0;
                        let Demat_Account = parseFloat($('input[name="Demat_Account"]').val()) || 0;
                        let ITR = parseFloat($('input[name="ITR"]').val()) || 0;
                        let B_S = parseFloat($('input[name="BS"]').val()) || 0;
                        let totalPoint = Food_License + Shop_Act + Bank_Account + Demat_Account + ITR + B_S;
                        $('input[name="total_point"]').val(parseFloat(totalPoint));
                        calculateSalary();
                    } catch (error) {
                        console.error("An error occurred while calculating total points:", error);
                    }
                }

                function sumOfTotalSalary() {
                    try {
                        let basic_salary = parseFloat($('input[name="basic_salary"]').val()) || 0;
                        let petrol = parseFloat($('input[name="petrol"]').val()) || 0;
                        let mobile_recharge = parseFloat($('input[name="mobile_recharge"]').val()) || 0;
                        let extra_allowance = parseFloat($('input[name="extra_allowance"]').val()) || 0;
                        let totalSalary = basic_salary + petrol + mobile_recharge + extra_allowance;
                        $('input[name="total_salary"]').val(parseFloat(totalSalary));
                        calculateSalary();
                    } catch (error) {
                        console.error("An error occurred while calculating total salary:", error);
                    }
                }

                function calculateSalary() {
                    try {
                        let petrol = parseFloat($('input[name="petrol"]').val()) || 0;
                        let mobile_recharge = parseFloat($('input[name="mobile_recharge"]').val()) || 0;
                        let extra_allowance = parseFloat($('input[name="extra_allowance"]').val()) || 0;
                        let basic_salary = parseFloat($('input[name="basic_salary"]').val()) || 0;

                        let other_pay_amount = parseFloat($('input[name="other_pay_amount"]').val()) || 0;

                        let advance_pay = parseFloat($('input[name="advance_pay"]').val()) || 0;
                        let leave_amount = parseFloat($('input[name="leave_amount"]').val()) || 0;
                        let other_deduction = parseFloat($('input[name="other_deduction"]').val()) || 0;

                        let salary = (petrol + mobile_recharge + extra_allowance + other_pay_amount) - (other_deduction + advance_pay + leave_amount);

                        let totalPoint = parseFloat($('input[name="total_point"]').val()) || 0;
                        let workingTarget = parseFloat($('input[name="working_target"]').val()) || 0;
                        let percentageAchieved = (totalPoint / workingTarget) * 100;
                        percentageAchieved = Math.min(percentageAchieved, 100);

                        let totalCalculateSalary = 0;
                        if (percentageAchieved < 30) {
                            totalCalculateSalary = salary;
                            totalPercentageOfTheSalary = 0;
                        } else if (totalPoint > workingTarget) {
                            let excessPoints = totalPoint - workingTarget;
                            let excessSalary = excessPoints * (basic_salary / workingTarget);
                            totalCalculateSalary = salary + Math.round(basic_salary + excessSalary);
                            totalPercentageOfTheSalary = Math.round(basic_salary + excessSalary);

                        } else {
                            totalCalculateSalary = salary + Math.round(basic_salary * (percentageAchieved / 100));
                            totalPercentageOfTheSalary = Math.round(basic_salary * (percentageAchieved / 100));
                        }

                        $('input[name="total_calculated_salary"]').val(parseFloat(totalCalculateSalary.toFixed(2)));
                        $('input[name="total_calculated_salary_percentage"]').val(parseFloat(totalPercentageOfTheSalary.toFixed(2)));
                    } catch (error) {
                        console.error("An error occurred while calculating salary:", error);
                    }
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