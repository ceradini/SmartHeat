<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends MY_Controller
{
    function __construct(){
        parent::__construct();
    }

    function get_manual_time_left(){
        $state_manual = $this->settings_model->get_setting_value('state_manual', true);

        $time_left = $state_manual['state'] == '1' ? get_time_left($state_manual['end'], $state_manual['duration']) : 0;  

        $result = array(
            'time_left' => $time_left != 'inf' ? $time_left : '&#8734;'
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    function up_state_manual_all(){
        $state = $this->input->post('state');
        $duration = $this->input->post('duration') ? $this->input->post('duration') : false;
        $temp = $this->input->post('temp');

        $this->room_model->set_manual_state_all($state, $temp, $duration);
    }

    function up_state_manual(){
        $room_id  = $this->input->post('room_id');
        $state    = $this->input->post('state');
        $duration = $this->input->post('duration') ? $this->input->post('duration'): false;
        $temp     = $this->input->post('temp');

        $this->room_model->set_manual_state($room_id, $state, $temp, $duration);
    }

    function up_global_state(){
        $state = $this->input->post('state');

        $this->settings_model->set_global_state($state);

        if($state == '0'){
            $rooms = $this->room_model->get_all_names();

            foreach($rooms as $room_id=>$val){
                $command = array(
                    'type' => 'turn_off',
                    'room_id' => $room_id
                );

                $this->command_model->add_command(json_encode($command));
            }
        }
    }
}
