<?php

Class Common extends CI_Model
{
    function getsnmpvalue($host, $oid) {
        $community = $this->config->item('snmp_community');
        $value = snmp2_get($host, $community, $oid);
        if ($value) {
            preg_match('/.*: [\"]*([\d]*)[\"]?/', $value, $result);
            return $result[1];
        } else {
            return "Error";
        }
    }
    
    function check_http($host) {
        $ch = curl_init("http://$host/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt(CURLOPT_CONNECTTIMEOUT, 2);
        if ($kk = curl_exec($ch)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function serverstatus($host) {
        $ch = curl_init("http://$host/server-status");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
        
    }

    
    
    
    function getrequestxsec($host) {
        $ch = curl_init("http://$host/server-status?auto");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = preg_match("/Total Accesses: ([0-9]*).*/", $res, $match);
        $request1 = $match[1];
       
        sleep(2);
        
        $ch = curl_init("http://$host/server-status?auto");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = preg_match("/Total Accesses: ([0-9]*).*/", $res, $match);
        $request2 = $match[1];
        
        
        $request = ($request2 - $request1) / 2;
        
        return $request;
     
    }
}