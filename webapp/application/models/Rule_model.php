<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rule_model extends CI_Model {
    /**
     * @vars
     */
    private $_table;

    /**
     * Constructor
     */
    function __construct(){
        parent::__construct();

        // define primary table
        $this->_table = 'rules';
    }

    function get_all(){
        $this->db->from($this->_table);
        return $this->db->get()->result_array();
    }

    function get_rule($rule_id){
        $this->db->from($this->_table);
        $this->db->where('id', $rule_id);
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    function get_rule_schedules($rule_id, $organized_by_day=true){
        $this->db->from('rules_scheduling');
        $this->db->where('rule_id', $rule_id);

        $result = $this->db->get()->result_array();

        if($organized_by_day){
            $out = array();

            foreach($result as $schedule){
                $out[$schedule['day']-1][] = $schedule;
            }

            return $out;
        }
        else {
            return $result;
        }
    }

    function add_rule($rule){
        $this->db->insert($this->_table, $rule);

        return $this->db->insert_id();
    }

    function edit_rule($rule_id, $rule){
        $this->db->where('id', $rule_id);
        $this->db->update($this->_table, $rule);
    }

    function delete_rule($rule_id){
        $this->db->where('id', $rule_id);
        $this->db->delete($this->_table);
    }

    function add_rule_schedule($rule_schedule){
        $this->db->insert('rules_scheduling', $rule_schedule);
    }

    function delete_rule_schedules($rule_id){
        $this->db->where('rule_id', $rule_id);
        $this->db->delete('rules_scheduling');
    }

    function get_current_temp($rule_id){
        $temp = $this->config->item('default_temp');

        $day = date("w");
        $day = $day == 0 ? 7 : $day; // to change the sunday number from 0 to 7 as in the database

        $now = date("H:i:s");

        $this->db->from('rules_scheduling');
        $this->db->where('rule_id', $rule_id);
        $this->db->where('day', $day);
        $this->db->where('start <=', $now);
        $this->db->where('end >=', $now);
        $this->db->order_by('temp','desc'); // given priority to the rule with greater temperature
        $this->db->limit(1);

        $result = $this->db->get()->row_array();

        if($result){
            $temp = $result['temp'];
        }
        else {
            // selecting the default temp for this rule
            $this->db->select('temp_default');
            $this->db->from($this->_table);
            $this->db->where('id', $rule_id);
            $this->db->limit(1);

            $temp = current($this->db->get()->row_array());
        }

        return $temp;
    }
}