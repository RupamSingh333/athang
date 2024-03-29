<?php
include("../system_config.php");

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key']) && $_POST['key'] === 'qwertyupasdfghjklzxcvbnm') {
    $getEmployeeList = getuser_byList();
    $currentMonth = date('m');
    $currentYear = date('Y');
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    $monthName = date('F', strtotime($currentYear . '-' . $currentMonth . '-01'));

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

    $empData = array();
    $empDataTotalLeave = array();
    $data = array();
    $totalLeaveEachEmp = array();

    foreach ($getEmployeeList as $key => $employee) :
        // pr($employee);exit;

        $totalLeaves = 0;
        $attendanceData = getAllAttendanceData($employee['user_id'], $currentYear, $currentMonth);
        for ($day = 1; $day <= $totalDays; $day++) {
            $attendanceDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
            $getStatus = $attendanceData[$attendanceDate] ?? null;
            $getReason = $attendanceData[$attendanceDate]['reason'] ?? null;
            $status = ($getStatus) ? $getStatus['status'] : 'A';
            $statusClass = getStatusClass($status);
            $checkDay =  date('l', strtotime("$currentYear-$currentMonth-$day"));


            if ($status === 'A') {
                $totalLeaves++;
            } elseif ($status === 'HF') {
                $totalLeaves += 0.5;
            }

            $empData['employeeName'] = $employee['first_name'];
            $empData['employeeId'] = $employee['user_id'];
            $empData['status'] = $status;
            $empData['reason'] = $getReason;
            $empData['date'] = $attendanceDate;
            $empData['dayName'] = $checkDay;
            $data[] = $empData;
        }
        $empDataTotalLeave['employeeName'] = $employee['first_name'];
        $empDataTotalLeave['totalLeaves'] = $totalLeaves;
        $empDataTotalLeave['totalDays'] = $totalDays;
        $empDataTotalLeave['totalWorkingDays'] = $totalDays - $totalLeaves;
        $totalLeaveEachEmp[] = $empDataTotalLeave;

    endforeach;

    $response = array(
        'status' => true,
        'employeeAttendance' => $data,
        'working' => $totalLeaveEachEmp
    );

    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
    exit;
} else {
    // Invalid request method or key
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['status' => false, 'error' => 'Invalid request method or key']);
    exit;
}
