<?php
include("../system_config.php");

if ($_POST['keys'] == 'ready_to_customer' && $_POST['key'] == 'qwertyupasdfghjklzxcvbnm' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

    $authUserId = $_POST['authUserId'];
    $statusText = $_POST['statusText'];
    $paymentMethod = $_POST['paymentMethod'];
    $payAmount = $_POST['payAmount'];
    $dataId = $_POST['dataId'];
    $module = $_POST['module'];

    if ($module == 'food_license') {
        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $newStatus = $getFoodLicenseById['status'] == 4 ? 5 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE food_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'Food license has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'Food license not found.'];
            http_response_code(404);
        }
    } else if ($module == 'shop_act_license') {

        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $newStatus = $getShopActById['status'] == 4 ? 5 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'Shop Act License has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'Shop Act License not found.'];
            http_response_code(404);
        }
    } else if ($module == 'bank_account') {
        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $newStatus = $getBankAccountById['status'] == 4 ? 5 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'Food license has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'Food license not found.'];
            http_response_code(404);
        }
    } else if ($module == 'demat_account') {
        $getDematAccountById = getDematAccountById($dataId);
        if ($getDematAccountById) {
            $newStatus = $getDematAccountById['status'] == 4 ? 5 : $getDematAccountById['status'];
            $sql = "UPDATE demat_account SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE demat_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'Demat Account has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'Demat Account not found.'];
            http_response_code(404);
        }
    } else if ($module == 'itr') {
        $getItrById = getItrById($dataId);
        if ($getItrById) {
            $newStatus = $getItrById['status'] == 4 ? 5 : $getItrById['status'];
            $sql = "UPDATE itr SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE itr_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'ITR has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'ITR not found.'];
            http_response_code(404);
        }
    } else if ($module == 'bs') {
        $getBsById = getBsById($dataId);
        if ($getBsById) {
            $newStatus = $getBsById['status'] == 4 ? 5 : $getBsById['status'];
            $sql = "UPDATE bs SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE bs_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $authUserId, $dataId);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['status' => true, 'message' => 'B/S has been updated successfully.'];
                    http_response_code(200);
                } else {
                    $response = ['status' => false, 'message' => 'Failed to execute SQL statement.'];
                    http_response_code(500);
                }
            } else {
                $response = ['status' => false, 'message' => 'Failed to prepare SQL statement.'];
                http_response_code(500);
            }
        } else {
            $response = ['status' => false, 'message' => 'B/S not found.'];
            http_response_code(404);
        }
    } else {
        $response = ['status' => false, 'message' => 'invalid module.'];
        http_response_code(404);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    die;
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
