<?php
include("../../system_config.php");

if (!empty($_POST['employeeId']) && !empty($_POST['attendanceDate']) && !empty($_POST['attendanceStatus'])) {
    $employeeId = $_POST['employeeId'];
    $attendanceDate = date('Y-m-d', strtotime($_POST['attendanceDate']));
    $attendanceStatus = $_POST['attendanceStatus'];
    $reason = $_POST['reason'];
    $checkRecordQuery = "SELECT id FROM attendance WHERE emp_id = ? AND attendance_date = ?";
    // pr($checkRecordQuery);exit;
    $checkRecordStmt = mysqli_prepare($link, $checkRecordQuery);
    mysqli_stmt_bind_param($checkRecordStmt, "is", $employeeId, $attendanceDate);
    mysqli_stmt_execute($checkRecordStmt);
    mysqli_stmt_store_result($checkRecordStmt);

    if (mysqli_stmt_num_rows($checkRecordStmt) > 0) {
        if ($reason) {
            $updateQuery = "UPDATE attendance SET status = ?, reason = ? WHERE emp_id = ? AND attendance_date = ?";
            $updateStmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ssis", $attendanceStatus, $reason, $employeeId, $attendanceDate);
        } else {
            $updateQuery = "UPDATE attendance SET status = ? WHERE emp_id = ? AND attendance_date = ?";
            $updateStmt = mysqli_prepare($link, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "sis", $attendanceStatus, $employeeId, $attendanceDate);
        }

        mysqli_stmt_execute($updateStmt);
        $message = 'Attendance record updated successfully.';
    } else {
        $insertQuery = "INSERT INTO attendance (emp_id, attendance_date, status, reason) VALUES (?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($link, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "isss", $employeeId, $attendanceDate, $attendanceStatus, $reason);
        mysqli_stmt_execute($insertStmt);
        $message = 'New attendance record created successfully.';
    }


    $response = array(
        'message' => $message,
        'status' => true
    );

    echo json_encode($response);
} else {
    $response = array(
        'message' => 'Invalid input. Please provide all required parameters.',
        'status' => false
    );

    echo json_encode($response);
}
