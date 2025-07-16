<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rules extends MY_Controller {
	function __construct(){
        parent::__construct();
    }

    function save_rule(){
        $result = array(
            'rooms' => $this->room_model->get_all(),
            'state_manual' => $this->settings_model->get_setting_value('state_manual', true)['state']
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    function delete_rule(){
        $rule_id = $this->input->post('rule_id');

        $this->rule_model->delete_rule($rule_id);
    }

    function get_rule_schedule_form(){
        $content_data = array(
            'day' => $this->input->get('day'),
            'num' => $this->input->get('num')
        );

        echo $this->load->view('rule_schedule', $content_data, true);
    }
}