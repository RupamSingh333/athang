<?php
include("../../system_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['key'] == 'admin' && isset($_FILES['formFiles']) && isset($_FILES['documentFiles']) && isset($_POST['dataId'])  && isset($_POST['vendorId'])) {
        $formFiles = $_FILES['formFiles'];
        $documentFiles = $_FILES['documentFiles'];
        $dataId = $_POST['dataId'];
        $vendorId = $_POST['vendorId'];
        $vendor_assigned_by = $_POST['vendor_assigned_by'];

        // Update the database
        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $formFilesArr = [];
            $documentFilesNameArr = [];

            // Remove previous images
            $previousFormImages = explode(',', $getShopActById['form']);
            $previousDocumentImages = explode(',', $getShopActById['documents']);

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

            $newStatus = $getShopActById['status'] == 0 ? 1 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET form=?, documents=?,status=?,assigned_to_vendor=?,vendor_assigned_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $formFilesNames, $documentNames, $newStatus, $vendorId, $vendor_assigned_by, $dataId);
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

        echo json_encode($response);
    } else if ($_POST['key'] == 'vendor' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        $printed_by = $_POST['data_updated_by'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $newStatus = $getShopActById['status'] == 1 ? 2 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET vendor_desc=?,status=?,printed_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'siii', $statusText, $newStatus, $printed_by, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else if ($_POST['key'] == 'head_office' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        $ho_by = $_POST['data_updated_by'];

        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $newStatus = $getShopActById['status'] == 2 ? 3 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET head_office_desc=?,status=?,ho_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'siii', $statusText, $newStatus, $ho_by, $dataId);
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
        echo json_encode($response);
        die;
        // } else {
        //     $response = ['status' => false, 'message' => 'Invalid module.'];
        //     http_response_code(404);
        // }
    } else if ($_POST['key'] == 'dist_head' && isset($_POST['dataId']) && isset($_POST['statusText'])) {

        $statusText = $_POST['statusText'];
        $dataId = $_POST['dataId'];
        $dh_by = $_POST['data_updated_by'];
        // $module = $_POST['module'];

        // if ($module == 'food_license') {

        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $newStatus = $getShopActById['status'] == 3 ? 4 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET dist_head_desc=?,status=?,dh_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'siii', $statusText, $newStatus, $dh_by, $dataId);
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
        $delivered_by = $_POST['data_updated_by'];
        // if ($module == 'food_license') {

        $getShopActById = getShopActById($dataId);
        if ($getShopActById) {
            $newStatus = $getShopActById['status'] == 4 ? 5 : $getShopActById['status'];
            $sql = "UPDATE shop_act_licence SET emp_to_cust_desc=?, payment_method=?, pay_amount=?, status=?,delivered_by=? WHERE shop_act_licence_id=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssiiii', $statusText, $paymentMethod, $payAmount, $newStatus, $delivered_by, $dataId);
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
