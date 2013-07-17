<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
            header("Location: /");
	}
        
        
        public function status($host)
        {
            $data = array();
            $data['pools'] = $this->config->item('pools');
            $data['host'] = $host;
            $this->load->view('header', $data);
            $this->load->view('menu', $data);                
            $this->load->view('report', $data);
            $this->load->view('footer');
        }
        
        public function info($host, $check, $type)
        {
            $this->load->model('common');
            $data = array();
            if ($check == 'load') {
                if ($type == 'ext'){
                     $data['titulo'] = 'Load'; 
                }
               
                $data['value'] = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.10.1.3.1');
            }
            if ($check == 'memory') {
                if ($type == 'ext'){
                    $data['titulo'] = 'Memory';
                }
                $total = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.4.5.0');
                $free = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.4.6.0');
                $cached = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.4.15.0');
                $buffered = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.4.14.0');
                $used = $total - ($free + $buffered + $host);
                $percent = ($used*100)/$total;
                $percent = number_format($percent, 0);
                $data['value'] = $percent . "%";
            }
            if ($check == 'cpu') {
                if ($type == 'ext'){
                    $data['titulo'] = 'CPU (User|System|Idle)';
                }
                $cpu_user = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.11.9.0');
                $cpu_system = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.11.10.0');
                $cpu_idle = $this->common->getsnmpvalue($hots,'.1.3.6.1.4.1.2021.11.11.0');
                $data['value'] = "$cpu_user" . "|" . "$cpu_system" . "|" . "$cpu_idle";
                
            }
            if ($check == 'http_status') {
                if ($type == 'ext'){
                    $data['titulo'] = 'HTTP Status';
                }
                $check_http = $this->common->check_http($host);
                if ($check_http) {
                    $data['value'] = '<font color="green">OK</font>';
                } else {
                   $data['value'] = '<font color="red">KO</font>'; 
                }
            }
            $this->load->view('info', $data);
        }
        
        function table($table, $host) 
        {
            $this->load->model('common');

            if ($table == 'top_urls') {
                $data['titulo'] = "Server Status";
                $data['content'] = $this->common->serverstatus($host);
            }

            
            $this->load->view('tabla_report', $data);
            
            
        }
        
        function graph($host, $pool) {
            $data = array();
            $data['host'] = $host;
            $data['pools'] = $this->config->item('pools');
            $data['pool'] = $pool;
            $this->load->view('graph_all_request', $data);         
        }
        
        function graphpool() {
            $data = array();
            $data['pools'] = $this->config->item('pools');
            $this->load->view('graph_all_request_pool', $data);         
        }        
        
        function graph_host($host) {
            $data = array();
            $data['host'] = $host;
            $this->load->view('graph_request', $data);         
        }
        
        function updategraph($host) {
            $this->load->model('common');
            $data = array();
            $data['host'] = $host;

            echo $this->common->getrequestxsec($host);
           
            
        }     
        
        function updategraphpool($pool) {
            $this->load->model('common');
            $data = array();
            $pools = $this->config->item('pools');
            $total_req = 0;
            foreach ($pools[$pool] as $host) {
                $request =  $this->common->getrequestxsec($host); 
                $total_req = $total_req + $request;
            }
            
            echo number_format($total_req, 0);
        }         

        public function infopool($pool, $check)
        {
            $this->load->model('common');
            $data = array();
            $pools = $this->config->item('pools');

            if ($check == 'load') {           
                $total_load = 0;
                foreach ($pools[$pool] as $host) {
                    $load = $this->common->getsnmpvalue($host,'.1.3.6.1.4.1.2021.10.1.3.1');
                    $total_load = $total_load + $load;
                }
                $data['value'] = number_format($total_load / count($pools), 2);
             }

            if ($check == 'http_status') {
                $error = 0;
                foreach ($pools[$pool] as $host) {
                    $check_http = $this->common->check_http($host);
                    if ($check_http == FALSE) {
                        $error += 1;
                    }
                }
                if ($error == 0) {
                    $data['value'] = '<font color="green">OK</font>';
                } elseif (($error >= 1) || ($error <= 2)) {
                   $data['value'] = '<font color="yellow">Warning ('. $error . 'server down)</font>'; 
                } else {
                   $data['value'] = '<font color="red">KO'. $error .'server down)</font>'; 
                }
            }
            $this->load->view('info', $data);
        }        
        
}


