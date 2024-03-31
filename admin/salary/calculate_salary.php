<?php
include("../../system_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from POST request
    $employee_id = $_POST['data_id'];
    $selected_month = $_POST['selected_month'];
    $selected_month = $selected_month . '-' . date('d');
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

    $selected_month_year = date('Y-m', strtotime($selected_month));
    $check_sql = "SELECT COUNT(*) AS count FROM employee_salary_data WHERE employee_id = ? AND selected_month = ?";
    $check_stmt = mysqli_prepare($link, $check_sql);
    mysqli_stmt_bind_param($check_stmt, 'is', $employee_id, $selected_month_year);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_bind_result($check_stmt, $count);
    mysqli_stmt_fetch($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($count > 0) {
        $_SESSION['msg'] = "Data already exists for this employee and month";
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
            // echo "Data inserted successfully";
        } else {
            // echo "Error: " . mysqli_error($link);
            $_SESSION['msg'] = "Error: " . mysqli_error($link);
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