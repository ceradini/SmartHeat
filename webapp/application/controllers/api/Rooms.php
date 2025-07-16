<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rooms extends MY_Controller {
	function __construct(){
        parent::__construct();
    }

    function get_rooms(){
        $result = array(
            'rooms' => $this->room_model->get_all(),
            'state_manual' => $this->settings_model->get_setting_value('state_manual', true)['state']
        );
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    function get_room(){
        $room_id = $this->input->get('room_id');

        $room = $this->room_model->get_all();
    }

    function get_roof(){
        $roof_id = 7;

        $result = $this->room_model->get_last_temp($roof_id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    function turn_on(){
        $room_id = $this->input->post('room_id');

        if($room_id){
            $command = array(
                'type' => 'turn_on',
                'room_id' => $room_id
            );

            $this->command_model->add_command(json_encode($command));
        }
    }

    function turn_off(){
        $room_id = $this->input->post('room_id');

        if ($room_id) {
            $command = array(
                'type' => 'turn_off',
                'room_id' => $room_id
            );

            $this->command_model->add_command(json_encode($command));
        }
    }

    function turn_all_on(){
        $command = array(
            'type' => 'turn_all_on'
        );

        $this->command_model->add_command(json_encode($command));
    }

    function turn_all_off(){
        $command = array(
            'type' => 'turn_all_off'
        );

        $this->command_model->add_command(json_encode($command));
    }

    function save_schedule(){
        $form_data = $this->input->post('form_data');
        $schedule = array();

        foreach($form_data as $item){
            if($item['name'] == 'days' || $item['name'] == 'rooms'){
                $schedule[$item['name']][] = $item['value'];
            }
            else {
                $schedule[$item['name']] = $item['value'];
            }
        }

        $schedule['days'] = json_encode($schedule['days'], true);
        $schedule['rooms'] = json_encode($schedule['rooms'], true);

        if($schedule['schedule_id']){
            $this->room_model->update_schedule($schedule['schedule_id'], $schedule);
        }
        else {
            $this->room_model->add_schedule($schedule);
        }
    }

    function up_mode(){
        $mode = $this->input->post('mode');
        $room_id = $this->input->post('room_id');
        
        if($mode == 'rule'){
            $rule_id = $this->input->post('rule_id');

            $this->room_model->set_manual_state($room_id, 0);
            $this->room_model->set_rule_id($room_id, $rule_id);
        }
        else {
            $duration = $this->input->post('duration');
            $temp = $this->input->post('temp');

            $this->room_model->set_manual_state($room_id, 1, $temp, $duration);
        }
    }
}