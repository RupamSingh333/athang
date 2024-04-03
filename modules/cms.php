<?php

if (!defined('ABSPATH'))
    die('-1');
define("tbl_user", "reg_user");
define("tbl_user_permission", "user_permission");
define("tbl_state", "states");
define("tbl_cities", "cities");
define("tbl_country", "country");
define("tbl_banner", "banner");
define("tbl_categories", "categories");
define("tbl_product", "product");
define("tbl_plans", "plan");
define("tbl_customer", "customer");
define("tbl_dealer", "dealer");
define("tbl_number", "number");
define("tbl_district", "district");
define("tbl_taluka", "taluka");
define("tbl_demat_link", "demat_link");
define("tbl_bank_link", "bank_link");
define("tbl_attendance", "attendance");
define("tbl_food_licence", "food_licence");
define("tbl_shop_act_licence", "shop_act_licence");
define("tbl_bank_account", "bank_account");
define("tbl_demat_account", "demat_account");
define("tbl_itr", "itr");
define("tbl_bs", "bs");

function getBsCustId($customer_id)
{
    $sql = "select * from " . tbl_bs . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getAllBS()
{
    $sql = "select * from " . tbl_bs . " order by bs_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllBSById($empId)
{
    $sql = "select * from " . tbl_bs . " where assigned_to_vendor = '" . $empId . "' order by bs_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllItr()
{
    $sql = "select * from " . tbl_itr . " order by itr_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllItrById($empId)
{
    $sql = "select * from " . tbl_itr . " where assigned_to_vendor = '" . $empId . "' order by itr_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllDematAccounts()
{
    $sql = "select * from " . tbl_demat_account . " order by demat_account_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllDematAccountsById($empId)
{
    $sql = "select * from " . tbl_demat_account . " where assigned_to_vendor = '" . $empId . "' order by demat_account_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllBankAccounts()
{
    $sql = "select * from " . tbl_bank_account . " order by bank_account_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllBankAccountsById($empId)
{
    $sql = "select * from " . tbl_bank_account . " where assigned_to_vendor = '" . $empId . "' order by bank_account_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllFoodLicense()
{
    $sql = "select * from " . tbl_food_licence . " order by food_licence_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllFoodLicenseById($empId)
{
    $sql = "select * from " . tbl_food_licence . " where assigned_to_vendor = '" . $empId . "' order by food_licence_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllShopAct()
{
    $sql = "select * from " . tbl_shop_act_licence . " order by shop_act_licence_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllShopActById($empId)
{
    $sql = "select * from " . tbl_shop_act_licence . " where assigned_to_vendor = '" . $empId . "' order by shop_act_licence_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAllUsersByRole($roleId)
{
    $sql = "SELECT user_id,first_name FROM " . tbl_user . " WHERE user_type = " . $roleId . " ORDER BY user_id DESC";
    $array = FetchAll($sql);
    return $array;
}


function getCustomerDetails($customer_id)
{
    $sql = "SELECT c.*, s.name AS statename, t.taluka_name, d.district_name 
            FROM " . tbl_customer . " c 
            LEFT JOIN states s ON c.cust_state = s.id 
            LEFT JOIN taluka t ON c.cust_taluka_id = t.taluka_id 
            LEFT JOIN district d ON c.cust_district_id = d.district_id 
            WHERE c.cust_id = '" . $customer_id . "'";
    $results = FetchAll($sql);
    return $results;
}



function getItrCustId($customer_id)
{
    $sql = "select * from " . tbl_itr . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getDematAccountCustId($customer_id)
{
    $sql = "select * from " . tbl_demat_account . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getBankAccountCustId($customer_id)
{
    $sql = "select * from " . tbl_bank_account . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getFoodLicenceByCustId($customer_id)
{
    $sql = "select * from " . tbl_food_licence . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getFoodLicenseById($id)
{
    $sql = "select * from " . tbl_food_licence . " where food_licence_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getBsById($id)
{
    $sql = "select * from " . tbl_bs . " where bs_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getItrById($id)
{
    $sql = "select * from " . tbl_itr . " where itr_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getShopActById($id)
{
    $sql = "select * from " . tbl_shop_act_licence . " where shop_act_licence_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getBankAccountById($id)
{
    $sql = "select * from " . tbl_bank_account . " where bank_account_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getDematAccountById($id)
{
    $sql = "select * from " . tbl_demat_account . " where demat_account_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getShopActByCustId($customer_id)
{
    $sql = "select * from " . tbl_shop_act_licence . " where customer_id='" . $customer_id . "' and status = 0 limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function gettaluka_byID($id)
{
    $sql = "select * from " . tbl_taluka . " where taluka_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function gettaluka_list()
{
    $sql = "select * from " . tbl_taluka . " order by taluka_id desc";
    $array = FetchAll($sql);
    return $array;
}


function getAllDataReport()
{
    $data = array();

    // Fetch data from tbl_food_licence
    $sql = "SELECT * FROM " . tbl_food_licence;
    $foodLicenceData = FetchAll($sql);
    foreach ($foodLicenceData as &$item) {
        $item['service'] = 'Food License';
    }
    $data = array_merge($data, $foodLicenceData);

    // Fetch data from tbl_shop_act_licence
    $sql = "SELECT * FROM " . tbl_shop_act_licence;
    $shopActLicenceData = FetchAll($sql);
    foreach ($shopActLicenceData as &$item) {
        $item['service'] = 'Shop Act';
    }
    $data = array_merge($data, $shopActLicenceData);

    // Fetch data from tbl_bank_account
    $sql = "SELECT * FROM " . tbl_bank_account;
    $bankAccountData = FetchAll($sql);
    foreach ($bankAccountData as &$item) {
        $item['service'] = 'Bank Account';
    }
    $data = array_merge($data, $bankAccountData);

    // Fetch data from tbl_demat_account
    $sql = "SELECT * FROM " . tbl_demat_account;
    $dematAccountData = FetchAll($sql);
    foreach ($dematAccountData as &$item) {
        $item['service'] = 'Demat Account';
    }
    $data = array_merge($data, $dematAccountData);

    // Fetch data from tbl_itr
    $sql = "SELECT * FROM " . tbl_itr;
    $itrData = FetchAll($sql);
    foreach ($itrData as &$item) {
        $item['service'] = 'ITR';
    }
    $data = array_merge($data, $itrData);

    // Fetch data from tbl_bs
    $sql = "SELECT * FROM " . tbl_bs;
    $bsData = FetchAll($sql);
    foreach ($bsData as &$item) {
        $item['service'] = 'B/S';
    }
    $data = array_merge($data, $bsData);

    // Sort the data based on 'created_at'
    usort($data, function ($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    return $data;
}

function getServiceData($tableName, $empId, $firstDayOfMonth, $lastDayOfMonth)
{
    $sql = "SELECT COUNT(*) AS count FROM $tableName WHERE user_updated_by = '$empId' AND created_at BETWEEN STR_TO_DATE('$firstDayOfMonth', '%Y-%m-%d') AND STR_TO_DATE('$lastDayOfMonth', '%Y-%m-%d') AND status = 5";
    $data = FetchRow($sql);

    return ($data['count'] > 0) ? $data['count'] : 0;
}

function getAllPointsByEmpId($empId, $year, $month, $userType)
{
    $firstDayOfMonth = date("$year-$month-01");
    $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));
    $data = array();

    $data['Food_License'] = getServiceData(tbl_food_licence, $empId, $firstDayOfMonth, $lastDayOfMonth);
    $data['Shop_Act'] = getServiceData(tbl_shop_act_licence, $empId, $firstDayOfMonth, $lastDayOfMonth);
    $data['Bank_Account'] = getServiceData(tbl_bank_account, $empId, $firstDayOfMonth, $lastDayOfMonth);
    $data['Demat_Account'] = getServiceData(tbl_demat_account, $empId, $firstDayOfMonth, $lastDayOfMonth);
    $data['ITR'] = getServiceData(tbl_itr, $empId, $firstDayOfMonth, $lastDayOfMonth);
    $data['BS'] = getServiceData(tbl_bs, $empId, $firstDayOfMonth, $lastDayOfMonth);
    return $data;
}


function getTotalWorkingDaysByEmpId($empId, $year, $month)
{
    $firstDayOfMonth = date("$year-$month-01");
    $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));
    $sql = "SELECT attendance_date, status 
            FROM " . tbl_attendance . " 
            WHERE emp_id = $empId AND status IN ('P','HF')
            AND attendance_date BETWEEN STR_TO_DATE('$firstDayOfMonth', '%Y-%m-%d') 
            AND STR_TO_DATE('$lastDayOfMonth', '%Y-%m-%d')";

    $result = FetchAll($sql);
    $totalWorkingDays = 0;
    foreach ($result as $row) {
        $status = strtoupper($row['status']);
        if ($status === 'P' || $status === 'HF') {
            $totalWorkingDays += ($status === 'P') ? 1 : 0.5;
        }
    }

    return $totalWorkingDays;
}

function getdistrict_byID($id)
{
    $sql = "select * from " . tbl_district . " where district_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}
function getdistrict_list()
{
    $sql = "select * from " . tbl_district . " order by  district_id desc";
    $array = FetchAll($sql);
    return $array;
}
function getuser_permission_byID($id = null)
{
    $sql = "select * from " . tbl_user_permission . " where user_id = '" . $id . "'";
    $array = FetchAll($sql);
    return $array;
}

function getuser_byID($id_or_email = null)
{
    if (is_numeric($id_or_email)) {
        $sql = "select * from " . tbl_user . " where user_id = '" . $id_or_email . "' limit 0,1 ";
    } else {
        $sql = "select * from " . tbl_user . " where user_email = '" . $id_or_email . "' limit 0,1 ";
    }
    $array = FetchRow($sql);
    return $array;
}

function getuser_byList()
{

    $sql = "select * from " . tbl_user . " order by  user_id desc ";
    // pr($sql);exit;
    $array = FetchAll($sql);
    return $array;
}

function getSalaryData()
{

    $sql = "select * from employee_salary_data order by id desc";
    $array = FetchAll($sql);
    return $array;
}

function getAttendanceByDate($userId, $date)
{

    $sql = "SELECT status FROM " . tbl_attendance . " WHERE emp_id = $userId AND attendance_date = STR_TO_DATE('$date', '%Y-%m-%d')";
    $array = FetchRow($sql);
    return $array;
}

function getAllAttendanceData($userId, $year, $month)
{
    $firstDayOfMonth = date("$year-$month-01");
    $lastDayOfMonth = date("Y-m-t", strtotime($firstDayOfMonth));

    $sql = "SELECT attendance_date, status, reason FROM " . tbl_attendance . " 
            WHERE emp_id = $userId 
            AND attendance_date BETWEEN STR_TO_DATE('$firstDayOfMonth', '%Y-%m-%d') 
                                   AND STR_TO_DATE('$lastDayOfMonth', '%Y-%m-%d')";

    $result = FetchAll($sql);

    $attendanceData = [];

    foreach ($result as $row) {
        $attendanceDate = $row['attendance_date'];
        $attendanceData[$attendanceDate] = [
            'status' => $row['status'],
            'reason' => $row['reason']
        ];
    }

    return $attendanceData;
}




function getCountry_list()
{
    $sql = "select * from " . tbl_country . " where status = 'Y' order by  id asc ";
    $array = FetchAll($sql);
    return $array;
}

function getCountry_byID($id = null)
{
    $sql = "select * from " . tbl_country . " where id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getState_byID($id = null)
{
    $sql = "select * from " . tbl_state . " where id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getState_list($countryId = null)
{

    if ($countryId) {
        $sql = "select * from " . tbl_state . " where country_id =" . $countryId .  " order by id asc";
    } else {
        $sql = "select * from " . tbl_state . " order by  id asc limit 100";
    }

    $array = FetchAll($sql);
    return $array;
}

function getCityList($stateId = null)
{
    if ($stateId) {
        $sql = "select * from " . tbl_cities . " where state_id ='" . $stateId . "' order by id asc";
    } else {
        $sql = "select * from " . tbl_cities . " order by id asc limit 100";
    }
    $array = FetchAll($sql);
    return $array;
}

function getCity_byID($id = null)
{
    $sql = "select * from " . tbl_cities . " where id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getbanner_byID($id = null)
{
    $sql = "select * from " . tbl_banner . " where banner_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getbanner_list()
{
    $sql = "select * from " . tbl_banner . " order by  banner_id desc";
    // echo $sql;die();
    $array = FetchAll($sql);
    return $array;
}

function getCategory_byID($id)
{
    $sql = "select * from " . tbl_categories . " where cat_id='" . $id . "' limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getDematLink_byID($id_or_link)
{
    if (is_numeric($id_or_link)) {
        $sql = "select * from " . tbl_demat_link . " where demat_link_id ='" . $id_or_link . "' limit 0,1 ";
    } else {
        $sql = "select * from " . tbl_demat_link . " where link ='" . $id_or_link . "' limit 0,1 ";
    }
    $array = FetchRow($sql);
    return $array;
}

function getDematLink_list()
{
    $sql = "select * from " . tbl_demat_link . "  order by demat_link_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getBankLink_byID($id_or_link)
{
    if (is_numeric($id_or_link)) {
        $sql = "select * from " . tbl_bank_link . " where bank_link_id ='" . $id_or_link . "' limit 0,1 ";
    } else {
        $sql = "select * from " . tbl_bank_link . " where link ='" . $id_or_link . "' limit 0,1 ";
    }
    $array = FetchRow($sql);
    return $array;
}

function getBankLink_list()
{
    $sql = "select * from " . tbl_bank_link . "  order by bank_link_id desc";
    $array = FetchAll($sql);
    return $array;
}

function getCatNameByIds($catIds = null)
{
    $categories = array();

    if ($catIds) {
        $sqlCategories = "SELECT cat_id, cat_name, add_image FROM categories WHERE cat_id IN ($catIds)";
    } else {
        $sqlCategories = "SELECT cat_id, cat_name, add_image FROM categories";
    }

    $fetchedCategories = FetchAll($sqlCategories);

    foreach ($fetchedCategories as $category) {
        $categories[$category['cat_id']] = $category['cat_name'];
    }

    return $categories;
}

function getCategory_list($order = null, $catIds = null)
{
    $sql = "SELECT * FROM " . tbl_categories;
    if ($catIds) {
        $sql .= " WHERE cat_id IN ($catIds) and cat_status = '0'";
    } else if ($order !== null) {
        $sql .= " WHERE cat_status = '0' ORDER BY $order ASC";
    } else {
        $sql .= " WHERE cat_status = '0' ORDER BY cat_id DESC";
    }
    // pr($sql);die;
    $array = FetchAll($sql);
    return $array;
}

function getCategory_list_for_admin($order = null, $catIds = null)
{
    $sql = "SELECT * FROM " . tbl_categories;
    if ($order !== null) {
        $sql .= " ORDER BY $order ASC";
    } else {
        $sql .= " ORDER BY cat_id DESC";
    }
    $array = FetchAll($sql);
    return $array;
}

function getproduct_byID($subCatId)
{
    $sql = "SELECT * FROM " . tbl_product . " WHERE product_id = " . $subCatId . " limit 0,1 ";
    $array = FetchRow($sql);
    return $array;
}

function getCategoryWiseProductList($Id = null)
{
    $catId = decryptIt($Id);

    $sql = "SELECT p.*, c.cat_name, sc.sub_cat_name
        FROM " . tbl_plans . " AS p
        LEFT JOIN " . tbl_categories . " AS c ON p.category_id = c.cat_id
        LEFT JOIN " . tbl_product . " AS sc ON p.product_id = sc.product_id
        WHERE c.cat_id = '" . $catId . "' and status = '0' ";

    $results = FetchAll($sql);
    return $results;
}

function getplanListBySubCatId($subCatId = null)
{

    $sql = "SELECT p.*  FROM " . tbl_plans . " AS p  WHERE p.product_id = '" . $subCatId . "'";


    if ($_SESSION['dealerId']) {
        $sql .= " and status = '0' and visibility IN ('D','A')";
    } else {
        $sql .= " and status = '0' and visibility IN ('C','A')";
    }

    $results = FetchAll($sql);
    return $results;
}

function getproduct_list($order = null)
{
    $sql = "select * from " . tbl_product . " ";
    if ($order !== null) {
        $sql .= " ORDER BY $order ASC";
    } else {
        $sql .= " ORDER BY product_id DESC";
    }

    $array = FetchAll($sql);
    return $array;
}

function getproductByCategoryId($id = null)
{
    $sql = "select * from " . tbl_product . " where p_cat=" . $id . " AND product_status='0' order by product_id desc";
    $array = FetchAll($sql);
    return $array;
}
function getplanBySubCategoryId($id = null)
{
    $sql = "select * from " . tbl_plans . " where subcategory_id=" . $id . " AND status='0' order by plan_id desc";
    $array = FetchAll($sql);
    return $array;
}
function getcustomer_byID($id_or_email = null)
{
    if (is_numeric($id_or_email)) {
        $sql = "SELECT * FROM " . tbl_customer . " WHERE cust_id = '" . $id_or_email . "' LIMIT 0,1";
    } else {
        $sql = "SELECT * FROM " . tbl_customer . " WHERE cust_email = '" . $id_or_email . "' LIMIT 0,1";
    }
    // pr($sql);exit;
    $array = FetchRow($sql);
    return $array;
}

function getcustomer_byList()
{
    $sql = "select * from " . tbl_customer . " order by cust_id desc ";
    $array = FetchAll($sql);
    return $array;
}

function getplanList($dealerId = null)
{
    $sql = 'SELECT * FROM ' . tbl_plans;

    if (!empty($dealerId)) {
        $sql .= ' WHERE dealer_id = ' . (int)$dealerId;
    }

    $sql .= ' ORDER BY plan_id DESC';

    $array = FetchAll($sql);
    return $array;
}

function getnumberList($dealerId = null)
{
    $sql = 'SELECT * FROM ' . tbl_number;

    $sql .= ' ORDER BY number_id DESC';

    $array = FetchAll($sql);
    return $array;
}
function searchplans($keyword = null, $categoryID = null, $sort = null)
{
    $sql = 'SELECT * FROM ' . tbl_plans;

    if (!empty($categoryID) && !empty($keyword)) {
        $sql .= " WHERE category_id =" . (int)$categoryID;
        $sql .= " AND (plan_name LIKE '%$keyword%' OR description LIKE '%$keyword%'  OR feature_details LIKE '%$keyword%')";
    } elseif (!empty($categoryID)) {
        $sql .= " WHERE category_id =" . (int)$categoryID;
    } elseif (!empty($keyword)) {
        $sql .= " WHERE (plan_name LIKE '%$keyword%' OR description LIKE '%$keyword%'  OR feature_details LIKE '%$keyword%')";
    }

    if ($_SESSION['dealerId']) {
        $sql .= " and status = '0' and visibility IN ('D','A')";
    } else {
        $sql .= " and status = '0' and visibility IN ('C','A')";
    }

    switch ($sort) {
        case 'name_asc':
            $sql .= ' ORDER BY plan_name ASC';
            break;
        case 'name_desc':
            $sql .= ' ORDER BY plan_name DESC';
            break;
        case 'price_asc':
            $sql .= ' ORDER BY customer_discount_price ASC';
            break;
        case 'price_desc':
            $sql .= ' ORDER BY customer_discount_price DESC';
            break;
        default:
            $sql .= ' ORDER BY plan_id DESC';
            break;
    }

    // pr($sql);die;
    $array = FetchAll($sql);
    return $array;
}



function getFeatureplanList($catIds = null, $isFeature = null, $isDealer = null)
{
    if ($isFeature == 'N') {
        $sqlCategories = "SELECT cat_id, cat_name, add_image FROM categories WHERE cat_id IN ($catIds)";
    } else if ($catIds) {
        $sqlCategories = "SELECT cat_id, cat_name, add_image FROM categories WHERE cat_id IN ($catIds) AND featured = 'Y'";
    } else {
        $sqlCategories = "SELECT cat_id, cat_name, add_image FROM categories WHERE featured = 'Y'";
    }
    $sqlCategories .= " and cat_status = '0'";
    // pr($sqlCategories);

    $categories = FetchAll($sqlCategories);

    $result = array();

    foreach ($categories as $category) {
        $categoryId = $category['cat_id'];
        $categoryName = $category['cat_name'];
        $categoryAddImage = $category['add_image'];
        if ($isDealer == 'D') {
            $sqlplans = "SELECT * FROM plans WHERE category_id = $categoryId and status = '0' and visibility IN ('D','A') order by plan_name ASC";
        } else {
            $sqlplans = "SELECT * FROM plans WHERE category_id = $categoryId and status = '0' and visibility IN ('C','A') order by plan_name ASC";
        }
        // pr($sqlplans);
        $plans = FetchAll($sqlplans);

        $result[] = array(
            'category_name' => $categoryName,
            'category_add_image' => $categoryAddImage,
            'plans' => $plans
        );
    }


    return $result;
}

function getplanID($id = null, $isAdmin = null)
{
    if ($isAdmin) {
        $sql = "select * from " . tbl_plans . " where plan_id = '" . $id . "' limit 0,1 ";
    } else {
        $sql = "select * from " . tbl_plans . " where plan_id = '" . $id . "' and status = '0' limit 0,1 ";
    }
    $array = FetchRow($sql);
    return $array;
}
function getnumberID($id = null, $isAdmin = null)
{
    if ($isAdmin) {
        $sql = "select * from " . tbl_number . " where number_id = '" . $id . "' limit 0,1 ";
    } else {
        $sql = "select * from " . tbl_number . " where number_id = '" . $id . "' and status = '0' limit 0,1 ";
    }
    $array = FetchRow($sql);
    return $array;
}
function getDealertList()
{
    $sql = 'SELECT * FROM ' . tbl_dealer . ' ORDER by dealer_id DESC';
    $array = FetchAll($sql);
    return $array;
}

function getDealerID($identifier = null)
{
    $sql = "SELECT * FROM " . tbl_dealer . " WHERE dealer_id = '" . $identifier . "' OR dealer_email = '" . $identifier . "' LIMIT 0,1";
    $array = FetchRow($sql);
    return $array;
}

function CheckMobileEmailExist($table, $fieldName, $value)
{
    $sql = "SELECT * FROM " . $table . " WHERE " . $fieldName . " = '" . $value . "' LIMIT 0,1";
    $array = FetchRow($sql);

    if (!empty($array)) {
        return 0; // Mobile number or email exists
    } else {
        return 1; // Mobile number or email does not exist
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $charCount = strlen($characters);
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charCount - 1)];
    }

    return $randomString;
}

function sendEmail($to, $subject, $message, $from = 'your_email@example.com', $fromName = 'Your Name')
{
    require 'path/to/PHPMailer/PHPMailer.php';
    require 'path/to/PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Replace with your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com';  // Replace with your email address
        $mail->Password = 'your_password';  // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient details
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Failed to send the email
    }
}

function getplanInquiriesList($id = null)
{
    $sql = 'SELECT pi.*, p.plan_name,p.single_images,p.dealer_id, p.category_id, p.product_id, c.cat_name, sc.sub_cat_name FROM plan_inquiries pi';
    $sql .= ' LEFT JOIN `' . tbl_plans . '` p ON pi.plan_id = p.plan_id';
    $sql .= ' LEFT JOIN `' . tbl_categories . '` c ON p.category_id = c.cat_id';
    $sql .= ' LEFT JOIN `' . tbl_product . '` sc ON p.product_id = sc.product_id';

    // if (!empty($id)) {
    //     $sql .= ' WHERE p.dealer_id = ' . (int)$id . ' and pi.is_assigned="Y"';
    // }

    if (!empty($id)) {
        $sql .= ' WHERE pi.for_dealer_id = ' . (int)$id . ' and pi.is_assigned="Y"';
    }

    $sql .= ' ORDER BY pi.plan_id DESC';
    $array = FetchAll($sql);
    return $array;
}

function getplanInquiriesById($id = null)
{
    $sql = 'SELECT * FROM plan_inquiries WHERE inquiry_id = ' . (int)$id . ' LIMIT 1';
    $row = FetchRow($sql);
    return $row;
}
