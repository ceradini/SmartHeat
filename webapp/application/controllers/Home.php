<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index(){
		$data['page'] = 'home';
		
		$data['js_files'] = array('dashboard.js');
		$data['gui_files'] = array('dashboard.js');

		$content_data = array(
			'state_manual' => $this->settings_model->get_setting_value('state_manual', true),
			'global_state' => $this->settings_model->get_setting_value('global_state', true),
			'rules'        => $this->rule_model->get_all()
		);
		
		$data['content'] = $this->load->view('home', $content_data, TRUE);

		$this->load->view('template', $data);
	}

	public function get_room_settings(){
		$room_id = $this->input->get('room_id');

		if($room_id){
			$current_settings = $this->room_model->get_room_settings($room_id);

			$current_settings['temp_threshold'] = json_decode($current_settings['temp_threshold'], true);
			$current_settings['scheduling'] = json_decode($current_settings['scheduling'], true);

			echo $this->load->view('modals/room_settings', $current_settings, TRUE);
		}
	}

	public function save_room_settings(){
		$room_id = $this->input->post('room_id');

		$temp_threshold = json_encode(array(
			'min' => $this->input->post('temp_min') ? $this->input->post('temp_min') : false,
			'max' => $this->input->post('temp_max') ? $this->input->post('temp_max') : false
		));

		$scheduling = NULL;

		$settings = array(
			'temp_threshold' => $temp_threshold,
			'scheduling' => $scheduling
		);

		$this->room_model->set_room_settings($room_id, $settings);
	}

	public function get_date_time(){
		echo $this->load->view('current_date_time',array(),TRUE);
	}
}
