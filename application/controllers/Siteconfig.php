<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Siteconfig extends MY_Controller {

        public function __construct() {
        	parent::__construct();

            $this->load->library('form_validation');
            $this->load->model('datype_model');
            $this->load->model('datype_address_model', 'datype_address');
            $this->load->model('audittrail_model', 'audit');
            $this->load->model('emailsender_model');

            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            } 

        }

        public function index() {
        	return redirect($this->router->fetch_class().'/datype_address');
        }

        public function datype_address($id = '') {

        	if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
 
            if(!empty($post)) {
                 
                if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                }

                $da_name = $this->datype_model->findOne(array('id' => strip_tags($post['da_type'])));

               if(!empty($id)) {
                   $this->form_validation->set_rules('da_type', 'DA type', 'required');
               } else {

                  $this->form_validation->set_rules('da_type', 'DA type', 'required|is_unique[datype_address.da_type]');
               }
               $this->form_validation->set_rules('address', 'Address', 'required');
               $this->form_validation->set_rules('pan_number', 'PAN number', 'required');
               $this->form_validation->set_rules('ie_code_no', 'I.E code', 'required');
               $this->form_validation->set_rules('cin_number', 'CIN Number', 'required');
               $this->form_validation->set_rules('tin_number', 'TIN number', 'required');
               $this->form_validation->set_rules('gstin', 'GSTIN', 'required');
               $this->form_validation->set_rules('state', 'state', 'required');
               $this->form_validation->set_rules('state_code', 'state code', 'required');
               $this->form_validation->set_rules('state_of_origin', 'state origin', 'required');
               $this->form_validation->set_rules('district_code', 'district code', 'required');
               $this->form_validation->set_rules('district_of_origin', 'district origin', 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
           
               if($this->form_validation->run() == TRUE) {
                    
                    $table_array = array(
                        'da_type'=> strip_tags($post['da_type']),
                        'address'=> $post['address'],
                        'pan_no'=> strip_tags($post['pan_number']),
                        'ie_code_no'=> strip_tags($post['ie_code_no']),
                        'cin_no'=> strip_tags($post['cin_number']),
                        'gstin'=> strip_tags($post['gstin']),
                        'tin_number'=> strip_tags($post['tin_number']),
                        'state'=> strip_tags($post['state']),
                        'state_code'=> strip_tags($post['state_code']),
                        'state_of_origin'=> strip_tags($post['state_of_origin']),
                        'district_code'=> strip_tags($post['district_code']),
                        'district_of_origin'=> strip_tags($post['district_of_origin']),
                    );

                    if(!empty($id)) {
                        $audit_status = 'Address updated for '.$da_name['datype'];
                        $insert = $this->datype_address->update($table_array, array('id' =>$id));
                        $message = 'Address updated successfully to '.$da_name['datype'].'.';
                    } else {

                        $audit_status = 'Address added for '.$da_name['datype'];
                        $insert = $this->datype_address->insert($table_array);
                        $message = 'Address added successfully to '.$da_name['datype'].'.';
                    }
                    if(!empty($insert)) {

                           $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => $audit_status
                         );
                         $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', $message);
                        return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                    } else {
                        $this->session->set_flashdata('error','Unable to process the request. Please try agian later.');
                        return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                    }

               } else {
                 $this->session->set_flashdata('error', 'Validation error. Please check the form.');
               }
            }
            if(!empty($id)) {
                $findOne = $this->datype_address->findOne(array('id' => $id));
                if(!empty($findOne)) {
                      $data['findOne'] = $findOne;
                } else {
                     return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                }
            } 
            
        	$all_addresses = $this->datype_address->findAllAddress();
            $all_da_type = $this->datype_model->findAll();
            $data['address'] = $all_addresses;
        	$data['da_types'] = $all_da_type;

        	$data['pageTitle'] = 'Neclife - Site Config';
            $data['template']  = 'site-config/index';
            $this->load->view('template_admin',$data);

        }

}

