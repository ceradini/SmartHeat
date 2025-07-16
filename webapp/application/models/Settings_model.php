<?php defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Europe/Rome');

class Settings_model extends CI_Model {
    function get_all_global_settings(){
        $this->db->from('global_settings');

        $result = $this->db->get()->result_array();
        $return = array();

        foreach($result as $item){
            $return[$item['name']] = $item['value'];
        }

        return $return;
    }

    function get_setting_value($item, $json_encoded=false){
        $this->db->from('global_settings');
        $this->db->where('name', $item);
        $this->db->limit(1);

        $row = $this->db->get()->row_array();
        
        return $json_encoded ? json_decode($row['value'], true) : $row['value'];
    }

    function set_manual_state($state, $duration=false){
        $end = $duration ? date("Y-m-d H:i:s", strtotime("+$duration hours")) : '';

        $value = json_encode(array(
            'state' => $state,
            'duration' => $duration ? $duration : '',
            'end' => $end
        ));

        $this->db->set('value', $value);
        $this->db->where('name', 'state_manual');
        $this->db->update('global_settings');
    }

    function set_global_state($state){
        $this->db->set('value', $state);
        $this->db->where('name','global_state');
        $this->db->update('global_settings');
    }
}