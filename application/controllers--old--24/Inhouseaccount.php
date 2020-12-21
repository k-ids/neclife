<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Inhouseaccount extends MY_Controller {

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

            $this->load->model('exportgskdaitems_model', 'export_gsk_daitems');
            $this->load->model('exportgskheader_model', 'export_gsk_header');
            $this->load->model('exportgskpacking_model', 'export_gsk_packing');
           
            $this->load->model('payment_model', 'invoice_payment');
            $this->load->model('paymentmapping_model', 'invoice_payment_map');

            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');

            if($this->role != 1 && $this->role != 10) {
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

        }

        /**
        * Call back function to compare the date
        *
        * @return validation response 
        */

         function compareDate() {
          
              $startDate = strtotime($_POST['from_date']);
              $endDate = strtotime($_POST['upto_date']);

              if ($endDate >= $startDate) {
                return true;
              } else {
                $this->form_validation->set_message('compareDate', 'Start date should be less than end date.');
                return false;
              }
        }

        /**
        * Call back function to check unique ecgc on edit.
        *
        * @return validation response 
        */

        function check_unique_ecgc($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->ecgc_model->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_ecgc', 'ECGC option number must be unique.');
                $response = false;
            }
            return $response;
        }

        /**
        * Function to add ECGC options.
        * @param 
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function ecgc($id = '') {

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
               if(!empty($id)) {
                   $this->form_validation->set_rules('ecgc', 'ecgc', 'required|callback_check_unique_ecgc');
               } else {
                  $this->form_validation->set_rules('ecgc', 'ecgc', 'required|is_unique[ecgc.ecgc]');
               }
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $table_array = array(
                        'ecgc'=> strip_tags($post['ecgc']),
                    );

                    if(!empty($id)) {
                        $audit_status = 'updated ECGC --'.strip_tags($post['ecgc']);
                        $insert = $this->ecgc_model->update($table_array, array('id' =>$id));
                        $message = 'ECGC updated successfully!.';
                    } else {
                        $audit_status = 'Added ECGC --'.strip_tags($post['ecgc']);
                        $insert = $this->ecgc_model->insert($table_array);
                        $message = 'ECGC added successfully!.';
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
                $findOne = $this->ecgc_model->findOne(array('id' => $id));
                $data['findOne'] = $findOne;
            }
            
            $findAll = $this->ecgc_model->findAll(null, array('orderby' => 'id'));
            $data['ecgc'] = $findAll;

            $data['pageTitle'] = 'Neclife- In House Account | ECGC';
            $data['template'] = 'in-house-accounts/ecgc';
            $this->load->view('template_admin',$data);
        }


        /**
        * Function to show the Invoice generated DA's.
        * @param 
        * Created On:  01-June-2020
        * Created By:  karan.parihar@ids
        */

        public function payment_receiving() {
          
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
          
            $da_entry_list = $this->invoice_payment->daHavingInvoiceGenerated($where);
            //echo "<pre>"; print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- In House Account | Payment Recieved';
            $data['template']  = 'in-house-accounts/payment-recieving/index';
            $this->load->view('template_admin',$data);

        }


        /**
        * Function to payment history of DA.
        * @param 
        * Created On:  01-June-2020
        * Created By:  karan.parihar@ids
        */
         
        public function history($id ='', $da ='') {

             $findOne = $this->invoice_payment->findOne(array('id' => $id, 'invoice_id' => $da));

            if((empty($id) && empty($da)) ||  empty($findOne)) {
                  $this->session->set_flashdata('warning', 'Unauthorised action.');
                  return redirect( base_url(). $this->router->fetch_class(). '/payment_receiving');
            }

            if($this->session->userdata('error')) {
              $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post) && isset($post['date_form'])) {
              
                $this->form_validation->set_rules('air_billed_date', '' ,'required');
                $this->form_validation->set_rules('days', '' ,'required');
                $this->form_validation->set_rules('due_date', '' ,'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

                if($this->form_validation->run() == TRUE) {
                    
                    $date = date_create($post['due_date']);
                    $due_date = date_format($date,"Y-m-d");

                    $table_array = array (

                        'air_bill_date' => strip_tags(nice_date($post['air_billed_date'], 'Y-m-d')),
                        'due_date' => $due_date,
                        'upto' => strip_tags($post['days'])
                    );

                    $update  = $this->invoice_payment->update($table_array, array('id' =>$id));

                    if(!empty($update)) {
                         $this->session->set_flashdata('success', 'Payment dates updated successfully.');
                         return redirect(base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$id.'/'.$da);
                    } else {
                         $this->session->set_flashdata('error', 'Unable to process ypur request. Please try again later.');
                         return redirect(base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$id.'/'.$da);
                    }
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }
            }

            if(!empty($post) && isset($post['payment_form'])) {
                    
                   $this->form_validation->set_rules('amount_pay', 'Payment recieved', 'required');
                   $this->form_validation->set_rules('payment_remarks', 'Payment remarks', 'required');
                   $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
                   if($this->form_validation->run() == TRUE) {
                     
                     if($post['total_amount'] == $post['bal_amount']) {
                         $balance = $post['total_amount'] - $post['amount_pay'];
                     } else {
                        $balance = $post['bal_amount'] - $post['amount_pay'];
                     }

                     if($balance < 0 ){
                         $this->session->set_flashdata('info', 'Balance not less than zero allowed.');
                         return redirect(base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$id.'/'.$da);
                     }
                    
                      $table_array_map = array(
                         'invoice_pay_id' => $id,
                         'invoice_id' => $da,
                         'total_amount' => $post['total_amount'],
                         'balance_amount' => $balance,
                         'amount_pay' => $post['amount_pay'],
                         'payment_remarks' => $post['payment_remarks'],
                         'date' => date('Y-m-d')
                      );

                      $add = $this->invoice_payment_map->insert($table_array_map );

                      if(!empty($add)) {
                           
                           if($balance == 0) {
                               $status = 2;
                           } else {
                               $status = 1;
                           }

                           $main_table = array(
                               'balance' => $balance,
                               'status' => $status
                            );
                           $this->invoice_payment->update($main_table, array('id' =>$id));

                           $this->session->set_flashdata('success', 'Payment added successfully.');
                           return redirect(base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$id.'/'.$da);
                      } else {
                           $this->session->set_flashdata('error', 'Unable to process ypur request. Please try again later.');
                           return redirect(base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$id.'/'.$da);
                      }

                   } else {
                     $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                   }
            }

            $invoice_payment_map = $this->invoice_payment_map->findAll(array('invoice_pay_id' => $id, 'invoice_id' => $da));
            $data['invoice_payment'] = $findOne;
            $data['invoice_payment_map'] = $invoice_payment_map;

            $data['pageTitle'] = 'Neclife- In House Account | Payment History';
            $data['template']  = 'in-house-accounts/payment-recieving/payment-history';
            $this->load->view('template_admin',$data);
        }



        /**
        * update payement recived option.
        *
        * @return Response
        */

        public function update_payment_recieved($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {
                      
                      $post = $this->input->post();
                      if($this->sessionSelected != $this->currentSession) {
                            $response = array ('error' => 'Unauthorised action.Please check financial year.');
                             echo json_encode($response);die;
                      }

                      if($post['payment_recieved'] =='') {
                         $response = array('error' => 'Please enter payment.');
                         echo json_encode($response);die;
                       }
                       if(is_numeric($post['payment_recieved']) == false) {
                          $response = array('error' => 'Payment value must be integer or decimal');
                           echo json_encode($response);die;
                       }
                      $table_array = array ('payement_recieved' => $post['payment_recieved']);
                      $result = $this->da_header->update($table_array, array('id' =>$id));
                      
                     if(!empty($result)) {
                        
                        $da = $this->da_header->findOne(array('id' =>$id));
                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Payment '.$post['payment_recieved']. 'added for DA--'.$da['da_no']
                         );
                         $this->audit->insert($audit_trial);

                        $response = array ('success' => 'Payment added successfully!');
                    }  else {
                        
                         $response = array ('error' => 'Unable to process request.Please try agian later.');
                    }
                     echo json_encode($response);die;
                } 
            }  
        }

       /**
        * Function In house account MIS.
        * @param 
        * Created On:  26-May-2020
        * Created By:  karan.parihar@ids
        */

        public function mis() {
            
            return redirect(base_url(). $this->router->fetch_class());
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            if($this->session->userdata('info')) {
                $this->session->unset_userdata('info');
            }

            $data = array();
            
            $post = $this->input->post();

            if (!empty($post)  && isset($post)) {
                
                $this->form_validation->set_rules('da_type', '' ,'required');
                $this->form_validation->set_rules('from_date', '' ,'required|callback_compareDate');
                $this->form_validation->set_rules('upto_date', '' ,'required|callback_compareDate');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

                if($this->form_validation->run() == TRUE) {
                    
                    $da_type = $post['da_type'];
                    $from_date = nice_date($post['from_date'],'Y-m-d');
                    $upto_date = nice_date($post['upto_date'] , 'Y-m-d');
                    
                    $result = $this->da_header->get_result($da_type,$from_date,$upto_date);
                    //echo "<pre>";print_r($result);die;
                    if(!empty($result)) {
                        $data['result'] = $result;
                        $data['search'] = array ('from' => $post['from_date'] , 'upto' => $post['upto_date']);
                    } else {
                       $this->session->set_flashdata('info','No result found between respective search dates.');
                    }
                
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }

            }
            $da_type = $this->datype_model->findAll(null, array('orderby' => 'id'));
            $data['da_type'] = $da_type;
            $data['pageTitle'] = 'Neclife- In House Account | MIS';
            $data['template']  = 'in-house-accounts/mis/index';
            $this->load->view('template_admin',$data);
            
        }



        /**
        * Function ecgc check.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function ecgc_check() {
            
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

            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('final_approved' => 1 , 'ecgc_checked_by' => null));
            //echo "<pre>";print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- In House Account | ECGC Check';
            $data['template']  = 'in-house-accounts/ecgc/index';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function da_outstanding_check_form.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function ecgc_check_form($id = '') {
            
            if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direct scropt access allowed.');
                return redirect(base_url().$this->router->fetch_class().'/ecgc_check');
            }
         
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

               if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
                }
               
               $table_array = array(
                   'ecgc_checked_by' => $this->session->userdata()['admin_id'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                      
                      $da = $this->da_header->findOne(array('id' =>$id));
                      $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'ECGC Checked for --'.$da['da_no']
                         );
                        $this->audit->insert($audit_trial);

                    $this->session->set_flashdata('success','DA License checked successfully!');
                    return redirect(base_url().$this->router->fetch_class().'/ecgc_check');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().$this->router->fetch_class().'/ecgc_check');
               }
            }

            $findone  = $this->da_header->findOne(array('id' => $id));

            if(empty($findone) || !empty($findone['ecgc_checked_by'])) {
                 return redirect(base_url().$this->router->fetch_class().'/ecgc_check');
            }
            $data['findOne'] = $findone;
            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- In House Account | ECGC Check Form';
            $data['template']  = 'in-house-accounts/ecgc/form';
            $this->load->view('template_admin',$data);

        }


        public function cron_due_date() {

        }


    }
