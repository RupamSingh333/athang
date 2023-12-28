<?php

function get_safe_get($name)
{
    $output = $_GET[$name];
    return $output;
}

function get_safe_post($name)
{
    $output = $_POST[$name];
    return $output;
}

function save_command($tblName, $field, $primary_key = "", $primary_value = 0, $return_id = false)
{

    $link = connectme();

    $output = $query = "";
    $output = "Some technical error !. please try again";

    if ($primary_value == "") {
        foreach ($field as $key => $value) {

            $columnfield[] = $key;
            $fieldValue[] = "'" . addslashes(trim($value)) . "'";
        }

        $query = "INSERT into " . $tblName . " (" . implode(',', $columnfield) . ") values (" . implode(',', $fieldValue) . ")";
        // echo $query;die;
        if (mysqli_query($link, $query)) {
            $output = "Data has been saved sucessfully";
        }
    } else {
        foreach ($field as $key => $value) {
            $field_Value[] = $key . " =  '" . addslashes(trim($value)) . "'";
        }
        $query = "UPDATE " . $tblName . " set " . implode(',', $field_Value) . "   where " . $primary_key . " = " . $primary_value;
        //echo $query;
        if (mysqli_query($link, $query)) {
            $output = "Data has been saved sucessfully";
        }
    }
    return $output;
}

function del_command($tblName, $primary_key = "", $primary_value = 0, $return_id = false)
{
    $link = connectme();
    $output = $query = "";
    $output = "Some technical error !. please try again";
    $query = "DELETE FROM  " . $tblName . " where " . $primary_key . " = " . $primary_value;
    // echo $query;die;
    if (mysqli_query($link, $query)) {
        $output = "Request delete sucessfully";
    }
    return $output;
}

function update_status($tblName, $status_field, $status_value, $primary_key, $primary_value)
{
    $link = connectme();

    $output = "Some technical error! Please try again";

    $query = "UPDATE " . $tblName . " SET " . $status_field . " = '" . addslashes(trim($status_value)) . "' WHERE " . $primary_key . " = " . $primary_value;
    // print_r($query);
    // die;

    if (mysqli_query($link, $query)) {
        $output = "Status has been updated successfully";
    }

    return $output;
}
