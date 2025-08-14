<?php

function get_name_by_auto_id( $table_name = NULL, $auto_id = NULL, $field_name = 'name' )
{
    $ci = &get_instance();
    if ( !empty( $table_name ) and !empty( $auto_id ) and !empty( $field_name ) ) {
        $query     = $ci->db->select( 'id,' . $field_name );
        $query     = $ci->db->where( 'id', $auto_id );
        $query     = $ci->db->get( $table_name );
        $total_row = $query->num_rows();
        if ( $total_row > 0 ) {
            $ressult = $query->row();
            return $ressult->$field_name;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function check_unique_field( $table_name = NULL, $unique_field = NULL, $field_name = 'name' )
{
    $ci = &get_instance();
    if ( !empty( $table_name ) and !empty( $unique_field ) and !empty( $field_name ) ) {
        $query     = $ci->db->select( $field_name );
        $query     = $ci->db->where( $field_name, $unique_field );
        $query     = $ci->db->get( $table_name );
        $total_row = $query->num_rows();
        if ( $total_row > 0 ) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        return FALSE;
    }
}

function check_loan_ac( $ac_id = NULL )
{
    $ci = &get_instance();
    if ( !empty( $ac_id ) ) {
        $query     = $ci->db->select( '*' );
        $query     = $ci->db->where( 'account_id', $ac_id );
        $query     = $ci->db->where_in( 'sts', [1,2] );
        $query     = $ci->db->get( 'account_loan' );
        $total_row = $query->num_rows();
        if ( $total_row > 0 ) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        return FALSE;
    }
}

function get_data_by_ac_no( $table_name = NULL, $auto_id = NULL, $field_name = 'name' )
{
    $ci = &get_instance();
    if ( !empty( $table_name ) and !empty( $auto_id ) and !empty( $field_name ) ) {
        $query     = $ci->db->select( 'ac_no,' . $field_name );
        $query     = $ci->db->where( 'ac_no', $auto_id );
        $query     = $ci->db->get( $table_name );
        $total_row = $query->num_rows();
        if ( $total_row > 0 ) {
            $ressult = $query->row();
            return $ressult->$field_name;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function get_data_by_loan_id( $table_name = NULL, $auto_id = NULL, $field_name = 'name' )
{
    $ci = &get_instance();
    if ( !empty( $table_name ) and !empty( $auto_id ) and !empty( $field_name ) ) {
        $query     = $ci->db->select( 'loan_id,' . $field_name );
        $query     = $ci->db->where( 'loan_id', $auto_id );
        $query     = $ci->db->get( $table_name );
        $total_row = $query->num_rows();
        if ( $total_row > 0 ) {
            $ressult = $query->row();
            return $ressult->$field_name;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}



?>