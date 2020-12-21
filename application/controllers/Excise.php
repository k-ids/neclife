<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Excise extends MY_Controller {

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

            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 17) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            } 
            
        }

        /**
        * Function index for da listing.
        * @param 
        * Created On:  05-june-2020
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
          
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0));

            //echo "<pre>"; print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Excise Invoice Entry';
            $data['template']  = 'excise/index';
            $this->load->view('template_admin',$data);
        }


        /**
        * Function index for da listing.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */


        public function invoice_entry($id = '') {

            if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class());
            }


            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)  && $this->input->is_ajax_request()) {
              
                if($post['invoice_number'] =='' || $post['areone'] =='') {
                     $response = array('error' => 'Please enter Excise invoice number & Are-I number.');
                     echo json_encode($response);die;
                }

                $checkInvoiceNumber = $this->da_items->checkUniqueExciseNumber($post);
                if($checkInvoiceNumber == 1) {
                    $response  = array('error'=> 'Inovie Number must be unique.');
                    echo json_encode($response);die;
                }
 
                $table_array = array(
                       'excise_invoice_no' => strip_tags($post['invoice_number']),
                       'areone' => strip_tags($post['areone']),
                );
               $update = $this->da_items->update($table_array, array('id' => $post['id']));
               if(!empty($update)) {
                   $da = $this->da_items->findOne(array('id' =>$post['id']));
                   $audit_trial = array(
                                        'transaction_date' => date('Y-m-d'),
                                        'transaction_time' => date("H:i:s"),
                                        'username' => $this->session->userdata()['username'],
                                        'action' => 'Excise '.strip_tags($post['invoice_number']).' and are-1 '.strip_tags($post['areone']).' added for '.$da['da_no'],
                                    );
                    $this->audit->insert($audit_trial);
                    $response = array ('success' => 'Excise invoice entry added successfully!.');
                } else {
                    $response = array ('error' => 'Unable to update the despatch date');
                }
                  echo json_encode($response);die;
               
            }
            
            $findone  = $this->da_header->findOne(array('id' =>$id));
            $data['findone'] = $findone;
            if(empty($findone) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
                 return redirect(base_url().$this->router->fetch_class());
            }
            $da_items = $this->da_items->findDAItems(array('da_no'=> $id), array('orderby' => 'id'));
            $data['da_items'] = $da_items;
            
            $data['pageTitle'] = 'Neclife- Excise Invoice Entry | Form';
            $data['template']  = 'excise/excise-entry-form';
            $this->load->view('template_admin',$data);
        }

    }