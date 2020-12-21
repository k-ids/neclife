<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class License extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model('Advance_model', 'advance');
            $this->load->model('Epgc_model', 'epgc');
            $this->load->model('declaration_model', 'declaration');
            $this->load->model('audittrail_model', 'audit');
            $this->load->model('daheader_model', 'da_header');
            $this->load->model('daitems_model', 'da_items');
            $this->load->model('dadocuments_model', 'da_document');
            $this->load->model('party_model', 'party');
            $this->load->model('department_model', 'department');
            $this->load->model('documentsrequired_model', 'document_required');
            $this->load->model('datype_model');
            $this->load->model('product_model', 'product');
            $this->load->model('admin_model');
            $this->load->model('emailsender_model');
            $this->load->model('invoiceheader_model', 'invoiceheader');

            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 9) {
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
          
              $startDate = strtotime($_POST['license_date']);
              $endDate = strtotime($_POST['expiry_date']);

              if ($endDate >= $startDate) {
                return true;
              } else {
                $this->form_validation->set_message('compareDate', 'License date should be less than expiry date.');
                return false;
              }
        }

        /**
        * Call back function to check unique lic no field on edit.
        *
        * @return validation response 
        */

        function check_unique_lic_no($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->advance->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_lic_no', 'License number already in use.');
                $response = false;
            }
            return $response;
        }

        /**
        * Function to manage Adavnce license.
        * @param 
        * Created On:  04-June-2020
        * Created By:  karan.parihar@ids
        */

        public function advance_license($id = '') {

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
                   $this->form_validation->set_rules('license_no', 'license number', 'required|callback_check_unique_lic_no');
               } else {
                  $this->form_validation->set_rules('license_no', 'license number', 'required|is_unique[advance.lic_no]');
               }

               $this->form_validation->set_rules('license_date', 'license date', 'required|callback_compareDate');
               $this->form_validation->set_rules('qty', 'quantity', 'required');
               $this->form_validation->set_rules('product', 'product', 'required');
               $this->form_validation->set_rules('da_type_lic', 'DA type', 'required');
               $this->form_validation->set_rules('remarks', 'remark', 'required');
               $this->form_validation->set_rules('expiry_date', 'expiry date', 'required|callback_compareDate');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $table_array = array(
                        'lic_no'=> strip_tags($post['license_no']),
                        'lic_date'=> strip_tags(nice_date( $post['license_date'], 'Y-m-d') ),
                        'qty'=> strip_tags($post['qty']),
                        'da_type' => strip_tags($post['da_type_lic']),
                        'product' => strip_tags($post['product']),
                        'remarks' => strip_tags($post['remarks']),
                        'expiry_date'=> strip_tags(nice_date( $post['expiry_date'], 'Y-m-d')),
                        'automatice_extended_eo'=> strip_tags(nice_date( $post['automatice_extended_eo'], 'Y-m-d'))
                    );
                    if(!empty($id)) {
                         $audit_status = 'Updated Advance License --'.strip_tags($post['license_no']);
                        $insert = $this->advance->update($table_array, array('id' =>$id));
                        $message = 'Advance License updated successfully!.';
                    } else {
                        $audit_status = 'Add Advance License --'.strip_tags($post['license_no']);
                        $insert = $this->advance->insert($table_array);
                        $message = 'Advance License added successfully!.';
                    }
                    if(!empty($insert)) {

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => $audit_status
                         );
                        $this->audit->insert($audit_trial);

                        $role = $this->admin_model->findAll(array('admin_group' => 1));
                        if(!empty($role)) {
                            $userdata = array();
                            foreach ($role as $key => $value) {
                                 $userdata[$key]['name'] = $value['first_name'].' '.$value['last_name'];
                                 $userdata[$key]['email'] = $value['email'];
                            }
                            if(!empty($userdata)) {
                                foreach($userdata as $key => $value) {
                                $data['username'] = $value['name'];
                                $data['message'] = 'Advance license number added successfully with quantity "'.strip_tags($post['qty']).'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife Advance Licnese Number', $message);
                               }
                            }
                         }


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
                $findOne = $this->advance->findOne(array('id' => $id));
                $products = $this->product->findAll(array('datype' => $findOne['da_type']), array('orderby' => 'product','order' => 'ASC'));
                $data['findOne'] = $findOne;
                $data['products'] = $products;
            }
            $advance_license = $this->advance->getAll();
            $da_types = $this->datype_model->findAll(null, array('orderby' => 'id'));
           
            $data['advance_license'] = $advance_license;
            $data['da_types'] = $da_types;
               
            $data['pageTitle'] = 'Neclife- License | Advance License';
            $data['template']  = 'license/advance_license';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function to Adavnce license usage.
        * @param $id
        * Created On:  09-July-2020
        * Created By:  karan.parihar@ids
        */

        public function license_usage($id = '') {
           
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            if(empty($id)) {
              $this->session->set_flashdata('warning', 'No direct script access allowed.');
              return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
            }
    
            $data = array();
            $post = $this->input->post();
            $license = $this->advance->findLicense($id);
            $license_usage = $this->invoiceheader->license_usage($id);
            
            $data['license'] = $license;
            $data['pageTitle'] = 'Neclife- License | Advance License Usage';
            $data['template']  = 'license/advance-license-usage';
            $this->load->view('template_admin',$data);
           
         }

        /**
        * Call back function to check unique lic no field on edit.
        *
        * @return validation response 
        */

        function check_unique_lic_no1($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->epgc->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_lic_no1', 'EPGC License number must be unique.');
                $response = false;
            }
            return $response;
        }

        /**
        * Function to manage EPGC.
        * @param 
        * Created On:  04-june-2020
        * Created By:  karan.parihar@ids
        */

        public function epgc($id = '') {

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
                   $this->form_validation->set_rules('license_no', 'license number', 'required|callback_check_unique_lic_no1');
               } else {
                  $this->form_validation->set_rules('license_no', 'license number', 'required|is_unique[epgc.lic_no]');
               }

               $this->form_validation->set_rules('license_date', 'license date', 'required|callback_compareDate');
               $this->form_validation->set_rules('qty', 'quantity', 'required');
               $this->form_validation->set_rules('expiry_date', 'expiry date', 'required|callback_compareDate');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $table_array = array(

                        'lic_no'=> strip_tags($post['license_no']),
                        'lic_date'=> strip_tags( nice_date( $post['license_date'], 'Y-m-d') ),
                        'qty'=> strip_tags($post['qty']),
                        'expiry_date'=> strip_tags( nice_date( $post['expiry_date'], 'Y-m-d'))
                    );
                    if(!empty($id)) {
                        $audit_status = 'Updated EPGC License --'.strip_tags($post['license_no']);
                        $insert = $this->epgc->update($table_array, array('id' =>$id));
                        $message = 'EPGC License updated successfully!.';
                    } else {
                        $audit_status = 'EPGC License --'.strip_tags($post['license_no']);
                        $insert = $this->epgc->insert($table_array);
                        $message = 'Added EPGC License added successfully!.';
                    }
                    if(!empty($insert)) {

                           $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => $audit_status
                         );
                        $this->audit->insert($audit_trial);

                        $role = $this->admin_model->findAll(array('admin_group' => 1));
                        if(!empty($role)) {
                            $userdata = array();
                            foreach ($role as $key => $value) {
                                 $userdata[$key]['name'] = $value['first_name'].' '.$value['last_name'];
                                 $userdata[$key]['email'] = $value['email'];
                            }
                            if(!empty($userdata)) {
                                foreach($userdata as $key => $value) {
                                $data['username'] = $value['name'];
                                $data['message'] = 'EPCG license number added successfully with quantity "'.strip_tags($post['qty']).'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife EPCG License', $message);
                               }
                            }
                         }

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
                $findOne = $this->epgc->findOne(array('id' => $id));
                $data['findOne'] = $findOne;
            }
            
            $epgc = $this->epgc->findAll(null, array('orderby' => 'id'));
            $data['epgc'] = $epgc;
            
            $data['pageTitle'] = 'Neclife- License | EPGC';
            $data['template']  = 'license/epgc';
            $this->load->view('template_admin',$data);

        }

        /**
        * Call back function to check unique lic no field on edit.
        *
        * @return validation response 
        */

        function check_unique_declaration($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->declaration->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_declaration', 'Declaration number must be unique.');
                $response = false;
            }
            return $response;
        }
        
        /**
        * Function to declaration.
        * @param 
        * Created On:  04-june-2020
        * Created By:  karan.parihar@ids
        */

        public function declaration($id = '') {

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
                   $this->form_validation->set_rules('declaration', 'declaration', 'required|callback_check_unique_declaration');
               } else {
                  $this->form_validation->set_rules('declaration', 'declaration', 'required|is_unique[declaration.declaration]');
               }
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $table_array = array(
                        'declaration'=> strip_tags($post['declaration']),
                    );

                    if(!empty($id)) {
                        $audit_status = 'Updated Declaration--'.strip_tags($post['declaration']);
                        $insert = $this->declaration->update($table_array, array('id' =>$id));
                        $message = 'Declaration updated successfully!.';
                    } else {
                        $audit_status = 'Added Declaration'.strip_tags($post['declaration']);
                        $insert = $this->declaration->insert($table_array);
                        $message = 'Declaration added successfully!.';
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
                $findOne = $this->declaration->findOne(array('id' => $id));
                $data['findOne'] = $findOne;
            }

            $declaration = $this->declaration->findAll(null, array('orderby' => 'id'));
            $data['declaration'] = $declaration;
            
            $data['pageTitle'] = 'Neclife- License | Declaration';
            $data['template']  = 'license/declaration';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function to advance_license_consumption.
        * @param 
        * Created On:  04-june-2020
        * Created By:  karan.parihar@ids
        */

        public function advance_license_consumption() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {
               
               $this->form_validation->set_rules('license_no', 'license number', 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $post = strip_tags($post['license_no']);
                    $result = $this->advance->getResult( $post);

                    if(!empty($result)) {
                        $data['result'] = $result;
                        $data['search'] = array ('license_no' => $result[0]['lic_no']);
                    } else {
                        $this->session->set_flashdata('info','No result found between.');
                    }

               } else {
                 $this->session->set_flashdata('error', 'Validation error. Please check the form.');
               }
            }
            
            $license_no = $this->advance->findAll(null, array('orderby' => 'id'));
            $data['advance_license'] = $license_no;
            
            $data['pageTitle'] = 'Neclife- License | Advance License Consumption';
            $data['template']  = 'license/advance-license-consumption';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function to epgc_license_consumption.
        * @param 
        * Created On:  04-june-2020
        * Created By:  karan.parihar@ids
        */

        public function epgc_license_consumption() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {
               
               $this->form_validation->set_rules('epgc_no', 'epgc', 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
               if($this->form_validation->run() == TRUE) {
                    
                    $post = strip_tags($post['epgc_no']);
                    $result = $this->epgc->getResult( $post);
                    
                    if(!empty($result)) {
                        $data['result'] = $result;
                        $data['search'] = array ('epgc' => $result[0]['lic_no']);
                    } else {
                        $this->session->set_flashdata('info','No result found between.');
                    }

               } else {
                 $this->session->set_flashdata('error', 'Validation error. Please check the form.');
               }
            }
            
            $epgc = $this->epgc->findAll(null, array('orderby' => 'id'));
            $data['epgc_license'] = $epgc;
            
            $data['pageTitle'] = 'Neclife- License | EPGC License Consumption';
            $data['template']  = 'license/epgc-license-consumption';
            $this->load->view('template_admin',$data);

        }


        /**
        * Function da_license_check.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_license_check() {
            
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

            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('final_approved' => 1 , 'license_check_by' => null));
            //echo "<pre>";print_r($this->db->last_query());die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- License | DA License Check';

            $data['template']  = 'license/da-license-check';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function da_outstanding_check_form.
        * @param 
        * Created On:  05-june-2020
        * Created By:  karan.parihar@ids
        */

        public function da_license_check_form($id = '') {

            if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direact script access allowed.');
                return redirect(base_url().$this->router->fetch_class().'/da_license_check');
            }
      
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

               if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/da_license_check/'.$id);
               }
               
               $table_array = array(
                   'license_checked' => 1,
                   'license_check_by' => $this->session->userdata()['admin_id'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                        
                        $da = $this->da_header->findOne(array('id'=> $id));
                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'License checked for DA--'.$da['da_no']
                         );
                        $this->audit->insert($audit_trial);

                        $role = $this->admin_model->findAll(array('admin_group' => 1));
                        $type = $this->datype_model->findOne($da['da_type']);
                        if(!empty($role)) {
                            $userdata = array();
                            foreach ($role as $key => $value) {
                                 $userdata[$key]['name'] = $value['first_name'].' '.$value['last_name'];
                                 $userdata[$key]['email'] = $value['email'];
                            }
                            if(!empty($userdata)) {
                                foreach($userdata as $key => $value) {
                                $data['username'] = $value['name'];
                                $data['message'] = 'A DA Entry "'.$da['da_no'].' of "'.$da['da_type'].'" has been successfully licnesed checked.';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife DA Entry', $message);
                               }
                            }
                         }

                    $this->session->set_flashdata('success','DA License checked successfully!');
                    return redirect(base_url().'license/da_license_check');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'license/da_license_check');
               }
            }

            $findone  = $this->da_header->findOne(array('id' => $id));

            if(empty($findone) || !empty($findone['license_check_by'])) {
                 return redirect(base_url().'license/da_license_check');
            }
            $data['findOne'] = $findone;
            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            $data['pageTitle'] = 'Neclife- License | DA License Check Form';
            $data['template']  = 'license/da-license-check-form';
            $this->load->view('template_admin',$data);

        }

        /**
        * Manage product license number  ajax request.
        *
        * @return Response
        */

        public function get_product_license($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->advance->findOne(array('product'=> $id));
                     if(!empty($result)) {
                        $response = array ('success' => $result);
                    }  else {
                        
                         $response = array ('error' => 'true');
                    }
                     echo json_encode($response);die;
                } 
            }  
        }


        /**
        * Function license usage pdf  to download the license usage copy.
        * @param $id
        * Created On:  11-July-2020
        * Created By:  karan.parihar@ids
        */

        public function license_pdf($id = '') {

            $mpdf = new \Mpdf\Mpdf(['format' => [300, 400]]);
            
            $data = array();
            $post = $this->input->post();
            $license = $this->advance->findLicense($id);
            
            $data['license'] = $license;
            $html = $this->load->view('license/advance-license-usage', $data, true);

            $mpdf->WriteHTML($html);
            $filename = 'License No '.$license['lic_no']. '.pdf';
            $mpdf->Output($filename, 'D'); 
        }
        
        /**
        * Cron advance license to notify license users.
        * @param $id
        * Created On:  10-Aug-2020
        * Created By:  karan.parihar@ids
        */

        public function cron_advance_license() {
           
           $license = array();
           $license = $this->advance->findAll();
           if(!empty($license)) {

              foreach ($license as $key => $value) {
                $var1 = $value['qty'];
                $var2 = $value['eo_fulfilled'];
                $difference = abs($var1 - $var2);
                if($difference < 10) {
                   
                  /**** license consumption notification email **/
                    $role = $this->admin_model->findAll(array('admin_group' => 9));

                    if(!empty($role)) {
                            $userdata = array();
                            foreach ($role as $roleKey => $roleValue) {
                               
                                 $userdata[$roleKey]['name'] = $roleValue['first_name'].' '.$value['last_name'];
                                 $userdata[$roleKey]['email'] = $roleValue['email'];

                            }
                            if(!empty($userdata)) {
                              
                                foreach($userdata as $userKey => $userValue) {
                               
                                $data['username'] = $userValue['name'];

                                $data['message'] = 'A License number '.$value['lic_no'].' has about to be fullfilled whole quantity.';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($userValue['email'], 'Neclife DA Entry', $message);
                                echo "email sent";
                               }
                            }
                        }
                  } else {

                }
              }
         }
      }
}