<?php
include("../../system_config.php");
$action = $_GET['action'] ?? '';

switch ($action) {
    case "assigned":
        if (isset($_GET['dealer'])) {
            $id = (int)$_GET['inquiry_product_id'];
            $row = getProductInquiriesById($id);
            if ($row) {
                // $status = ($row['status'] === "Y") ? "N" : "Y";
                if ($_GET['dealer'] == 0) {
                    $field = ['is_assigned' => 'N', 'for_dealer_id' => null];
                    $_SESSION['msg'] = 'Dealer has been removed from this Inquiry successfully';
                } else {
                    $field = ['is_assigned' => 'Y', 'for_dealer_id' => $_GET['dealer']];
                    $_SESSION['msg'] = 'This lead has been assigned successfully to the selected dealer';
                }

                $output = save_command('product_inquiries', $field, 'inquiry_id', $id);
                $_SESSION['alert_type'] = 'success';
            } else {
                $_SESSION['msg'] = "Product inquiry not found.";
                $_SESSION['alert_type'] = 'danger';
            }
        } else {
            $_SESSION['msg'] = "Invalid product inquiry ID.";
            $_SESSION['alert_type'] = 'danger';
        }
        break;
}


// Redirect to the appropriate URL
header("Location: " . $_SERVER['HTTP_REFERER']);
