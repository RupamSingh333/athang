<?php
include("../../system_config.php");

if ($_POST['action'] == 'delete') {
    $sql = "DELETE FROM employee_salary_data WHERE `employee_salary_data`.`id` = " . $_POST['id'];
    $result = FetchRow($sql);

    $response = array(
        'status' => true,
        'msg' => 'Data has been delete successfully'
    );

    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Extract data from POST request
    $employee_id = $_POST['data_id'];
    $selected_month = $_POST['selected_month'];
    $selected_month = $selected_month . '-01';
    $first_name = $_POST['first_name'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $basic_salary = $_POST['basic_salary'];
    $petrol = $_POST['petrol'];
    $mobile_recharge = $_POST['mobile_recharge'];
    $extra_allowance = $_POST['extra_allowance'];
    $working_target = $_POST['working_target'];
    $total_working_days = $_POST['total_working_days'];
    $Food_License = $_POST['Food_License'];
    $Shop_Act = $_POST['Shop_Act'];
    $Bank_Account = $_POST['Bank_Account'];
    $Demat_Account = $_POST['Demat_Account'];
    $ITR = $_POST['ITR'];
    $BS = $_POST['BS'];
    $total_point = $_POST['total_point'];
    $total_salary = $_POST['total_salary'];
    $total_calculated_salary = $_POST['total_calculated_salary'];
    $other_pay_amount = $_POST['other_pay_amount'];


    $selected_month_year = date('Y-m-d', strtotime($selected_month));
    $lastDayOfMonth = date("Y-m-t", strtotime($selected_month_year));
    $sql = "SELECT COUNT(*) AS count 
            FROM employee_salary_data 
            WHERE employee_id = $employee_id 
            AND selected_month >= STR_TO_DATE('$selected_month_year', '%Y-%m-%d') 
            AND selected_month < STR_TO_DATE('$lastDayOfMonth', '%Y-%m-%d')";

    $result = FetchRow($sql);

    // pr($result);exit;

    if ($result['count'] > 0) {
        $_SESSION['msg'] = "Data already exists for this employee and month";
        $_SESSION['errorType'] = "error";
    } else {

        // Prepare the SQL query
        $sql = "INSERT INTO employee_salary_data (employee_id, selected_month, first_name, user_email, user_phone, basic_salary, petrol, mobile_recharge, extra_allowance, working_target, total_working_days, Food_License, Shop_Act, Bank_Account, Demat_Account, ITR, BS, total_point, total_salary, total_calculated_salary, other_pay_amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($link, $sql);

        // Bind parameters with the statement
        mysqli_stmt_bind_param(
            $stmt,
            'isssssssssiiiiiiiiiid',
            $employee_id,
            $selected_month,
            $first_name,
            $user_email,
            $user_phone,
            $basic_salary,
            $petrol,
            $mobile_recharge,
            $extra_allowance,
            $working_target,
            $total_working_days,
            $Food_License,
            $Shop_Act,
            $Bank_Account,
            $Demat_Account,
            $ITR,
            $BS,
            $total_point,
            $total_salary,
            $total_calculated_salary,
            $other_pay_amount
        );

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msg'] = "Data inserted successfully";
            $_SESSION['errorType'] = "success";
            // echo "Data inserted successfully";
        } else {
            // echo "Error: " . mysqli_error($link);
            $_SESSION['msg'] = "Error: " . mysqli_error($link);
            $_SESSION['errorType'] = "error";
        }
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    // Redirect to the reference URL
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    $_SESSION['msg'] = "Invalid request";
    // Redirect to the reference URL
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
