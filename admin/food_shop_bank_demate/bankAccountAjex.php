<?php
include("../../system_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['key'] == 'admin' && isset($_FILES['formFiles']) && isset($_FILES['documentFiles']) && isset($_POST['dataId'])  && isset($_POST['vendorId'])) {
        $formFiles = $_FILES['formFiles'];
        $documentFiles = $_FILES['documentFiles'];
        $dataId = $_POST['dataId'];
        $vendorId = $_POST['vendorId'];

        // Update the database
        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $formFilesArr = [];
            $documentFilesNameArr = [];

            // Remove previous images
            $previousFormImages = explode(',', $getBankAccountById['form']);
            $previousDocumentImages = explode(',', $getBankAccountById['documents']);

            foreach ($previousFormImages as $previousImage) {
                if (!empty($previousImage)) {
                    unlink('../../upload/Images/' . $previousImage);
                }
            }

            foreach ($previousDocumentImages as $previousImage) {
                if (!empty($previousImage)) {
                    unlink('../../upload/Images/' . $previousImage);
                }
            }

            // Process form files
            foreach ($formFiles['tmp_name'] as $key => $tmpName) {
                $formFileName = 'Food_Form_' . $key . '_' . uniqid() . $formFiles['name'][$key];
                $formFilesArr[] = $formFileName;
                move_uploaded_file($tmpName, '../../upload/Images/' . $formFileName);
            }
            $formFilesNames = implode(',', $formFilesArr);

            // Process document files
            foreach ($documentFiles['tmp_name'] as $key => $tmpName) {
                $documentFileName = 'documentFiles_'  . $key . '_' . uniqid() .  $documentFiles['name'][$key];
                $documentFilesNameArr[] = $documentFileName;
                move_uploaded_file($tmpName, '../../upload/Images/' . $documentFileName);
            }
            $documentNames = implode(',', $documentFilesNameArr);

            $newStatus = $getBankAccountById['status'] == 0 ? 1 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET form=?, documents=?,status=?,assigned_to_vendor=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiii', $formFilesNames, $documentNames, $newStatus, $vendorId, $dataId);
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

        echo json_encode($response);
    } else if ($_POST['key'] == 'vendor' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $newStatus = $getBankAccountById['status'] == 1 ? 2 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET vendor_desc=?,status=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sii', $statusText, $newStatus, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else if ($_POST['key'] == 'head_office' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $newStatus = $getBankAccountById['status'] == 2 ? 3 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET head_office_desc=?,status=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sii', $statusText, $newStatus, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else if ($_POST['key'] == 'dist_head' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $newStatus = $getBankAccountById['status'] == 3 ? 4 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET dist_head_desc=?,status=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sii', $statusText, $newStatus, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else if ($_POST['key'] == 'ready_to_customer' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $paymentMethod = $_POST['paymentMethod'];
        $dataId = $_POST['dataId'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getBankAccountById = getBankAccountById($dataId);
        if ($getBankAccountById) {
            $newStatus = $getBankAccountById['status'] == 4 ? 5 : $getBankAccountById['status'];
            $sql = "UPDATE bank_account SET emp_to_cust_desc=?, payment_method=?, status=? WHERE bank_account_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssii', $statusText, $paymentMethod, $newStatus, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else {
        echo json_encode(['status' => false, 'message' => 'Invalid request, Try after sometime !!']);
        http_response_code(400);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'This endpoint only supports POST requests.']);
    http_response_code(405);
}
