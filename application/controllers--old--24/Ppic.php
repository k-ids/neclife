<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Ppic extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model(array('admin_model', 'datype_model','department_model'));
            $this->load->model('Userrole_model', 'role');
            $this->load->model('Audittrail_model', 'audit');
            $this->load->model('financialyear_model','financial_year');
            $this->load->model('admin_model');
            $this->load->model('ecgc_model');

            $this->load->model('daheader_model', 'da_header');
            $this->load->model('daitems_model', 'da_items');
            $this->load->model('dadocuments_model', 'da_document');
            $this->load->model('party_model', 'party');
            $this->load->model('department_model', 'department');
            $this->load->model('emailsender_model');
            $this->load->model('plantpackinglist_model', 'packing_list');

            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->daType = $this->session->userdata('datype');
            $this->department = $this->session->userdata('dept');

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 13) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            } 
            
        }

        /**
        * Function to add ECGC options.
        * @param 
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function index() {
            
            if($this->session->userdata('error')) {
              $this->session->unset_userdata('error');
            }

            $data = array();

            $post = $this->input->post();

            if(!empty($post)) {
                 $where = $post['buyer'];
            }  else {
               $where = null;
            }

            if($this->session->userdata('admin_id') != '1') {

                 $where = array('type' => 0, 'daheader.da_type' => $this->daType , 'daheader.department' => NULL);
                 
             } else {
                 $where = array('type' => 0, 'daheader.department' => NULL);
             }
             $da_entry_list = $this->da_header->getAllDAForPPIC($where);
             //echo "<pre>"; print_r($da_entry_list);die;
            
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- PPIC | DA Assign';
            $data['template']  = 'in-house-accounts/ppic/index';
            $this->load->view('template_admin',$data);
        }

        /**
        * update ECGC option.
        *
        * @return Response
        */

        public function assign_da($id = '') { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {
                        
                        if($this->sessionSelected != $this->currentSession) {
                            $response = array ('error' => 'Unauthorised action.Please check financial year.');
                             echo json_encode($response);die;
                        }
                      $post = $this->input->post();
                      $table_array = array ('department' => $post['block']);
                      $result = $this->da_header->update($table_array, array('id' =>$id));
                      $result1 = $this->packing_list->update($table_array, array('da_no' =>$id));
                      
                     if(!empty($result) && !empty($result1)) {
                        
                        $da = $this->da_header->findOne(array('id' =>$id));
                        $audit_trial = array(
                                'transaction_date' => date('Y-m-d'),
                                'transaction_time' => date("H:i:s"),
                                'username' => $this->session->userdata()['admin_id'],
                                'action' => 'Production Block added'.$post['block'].'added for'.$da['da_no'],
                            );
                        $this->audit->insert($audit_trial);

                        $response = array ('success' => 'Production Block added successfully!');
                    }  else {
                        
                         $response = array ('error' => 'Unable to process request.Please try agian later.');
                    }
                     echo json_encode($response);die;
                } 
            }  
        }


        /**
        * Function to add ECGC options.
        * @param 
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function reassign_da() {
            
            if($this->session->userdata('error')) {
              $this->session->unset_userdata('error');
            }

            $data = array();

            $post = $this->input->post();

            if(!empty($post)) {
                 $where = $post['buyer'];
            }  else {
               $where = null;
            }

             if($this->session->userdata('admin_id') != '1') {
                 $where = array('type' => 0, 'daheader.da_type !=' => $this->daType , 'daheader.department !=' => NULL);
                 
             } else {
                 $where = array('type' => 0, 'daheader.department !=' => NULL);
             }
             $da_entry_list = $this->da_header->getAllDAForPPIC($where);
             //echo "<pre>"; print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- PPIC | DA Assign';
            $data['template']  = 'in-house-accounts/ppic/re-assign-da';
            $this->load->view('template_admin',$data);
        }

    }