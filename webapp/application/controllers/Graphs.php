<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graphs extends CI_Controller {
	public function index(){
        $data['page'] = 'graphs';
        
        $data['js_files'] = array('graphs.js');
		
		$content_data = array();

		$data['content'] = $this->load->view('graphs', $content_data, TRUE);

		$this->load->view('template', $data);
	}

	public function save_settings(){
		
	}
}
