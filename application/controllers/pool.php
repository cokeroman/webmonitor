<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pool extends CI_Controller {

	public function index()
	{
            $data = array();
            $data['pools'] = $this->config->item('pools');
            
            
            $this->load->view('header');
            $this->load->view('menu', $data);                
            $this->load->view('pool', $data);
            $this->load->view('footer');
	}
        
        public function status($pool) {
            $data = array();
            $data['pools'] = $this->config->item('pools');
            $data['pool'] = $pool;
             
            $this->load->view('header');
            $this->load->view('menu', $data);                
            $this->load->view('pool', $data);
            $this->load->view('footer');
            
        }
        
        
}

