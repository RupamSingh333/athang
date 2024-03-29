<?php
include("../../system_config.php");
include_once("../common/head.php");

if ($per['attendance_management']['view'] == 0) { ?>
    <script>
        window.location.href = "../dashboard.php";
    </script>
<?php } ?>
<?php
$getuser_byList = getuser_byList();

?>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("../common/left_menu.php"); ?>
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <ol class="breadcrumb">
                    <li><a href="<?php echo SITEPATH; ?>admin/dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
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
                text: '" . $message . "',
                timer: 3000, // Display for 3 seconds
                showConfirmButton: false
                });
                </script>";
            }
            ?>

            <style>
                td,
                tr,
                th {
                    border: 1px solid #000;
                    text-align: center;
                }


                .absent {
                    background-color: #dd4b39;
                    color: #FFFFFF;
                }

                .halfday {
                    background-color: orange;
                    color: #FFFFFF;
                }

                .present {
                    background-color: greenyellow;
                }

                .sunday {
                    background-color: #dd4b39;
                    color: #FFFFFF;
                }

                .weekday {
                    background-color: #ffffff;
                }

                td a {
                    color: black;
                }
            </style>

            <!-- <script>
                function printAttendance() {
                    var printContents = document.getElementById('attendanceTable').outerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                }
            </script> -->



            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $currentMonth = date('m');
                        $currentYear = date('Y');
                        $totalDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                        $monthName = date('F', strtotime($currentYear . '-' . $currentMonth . '-01'));
                        ?>
                        <h2>Month: <?php echo $monthName; ?> | Year: <?php echo $currentYear; ?> | Total Days: <?php echo $totalDays; ?></h2>

                        <!-- Print Button -->
                        <div class="text-right">
                            <button class="btn btn-primary" onclick="window.print();">Print Attendance</button>
                        </div>

                        <table class="table table-hover table-dark" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <?php for ($day = 1; $day <= $totalDays; $day++) : ?>
                                        <th <?php echo (date('w', strtotime("$currentYear-$currentMonth-$day")) == 0) ? ' class="sunday"' : ' class=""'; ?>>
                                            <?= (date('w', strtotime("$currentYear-$currentMonth-$day")) == 0) ? 'S' : $day; ?>
                                        </th>
                                    <?php endfor; ?>
                                    <th>Total Leaves</th>
                                    <th>Total Days</th>
                                    <th>Total Working</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                function getStatusClass($status)
                                {
                                    switch ($status) {
                                        case 'A':
                                            return 'absent';
                                        case 'P':
                                            return 'present';
                                        case 'HF':
                                            return 'halfday';
                                        default:
                                            return '';
                                    }
                                }

                                foreach ($getuser_byList as $key => $employee) : ?>

                                    <tr>
                                        <td><?= ++$key; ?></td>
                                        <td><?= $employee['first_name']; ?></td>

                                        <?php
                                        $totalLeaves = 0;
                                        $attendanceData = getAllAttendanceData($employee['user_id'], $currentYear, $currentMonth);
                                        for ($day = 1; $day <= $totalDays; $day++) {
                                            // $attendanceDate = $currentYear . '-' . $currentMonth . '-' . $day;
                                            $attendanceDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                                            // pr($attendanceDate);exit;

                                            $getStatus = $attendanceData[$attendanceDate] ?? null;
                                            $getReason = $attendanceData[$attendanceDate]['reason'] ?? null;
                                            $status = ($getStatus) ? $getStatus['status'] : 'A';
                                            $statusClass = getStatusClass($status);

                                            if ($status === 'A') {
                                                $totalLeaves++;
                                            } elseif ($status === 'HF') {
                                                $totalLeaves += 0.5;
                                            }

                                            $class = (date('w', strtotime($attendanceDate)) == 0) ? 'sunday ' . $statusClass : $statusClass;
                                        ?>

                                            <td class="<?= $class; ?>">
                                                <?php if (!empty($getReason)) : ?>
                                                    <a href="javascript:void(0);" class='reason-tooltip' title='<?= $getReason ?>' onclick="takeAttendance('<?= $employee['user_id'] ?>', '<?= $employee['first_name'] ?>', '<?= $attendanceDate ?>', '<?= $status ?>')">
                                                        <?= $status ?> *
                                                    </a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" onclick="takeAttendance('<?= $employee['user_id'] ?>', '<?= $employee['first_name'] ?>', '<?= $attendanceDate ?>', '<?= $status ?>')">
                                                        <?= $status ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        <?php } ?>

                                        <td><?= $totalLeaves ?></td>
                                        <td><?= $totalDays ?></td>
                                        <td><?= $totalDays - $totalLeaves ?></td>
                                    </tr>
                                <?php endforeach; ?>


                            </tbody>
                        </table>

                    </div>
                </div>
            </section>

            <script>
                function takeAttendance(employeeId, employeeName, attendanceDate) {
                    Swal.fire({
                        title: "Take Attendance",
                        html: `
                            <div>
                                <p>Employee Name: ${employeeName}</p>
                                <p>Date: ${attendanceDate}</p>
                            </div>
                            <label><input type="radio" name="attendanceStatus" value="P" required> Present</label>
                            <label><input type="radio" name="attendanceStatus" value="A"> Absent</label>
                            <label><input type="radio" name="attendanceStatus" value="HF"> Half Day</label>
                            <input type="text" id="reasonInput" placeholder="Reason (optional)">
                        `,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Submit",
                        cancelButtonText: "Cancel",
                        preConfirm: () => {
                            const reasonInput = document.getElementById('reasonInput').value;
                            const attendanceStatus = document.querySelector('input[name="attendanceStatus"]:checked');

                            if (!attendanceStatus) {
                                Swal.showValidationMessage('Please select an attendance status.');
                                return false;
                            }
                            // else {
                            //     return {
                            //         statusText: statusText,
                            //     };
                            // }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const attendanceStatus = $("input[name='attendanceStatus']:checked").val();
                            const reason = $("#reasonInput").val();
                            if (!attendanceStatus) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Please select an option before submitting.',
                                });
                            } else {
                                $.ajax({
                                    url: 'process_attendance.php',
                                    type: 'POST',
                                    data: {
                                        employeeId: employeeId,
                                        attendanceDate: attendanceDate,
                                        attendanceStatus: attendanceStatus,
                                        reason: reason
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        Swal.fire({
                                            position: "top-bottom",
                                            icon: "success",
                                            title: 'Attendance has been update successfully',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1000);
                                        // return response;
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });

                            }
                        }
                    });
                }
            </script>



        </div>
        <footer class="main-footer">
            <?php include_once("../common/copyright.php"); ?>
        </footer>
    </div>
    <?php include_once("../common/footer.php"); ?>
</body>

</html>