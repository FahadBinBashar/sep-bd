<?php

namespace App\Helpers {

class UtilityHelper
{
    public static function getNameByAutoId($table_name = null, $auto_id = null, $field_name = 'name')
    {
        $ci = &get_instance();
        if (!empty($table_name) && !empty($auto_id) && !empty($field_name)) {
            $query     = $ci->db->select('id,' . $field_name);
            $query     = $ci->db->where('id', $auto_id);
            $query     = $ci->db->get($table_name);
            $total_row = $query->num_rows();
            if ($total_row > 0) {
                $ressult = $query->row();
                return $ressult->$field_name;
            }
        }
        return false;
    }

    public static function checkUniqueField($table_name = null, $unique_field = null, $field_name = 'name')
    {
        $ci = &get_instance();
        if (!empty($table_name) && !empty($unique_field) && !empty($field_name)) {
            $query     = $ci->db->select($field_name);
            $query     = $ci->db->where($field_name, $unique_field);
            $query     = $ci->db->get($table_name);
            $total_row = $query->num_rows();
            return $total_row > 0 ? false : true;
        }
        return false;
    }

    public static function checkLoanAc($ac_id = null)
    {
        $ci = &get_instance();
        if (!empty($ac_id)) {
            $query     = $ci->db->select('*');
            $query     = $ci->db->where('account_id', $ac_id);
            $query     = $ci->db->where_in('sts', [1,2]);
            $query     = $ci->db->get('account_loan');
            $total_row = $query->num_rows();
            return $total_row > 0 ? false : true;
        }
        return false;
    }

    public static function getDataByAcNo($table_name = null, $auto_id = null, $field_name = 'name')
    {
        $ci = &get_instance();
        if (!empty($table_name) && !empty($auto_id) && !empty($field_name)) {
            $query     = $ci->db->select('ac_no,' . $field_name);
            $query     = $ci->db->where('ac_no', $auto_id);
            $query     = $ci->db->get($table_name);
            $total_row = $query->num_rows();
            if ($total_row > 0) {
                $ressult = $query->row();
                return $ressult->$field_name;
            }
        }
        return false;
    }

    public static function getDataByLoanId($table_name = null, $auto_id = null, $field_name = 'name')
    {
        $ci = &get_instance();
        if (!empty($table_name) && !empty($auto_id) && !empty($field_name)) {
            $query     = $ci->db->select('loan_id,' . $field_name);
            $query     = $ci->db->where('loan_id', $auto_id);
            $query     = $ci->db->get($table_name);
            $total_row = $query->num_rows();
            if ($total_row > 0) {
                $ressult = $query->row();
                return $ressult->$field_name;
            }
        }
        return false;
    }
}

}

namespace {
    use App\Helpers\UtilityHelper;

    if (!function_exists('get_name_by_auto_id')) {
        function get_name_by_auto_id($table_name = null, $auto_id = null, $field_name = 'name')
        {
            return UtilityHelper::getNameByAutoId($table_name, $auto_id, $field_name);
        }
    }

    if (!function_exists('check_unique_field')) {
        function check_unique_field($table_name = null, $unique_field = null, $field_name = 'name')
        {
            return UtilityHelper::checkUniqueField($table_name, $unique_field, $field_name);
        }
    }

    if (!function_exists('check_loan_ac')) {
        function check_loan_ac($ac_id = null)
        {
            return UtilityHelper::checkLoanAc($ac_id);
        }
    }

    if (!function_exists('get_data_by_ac_no')) {
        function get_data_by_ac_no($table_name = null, $auto_id = null, $field_name = 'name')
        {
            return UtilityHelper::getDataByAcNo($table_name, $auto_id, $field_name);
        }
    }

    if (!function_exists('get_data_by_loan_id')) {
        function get_data_by_loan_id($table_name = null, $auto_id = null, $field_name = 'name')
        {
            return UtilityHelper::getDataByLoanId($table_name, $auto_id, $field_name);
        }
    }
}

