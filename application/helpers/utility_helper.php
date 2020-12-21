<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function getFinancialYears($model = ''){
    
    $CI = get_instance();
    $CI->load->model($model);
    $data = $CI->$model->findAll(null, array('orderby' => 'id'));
    return $data;
}

function getName( $id =''){
    
    $model = 'party_model';
    $CI = get_instance();
    $CI->load->model($model);
    $data = $CI->$model->findOne(array('id'=> $id));
    if(!empty($data)) {
    	return $data;
    } else {
    	return FALSE;
    }
}
function getUserName( $id =''){
    
    $model = 'admin_model';
    $CI = get_instance();
    $CI->load->model($model);
    $data = $CI->$model->findOne(array('id'=> $id));
    if(!empty($data)) {
        return $data['username'];
    } else {
        return FALSE;
    }
}

function getSignature($id) {
    $model = 'admin_model';
    $CI = get_instance();
    $CI->load->model($model);
    $data = $CI->$model->findOne(array('id'=> $id));
    if(!empty($data)) {
        return $data;
    } else {
        return FALSE;
    }
}

function checked($da_id = '', $document = '') {

    if(!empty($da_id) &&  !empty($document)) {

        $model = 'dadocuments_model';
        $CI = get_instance();
        $CI->load->model($model);
        $data = $CI->$model->findAll(array('da_no'=> $da_id, 'documents_required'=> $document));
        if(!empty($data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
  }

function selectedLicense($da_no ='', $id ='') {
      
        $model = 'invoiceheader_model';
        $CI = get_instance();
        $CI->load->model($model);
        $data = $CI->$model->findOne(array('da_no'=> $da_no));
        if(!empty($data)) {
           $explode = explode(',', $data['ad_lic_no']);
           $check_in_array  = in_array($id, $explode);
           if($check_in_array) {
              return 'checked';
           } else {
             return false;
           }
            
        } else {
            return FALSE;
        }
}

   function disabled($da_no ='', $id ='') {
      
        $model = 'invoiceheader_model';
        $CI = get_instance();
        $CI->load->model($model);
        $data = $CI->$model->findOne(array('da_no'=> $da_no));
        if(!empty($data)) {
           $explode = explode(',', $data['ad_lic_no']);
           $check_in_array  = in_array($id, $explode);
           if($check_in_array) {
              return '';
           } else {
             return 'disabled';
           }
            
        } else {
            return FALSE;
        }
    }


   function lic_quantity($da_no ='', $id ='', $invoice_no ='') {
      
        $model = 'invoicelicqty_model';
        $CI = get_instance();
        $CI->load->model($model);
        $data = $CI->$model->findOne(array('da_no'=> $da_no, 'product'=> $id ,'invoice_no' => $invoice_no));
        if(!empty($data)) {
           return $data['lic_qty'];
        } else {
            return FALSE;
        }
    }

function convert_number($number) {

           if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) {
            $result .= (empty($result) ? "" : " ") .convert_number($kilo) . " Thousand";
        }
        if ($hecto) {
            $result .= (empty($result) ? "" : " ") .convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) {
                $result .= " and ";
            }
            if ($deca < 2) {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) {
            $result = "zero";
        }
        return $result;
    }

