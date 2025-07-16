<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weather extends CI_Controller {
	public function index(){
        $data['page'] = 'weather';
        
        $data['js_files'] = array('weather.js');
		
		$content_data = array();

		$data['content'] = $this->load->view('weather', $content_data, TRUE);

		$this->load->view('template', $data);
	}

	public function save_settings(){
		
	}
}
