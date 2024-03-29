<?php
include("../system_config.php");

if (!empty($_POST['employeeId'])) {
    $employeeId = $_POST['employeeId'];
    $attendanceDate = date('Y-m-d', strtotime($_POST['attendanceDate']));
    $attendanceStatus = $_POST['attendanceStatus'];
    $reason = $_POST['reason'];

    $requiredFields = [
        'employeeId' => $employeeId,
        'attendanceDate' => $attendanceDate,
        'attendanceStatus' => $attendanceStatus
    ];

    $emptyFields = [];
    foreach ($requiredFields as $fieldName => $fieldValue) {
        if (empty($fieldValue)) {
            $emptyFields[] = $fieldName;
        }
    }

    if (!empty($emptyFields)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['status' => false, 'error' => 'The following fields are required: ' . implode(', ', $emptyFields)]);
        exit;
    }

    if (date('Y', strtotime($_POST['attendanceDate'])) == '1970') {
        header('Content-Type: application/json');
        http_response_code(200);
        $response = array(
            'message' => 'Invalid Date Formate. Please provide validate date (dd-mm-YYYY).',
            'status' => false
        );

        echo json_encode($response);
        die;
    }

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

    header('Content-Type: application/json');
    http_response_code(200);
    $response = array(
        'message' => $message,
        'status' => true
    );
} else {
    header('Content-Type: application/json');
    http_response_code(400);
    $response = array(
        'message' => 'Invalid input. Please provide all required parameters.',
        'status' => false
    );
}
echo json_encode($response);
die;
