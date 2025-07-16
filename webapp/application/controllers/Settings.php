<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	public function index(){
        $data['page'] = 'settings';        
        $data['js_files'] = array('settings.js');
		$data['gui_files'] = array('settings.js');
		
		$content_data['rules'] = $this->rule_model->get_all();
		$content_data['rooms_names'] = $this->room_model->get_all_names();
		
		$data['content'] = $this->load->view('settings', $content_data, TRUE);

		$this->load->view('template', $data);
	}

	public function system_reboot() {        
        exec('sudo /sbin/reboot 2>&1', $output, $return_var);
        
        if ($return_var !== 0) {
            $error = implode("\n", $output);
            log_message('error', 'Reboot failed: ' . $error);
            echo json_encode(['success' => false, 'error' => $error]);
        } else {
            echo json_encode(['success' => true]);
        }
    }

	public function form($rule_id=False){
		if(!$this->input->post()){
			$data['page'] = 'settings';
			$data['js_files'] = array('settings.js');

			$content_data['days'] = get_all_days();
			$content_data['rule_id'] = $rule_id;
			$content_data['rule_details'] = $rule_id ? $this->rule_model->get_rule($rule_id) : array();
			$content_data['rule_schedules'] = $rule_id ? $this->rule_model->get_rule_schedules($rule_id) : array();

			$data['content'] = $this->load->view('rule_form', $content_data, TRUE);

			$this->load->view('template', $data);
		}
		else {
			$rule = array(
				'name' => $this->input->post('name'),
				'temp_default' => $this->input->post('temp_default')
			);

			if($this->input->post('rule_id')){
				$rule_id = $this->input->post('rule_id');
				
				$this->rule_model->edit_rule($rule_id, $rule);
				$this->rule_model->delete_rule_schedules($rule_id); // remove old rule schedules
			}
			else {
				$rule_id = $this->rule_model->add_rule($rule);
			}
			
			for($day=0; $day < 7; $day++){
				if($this->input->post('start_'.$day)){
					$day_start = $this->input->post('start_'.$day);
					$day_end = $this->input->post('end_'.$day);
					$day_temp = $this->input->post('temp_'.$day);

					foreach($day_start as $key => $start_time){
						$rule_schedule = array(
							'rule_id' => $rule_id,
							'day' => $day+1,
							'start' => $start_time,
							'end' => $day_end[$key],
							'temp' => $day_temp[$key]
						);

						$this->rule_model->add_rule_schedule($rule_schedule);
					}
				}
			}

			redirect('index.php/settings');
		}
	}
}
