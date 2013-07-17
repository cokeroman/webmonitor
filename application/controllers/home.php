<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
            $data = array();
            $data['pools'] = $this->config->item('pools');
            
            
            $this->load->view('header');
            $this->load->view('menu', $data);                
            $this->load->view('home', $data);
            $this->load->view('footer');
	}
        
        
}

