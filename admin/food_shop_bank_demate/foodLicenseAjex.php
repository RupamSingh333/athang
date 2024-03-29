<?php
include("../../system_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['key'] == 'admin' && isset($_FILES['formFiles']) && isset($_FILES['documentFiles']) && isset($_POST['dataId'])  && isset($_POST['vendorId'])) {
        $formFiles = $_FILES['formFiles'];
        $documentFiles = $_FILES['documentFiles'];
        $dataId = $_POST['dataId'];
        $vendorId = $_POST['vendorId'];

        // Update the database
        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $formFilesArr = [];
            $documentFilesNameArr = [];

            // Remove previous images
            $previousFormImages = explode(',', $getFoodLicenseById['form']);
            $previousDocumentImages = explode(',', $getFoodLicenseById['documents']);

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

            $newStatus = $getFoodLicenseById['status'] == 0 ? 1 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET form=?, documents=?,status=?,assigned_to_vendor=? WHERE food_licence_id=?";
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

        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $newStatus = $getFoodLicenseById['status'] == 1 ? 2 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET vendor_desc=?,status=? WHERE food_licence_id=?";
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

        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $newStatus = $getFoodLicenseById['status'] == 2 ? 3 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET head_office_desc=?,status=? WHERE food_licence_id=?";
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

        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $newStatus = $getFoodLicenseById['status'] == 3 ? 4 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET dist_head_desc=?,status=? WHERE food_licence_id=?";
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
        $payAmount = $_POST['payAmount'];
        $dataId = $_POST['dataId'];
        // $module = $_POST['module'];

        // pr($_POST);exit;

        // if ($module == 'food_license') {

        $getFoodLicenseById = getFoodLicenseById($dataId);
        if ($getFoodLicenseById) {
            $newStatus = $getFoodLicenseById['status'] == 4 ? 5 : $getFoodLicenseById['status'];
            $sql = "UPDATE food_licence SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=? WHERE food_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiii', $statusText, $paymentMethod, $payAmount, $newStatus, $dataId);
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
