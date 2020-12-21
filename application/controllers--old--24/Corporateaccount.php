<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Corporateaccount extends MY_Controller {

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
            $this->load->model('documentsrequired_model', 'document_required');
            $this->load->model('emailsender_model');
            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 11 && $this->role != 12) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            } 
            
        }

        /**
        * Function index.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function index() {

        }

        /**
        * Function da_outstanding_check.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_outstanding_check() {

            if($this->role != 1 && $this->role != 11) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            }

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
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array( 'license_checked'=> 1, 'outstanding_check_by' => null));
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Corporate Account | DA Out-Standing Check';
            $data['template']  = 'corporate-accounts/outstanding-check';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function da_outstanding_check_form.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_outstanding_check_form($id = '') {

            if($this->role != 1 && $this->role != 11) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            }
            
            if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().'corporateaccount/da_outstanding_check');
            }
   
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

              if($this->sessionSelected != $this->currentSession) {
                  $this->session->set_flashdata('session-mismatch','session-mismatch');
                  return redirect(base_url().'corporateaccount/da_outstanding_check/'.$id);
               }
               
               $table_array = array(
                   'outstanding_checked' => 1,
                   'outstanding_check_by' => $this->session->userdata()['admin_id'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {

                      $da = $this->da_header->findOne(array('id' =>$id));
                      $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'outstanding checked for --'.$da['da_no']
                         );
                        $this->audit->insert($audit_trial);

                    $this->session->set_flashdata('success','DA outstanding checked and successfully sent for the account approval!');
                    return redirect(base_url().'corporateaccount/da_outstanding_check');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'corporateaccount/da_outstanding_check');
               }
            }

            $findone  = $this->da_header->findOne(array('id' => $id));

            if(empty($findone) || !empty($findone['outstanding_check_by'])|| ( ($this->session->userdata('department') != $findone['department'])  && ($this->session->userdata('admin_id') != '1') ) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
                 return redirect(base_url().'corporateaccount/da_outstanding_check');
            }
            $data['findOne'] = $findone;
            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Corporate Account | DA Out-Standing Check Form';
            $data['template']  = 'corporate-accounts/outstanding-check-form';
            $this->load->view('template_admin',$data);

        }


        /**
        * Function da_account_approve.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_account_approve() {

            if($this->role != 1 && $this->role != 12 ) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            }
            
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

            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('account_approved' => 0  ,'outstanding_checked' => 1));
            //echo "<pre>";print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Corporate Account | DA Account Approve';
            $data['template']  = 'corporate-accounts/account-approve';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function da_outstanding_check_form.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_account_approve_form($id = '') {

           if($this->role != 1  && $this->role != 12) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            }

            if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().'corporateaccount/da_outstanding_check');
            }
            

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

                if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().'corporateaccount/da_account_approve/'.$id);
                 }
               
               $table_array = array(
                   'account_approved' => 1,
                   'accounts_approved_by' => $this->session->userdata()['admin_id'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {

                    $da = $this->da_header->findOne(array('id' =>$id));
                      $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'DA Account Approve for --'.$da['da_no']
                         );
                        $this->audit->insert($audit_trial);

                    $this->session->set_flashdata('success','DA Account approved successfully!');
                    return redirect(base_url().'corporateaccount/da_account_approve');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'corporateaccount/da_account_approve');
               }
            }

            $findone  = $this->da_header->findOne(array('id' => $id));

            if(empty($findone) || !empty($findone['accounts_approved_by']) || ( ($this->session->userdata('department') != $findone['department'])  && ($this->session->userdata('admin_id') != '1') ) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
                 return redirect(base_url().'corporateaccount/da_account_approve');
            }
            $data['findOne'] = $findone;
            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Corporate Account | DA Account Approve Form';
            $data['template']  = 'corporate-accounts/account-approve-form';
            $this->load->view('template_admin',$data);

        }
    }