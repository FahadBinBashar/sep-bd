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


?>