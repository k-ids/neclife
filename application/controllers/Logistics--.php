f<?php

    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Logistics extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model(array('user_model', 'datype_model','department_model'));
            $this->load->model('userrole_model', 'role');
            $this->load->model('audittrail_model', 'audit');
            $this->load->model('financialyear_model','financial_year');
            $this->load->model('label_model', 'label');
            $this->load->model('country_model', 'country');
            $this->load->model('currency_model', 'currency');
            $this->load->model('paymentterms_model', 'payment_terms');
            $this->load->model('shipmentmode_model', 'shipment_mode');
            $this->load->model('agent_model', 'agent');
            $this->load->model('party_model', 'party');
            $this->load->model('declaration_model', 'declaration');
            $this->load->model('despatch_model', 'despatch');
            $this->load->model('transportmode_model', 'transport_mode');
            $this->load->model('declaration_model' , 'declaration');
            $this->load->model('productform_model', 'product_form');
            $this->load->model('productgrade_model', 'product_grade');
            $this->load->model('product_model', 'product');
            $this->load->model('packagestype_model', 'packages');
            $this->load->model('daheader_model', 'da_header');
            $this->load->model('daitems_model', 'da_items');
            $this->load->model('dadocuments_model', 'da_document');
            $this->load->model('deliveryterms_model', 'delivery_term');
            $this->load->model('daoutstanding_model', 'outstanding');
            $this->load->model('daattachement_model', 'attachement');
            $this->load->model('packinglist_model', 'packing_list');
            $this->load->model('documentsrequired_model', 'document_required');
            
            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();
        }


        /**
        * Function logistics index.
        * @param 
        * Created On:  18-May-2020
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
        
          $da_entry_list = $this->da_header->get_all_da_entry($where, array('type'=> 0));
          //echo "<pre>";print_r($this->db->last_query());die;

          $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
          $data['da_entry'] = $da_entry_list;

          $data['pageTitle'] = 'Neclife- Logistics | DA Entry';
          $data['template']  = 'logistics/index';
          $this->load->view('template_admin',$data);

        }

        /**
        * Function logistics da_entry.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_entry() {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
    

            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

                $first_letter = $this->datype_model->findone($post['datype']);
                $da_number = 'DA-'.date('Y').'-'.random_string('numeric', 5);
                define('DA_NUM' , $da_number);

                if(!empty($post['document'])) { 
                   $this->form_validation->set_rules('document[]', 'document' , 'required');
                }
                if(!empty($post['approve_preshipment'])) {
                    $this->form_validation->set_rules('quantity_1', 'quantity' , 'required');
                }
                $this->form_validation->set_rules('financial_year', 'financial year' , 'required');
                $this->form_validation->set_rules('datype', 'Da type' , 'required');
                //$this->form_validation->set_rules('lc_no', 'LC no' , 'required');
                $this->form_validation->set_rules('lc_date', 'LC date' , 'required');
                $this->form_validation->set_rules('da_date', 'Da date' , 'required');
                $this->form_validation->set_rules('po_no', 'PO No' , 'required');
                $this->form_validation->set_rules('po_date', 'PO date' , 'required');
                $this->form_validation->set_rules('buyer', 'buyer' , 'required');
                $this->form_validation->set_rules('consignee', 'consignee' , 'required');
                $this->form_validation->set_rules('notify_1', 'notify 1' , 'required');
                $this->form_validation->set_rules('notify_2', 'notify 2' , 'required');
                //$this->form_validation->set_rules('instructions', 'instructions' , 'required');
                $this->form_validation->set_rules('despatch_instructions', 'despatch instructions' , 'required');
                //$this->form_validation->set_rules('bank_details', 'bank details' , 'required');
                $this->form_validation->set_rules('special_instructions', 'special instructions' , 'required');
                $this->form_validation->set_rules('shipping_marks', 'shipping marks' , 'required');
                $this->form_validation->set_rules('declaration', 'declaration' , 'required');
                $this->form_validation->set_rules('country', 'country' , 'required');
                $this->form_validation->set_rules('delivery_terms', 'delivery terms' , 'required');
                $this->form_validation->set_rules('payment_terms', 'payment terms' , 'required');
                $this->form_validation->set_rules('month_of_sale', 'month of sale' , 'required');
                $this->form_validation->set_rules('shipment_mode', 'shipment mode' , 'required');
                $this->form_validation->set_rules('despatch_to', 'despatch to' , 'required');
                $this->form_validation->set_rules('transport_mode_to_cha', 'transport mode to cha' , 'required');
                $this->form_validation->set_rules('agent', 'agent' , 'required');
                $this->form_validation->set_rules('ordered_by', 'ordered by' , 'required');
                $this->form_validation->set_rules('label', 'label' , 'required');
                $this->form_validation->set_rules('prepared_by', 'prepared by' , 'required');
                $this->form_validation->set_rules('currency', 'currency' , 'required');
                $this->form_validation->set_rules('exchange_rate', 'exchange rate' , 'required');
                //$this->form_validation->set_rules('gst_rate', 'gst rate' , 'required');
                //$this->form_validation->set_rules('gst_amount', 'gst amount' , 'required');
                //$this->form_validation->set_rules('comm_amount_for_capsule', 'commmunication amount for capsule' , 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','<span>');

                if($this->form_validation->run() == TRUE) {

                    $quantity = !empty($post['quantity_1']) ? $post['quantity_1'] : '';
                    $pre_shipment_sample = !empty($post['approve_preshipment']) ? 1 : 0;
  
                    $table_array  = array(

                         'financial_year' => strip_tags($post['financial_year']),
                         'lc_no' => strip_tags($post['lc_no']),
                         'da_type' => strip_tags($post['datype']),
                         'type' => 0,
                         'lc_date' => strip_tags( nice_date( $post['lc_date'], 'Y-m-d')),
                         'po_no' => strip_tags($post['po_no']),
                         'da_no' => $da_number,
                         'da_date' => strip_tags( nice_date( $post['da_date'], 'Y-m-d') ),
                         'po_date' => strip_tags( nice_date( $post['po_date'], 'Y-m-d') ),
                         'buyer' => strip_tags($post['buyer']), 
                         'consignee' => strip_tags($post['consignee']),
                         'notify' => strip_tags($post['notify_1']),
                         'notify_1' => strip_tags($post['notify_2']),
                         'instructions' => strip_tags($post['instructions']),
                         'despatching_instructions' => strip_tags($post['despatch_instructions']),
                         'bank_details' => strip_tags($post['bank_details']),
                         'specifications' => strip_tags($post['specification']),
                         'special_instructions' => strip_tags($post['special_instructions']),
                         'shipping_marks' => strip_tags($post['shipping_marks']),
                         'declaration' => strip_tags($post['declaration']),
                         'country' => strip_tags($post['country']),
                         'term_of_delivery' => strip_tags($post['delivery_terms']),
                         'payment_terms' => strip_tags($post['payment_terms']),
                         'pre_shipment_sample' => $pre_shipment_sample,
                         'sample_quantity' => $quantity,
                         'month_of_sale' => strip_tags($post['month_of_sale']),
                         'shipping_mode' => strip_tags($post['shipment_mode']),
                         'despatch_to' => strip_tags($post['despatch_to']),
                         'transport_mode_to_cha' => strip_tags($post['transport_mode_to_cha']),
                         'agent' => strip_tags($post['agent']),
                         'ordered_by' => strip_tags($post['ordered_by']),
                         'label' => strip_tags($post['label']),
                         'prepared_by' => strip_tags($post['prepared_by']),
                         'currency' => strip_tags($post['currency']),
                         'exchange_rate' => strip_tags($post['exchange_rate']),
                         'gst_per' => strip_tags($post['gst_rate']),
                         'gst_amt' => strip_tags($post['gst_amount']),
                         'total_commission' => strip_tags($post['comm_amount_for_capsule']),
                         
                    );
                    $insert = $this->da_header->insert($table_array);

                    if(!empty($insert)) {
                     
                        if(!empty($post['product'])) {

                            $count = count($post['product']);
                             $da_items_table_array = array();
                            for($i = 0; $i <= $count - 1; $i++) {
                               if(!empty($post['product'][$i])) {
                                $da_items_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $insert,
                                    'product' => $post['product'][$i],
                                    'hscode' => $post['hs_code'][$i],
                                    'product_form' => $post['product_form'][$i],
                                    'grade' => $post['product_grade'][$i],
                                    'packing_type' => $post['packing_type'][$i],
                                    'quantity' => $post['qty'][$i],
                                    'rate' => $post['rate'][$i],
                                    'amount' => $post['amount'][$i],
                                    'freight' => $post['freight'][$i],
                                    'logistic' => $post['logistics'][$i],
                                    'fob_rate' => $post['fob_rate'][$i],
                                    'fob_rate_plant' => $post['rate'][$i] - $post['freight'][$i],
                                    'quantity_discount' => $post['qty_discount'][$i],
                                    'commission_per' => $post['comm_per'][$i],
                                    'commission_amount' => $post['comm_amount'][$i],
                                    'net_price' => $post['net_price'][$i]
                                );
                              }
                            }     
                             //echo "<pre>";print_r($da_items_table_array);die;
                             if(!empty($da_items_table_array)) {
                                 $this->da_items->insertBatch($da_items_table_array); 
                             }                  
                         }
                         if(!empty($post['document'])) {
                            
                            $count = count($post['document']);
                            for($i = 0; $i <= $count - 1; $i++) {
                                $document_requred_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $insert,
                                    'documents_required' => $post['document'][$i]
                                );
                            }
                            if(!empty($document_requred_table_array)) {
                              $this->da_document->insertBatch($document_requred_table_array);
                            }
                        }

                         $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Add DA-NO:'.DA_NUM,
                         );
                         $this->audit->insert($audit_trial);

                         $this->session->set_flashdata('success','Record added successfully.');
                         return redirect(base_url().'logistics');

                    } else {

                         $this->session->set_flashdata('error','Unable to process your request.Please try again later');
                          return redirect(base_url().'logistics');
                    }
                } else {
                    $this->session->set_flashdata('error','Validation error.Please check the form.');
                }

            }
            
            $data['users'] = $this->user_model->findAll(null, array('orderby' => 'id'));
            $data['prepared_by'] =  $this->session->userdata()['username'];
          
            $data['da_type'] = $this->datype_model->findAll(null, array('orderby' => 'datype','order' => 'ASC'));
            $data['buyer'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['declaration'] = $this->declaration->findAll();

            $data['label']  = $this->label->findall(null, array('orderby' => 'label','order' => 'ASC'));
            $data['country'] = $this->country->findAll();
            $data['payment_terms'] = $this->payment_terms->findAll(null, array('orderby' => 'paymentterms' ,'order' => 'ASC'));
            $data['shipment_mode'] = $this->shipment_mode->findAll(null, array('orderby' => 'shippingmode' ,'order' => 'ASC'));
            $data['agent'] = $this->agent->findAll(null, array('orderby' => 'agent','order' => 'ASC'));

            $data['currency'] = $this->currency->findAll(null, array('orderby' => 'currency','order' => 'ASC'));
            $data['product_form'] = $this->product_form->findAll(null, array('orderby' => 'productform','order' => 'ASC'));
            $data['product_grade'] = $this->product_grade->findAll(null, array('orderby' => 'productgrade','order' => 'ASC'));

            $data['despatch_to'] =  $this->despatch->findAll(null, array('orderby' => 'despatchto','order' => 'ASC'));
            $data['transport_mode_to_cha'] =  $this->transport_mode->findAll(null, array('orderby' => 'transportmodetocha','order' => 'ASC'));

            $data['delivery_term'] = $this->delivery_term->findAll(null, array('orderby' => 'deliveryterm','order' => 'ASC'));
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));

            //echo "<pre>";print_r($data['documents_required']);die;
            $data['pageTitle'] = 'Neclife- Logistics | DA Entry Add';
            $data['template']  = 'logistics/da-entry';
            $this->load->view('template_admin',$data);
            
        }

        /**
        * Function logistics da_entry.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function edit_da_entry($id = '') {
            
            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
                 
                //echo "<pre>";print_r($post);die;
                $da_number = 'DA-'.date('Y').'-'.random_string('alnum', 5);

                if(!empty($post['document'])) { 
                   $this->form_validation->set_rules('document[]', 'document' , 'required');
                }
                if(!empty($post['approve_preshipment'])) {
                    $this->form_validation->set_rules('quantity_1', 'quantity' , 'required');
                }
                $this->form_validation->set_rules('financial_year', 'financial year' , 'required');
                $this->form_validation->set_rules('datype', 'Da type' , 'required');
                //$this->form_validation->set_rules('lc_no', 'LC no.' , 'required');
                $this->form_validation->set_rules('lc_date_1', 'LC date' , 'required');
                $this->form_validation->set_rules('da_date_1', 'Da date' , 'required');
                $this->form_validation->set_rules('po_no', 'PO no.' , 'required');
                $this->form_validation->set_rules('po_date_1', 'PO date' , 'required');
                $this->form_validation->set_rules('buyer', 'buyer' , 'required');
                $this->form_validation->set_rules('consignee', 'consignee' , 'required');
                $this->form_validation->set_rules('notify_1', 'notify 1' , 'required');
                $this->form_validation->set_rules('notify_2', 'notify 2' , 'required');
                //$this->form_validation->set_rules('instructions', 'instructions' , 'required');
                $this->form_validation->set_rules('despatch_instructions', 'despatch instructions' , 'required');
                //$this->form_validation->set_rules('bank_details', 'bank details' , 'required');
                $this->form_validation->set_rules('special_instructions', 'special instructions' , 'required');
                $this->form_validation->set_rules('shipping_marks', 'shipping marks' , 'required');
                $this->form_validation->set_rules('declaration', 'declaration' , 'required');
                $this->form_validation->set_rules('country', 'country' , 'required');
                $this->form_validation->set_rules('delivery_terms', 'delivery terms' , 'required');
                $this->form_validation->set_rules('payment_terms', 'payment terms' , 'required');
                $this->form_validation->set_rules('month_of_sale', 'month of sale' , 'required');
                $this->form_validation->set_rules('shipment_mode', 'shipment mode' , 'required');
                $this->form_validation->set_rules('despatch_to', 'despatch to' , 'required');
                $this->form_validation->set_rules('transport_mode_to_cha', 'transport mode to cha' , 'required');
                $this->form_validation->set_rules('agent', 'agent' , 'required');
                $this->form_validation->set_rules('ordered_by', 'ordered by' , 'required');
                $this->form_validation->set_rules('label', 'label' , 'required');
                $this->form_validation->set_rules('prepared_by', 'prepared by' , 'required');
                $this->form_validation->set_rules('currency', 'currency' , 'required');
                $this->form_validation->set_rules('exchange_rate', 'exchange rate' , 'required');
                //$this->form_validation->set_rules('gst_rate', 'gst rate' , 'required');
                //$this->form_validation->set_rules('gst_amount', 'gst amount' , 'required');
                //$this->form_validation->set_rules('comm_amount_for_capsule', 'commmunication amount for capsule' , 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','<span>');

                if($this->form_validation->run() == TRUE) {
                  
                    $quantity = !empty($post['quantity_1']) ? $post['quantity_1'] : '';
                    $pre_shipment_sample = !empty($post['approve_preshipment']) ? 1 : 0;
  
                    $table_array  = array(

                         'financial_year' => strip_tags($post['financial_year']),
                         'lc_no' => strip_tags($post['lc_no']),
                         'da_type' => strip_tags($post['datype']),
                         'type' => 0,
                         'lc_date' => strip_tags( nice_date( $post['lc_date_1'], 'Y-m-d')),
                         'po_no' => strip_tags($post['po_no']),
                         'da_no' => $post['da_no'],
                         'da_date' => strip_tags( nice_date( $post['da_date_1'], 'Y-m-d') ),
                         'po_date' => strip_tags( nice_date( $post['po_date_1'], 'Y-m-d') ),
                         'buyer' => strip_tags($post['buyer']), 
                         'consignee' => strip_tags($post['consignee']),
                         'notify' => strip_tags($post['notify_1']),
                         'notify_1' => strip_tags($post['notify_2']),
                         'instructions' => strip_tags($post['instructions']),
                         'despatching_instructions' => strip_tags($post['despatch_instructions']),
                         'bank_details' => strip_tags($post['bank_details']),
                         'specifications' => strip_tags($post['specification']),
                         'special_instructions' => strip_tags($post['special_instructions']),
                         'shipping_marks' => strip_tags($post['shipping_marks']),
                         'declaration' => strip_tags($post['declaration']),
                         'country' => strip_tags($post['country']),
                         'term_of_delivery' => strip_tags($post['delivery_terms']),
                         'payment_terms' => strip_tags($post['payment_terms']),
                         'pre_shipment_sample' => $pre_shipment_sample,
                         'sample_quantity' => $quantity,
                         'month_of_sale' => strip_tags($post['month_of_sale']),
                         'shipping_mode' => strip_tags($post['shipment_mode']),
                         'despatch_to' => strip_tags($post['despatch_to']),
                         'transport_mode_to_cha' => strip_tags($post['transport_mode_to_cha']),
                         'agent' => strip_tags($post['agent']),
                         'ordered_by' => strip_tags($post['ordered_by']),
                         'label' => strip_tags($post['label']),
                         'prepared_by' => strip_tags($post['prepared_by']),
                         'currency' => strip_tags($post['currency']),
                         'exchange_rate' => strip_tags($post['exchange_rate']),
                         'gst_per' => strip_tags($post['gst_rate']),
                         'gst_amt' => strip_tags($post['gst_amount']),
                         'total_commission' => strip_tags($post['comm_amount_for_capsule']),
                         
                    );
                    $update = $this->da_header->update($table_array, array('id' => $id));

                    if(!empty($update)) {
                     
                        if(!empty($post['product'])) {

                            $count = count($post['product']);
                            $da_items_table_array = array();
                            for($i = 0; $i <= $count - 1; $i++) {
                             if(!empty($post['product'][$i])) {
                                $da_items_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $id,
                                    'product' => $post['product'][$i],
                                    'hscode' => $post['hs_code'][$i],
                                    'product_form' => $post['product_form'][$i],
                                    'grade' => $post['product_grade'][$i],
                                    'packing_type' => $post['packing_type'][$i],
                                    'quantity' => $post['qty'][$i],
                                    'rate' => $post['rate'][$i],
                                    'amount' => $post['amount'][$i],
                                    'freight' => $post['freight'][$i],
                                    'logistic' => $post['logistics'][$i],
                                    'fob_rate' => $post['fob_rate'][$i],
                                    'fob_rate_plant' => $post['rate'][$i] - $post['freight'][$i],
                                    'quantity_discount' => $post['qty_discount'][$i],
                                    'commission_per' => $post['comm_per'][$i],
                                    'commission_amount' => $post['comm_amount'][$i],
                                    'net_price' => $post['net_price'][$i]
                                );
                              }
                            }     
                             if(!empty($da_items_table_array)){
                                 $this->da_items->deleteWhere(array('da_no' => $id));
                                  $this->da_items->insertBatch($da_items_table_array);
                             }
                                                
                         }
                         if(!empty($post['document'])) {
                            
                            $count = count($post['document']);
                            for($i = 0; $i <= $count - 1; $i++) {
                                $document_requred_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $id,
                                    'documents_required' => $post['document'][$i]
                                );
                            }
                            if(!empty($document_requred_table_array)) {
                              $this->da_document->deleteWhere(array('da_no' => $id));
                              $this->da_document->insertBatch($document_requred_table_array);
                            }
                        }

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Edit DA-NO:'.DA_NUM,
                         );

                         $this->audit->insert($audit_trial);


                         $this->session->set_flashdata('success','Record updated successfully.');
                         return redirect(base_url().'logistics');

                    } else {

                         $this->session->set_flashdata('error','Unable to process your request.Please try again later');
                          return redirect(base_url().'logistics');
                    }
                } else {

                    //echo validation_errors();die;
                    $this->session->set_flashdata('error','Validation error.Please check the form.');
                }

            }
            $findone  = $this->da_header->findOne($id);
            if(empty($findone) || ($findone['type'] == 1 || $findone['cancelled_by'] != null) ) {
                 return redirect(base_url().'logistics');
            }
            $da_header = $this->da_header->findAll(array('id' => $id));
            $da_items = $this->da_items->findAll(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header[0];
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
 
            $da_type = $da_header[0]['da_type'];

            $data['product'] = $this->product->findAll(array('datype'=> $da_type));
           
            $data['packing_type'] = $this->packages->findAll(array('datype'=> $da_type));
             //echo "<pre>";print_r($data['packing_type']);die;
            $data['users'] = $this->user_model->findAll(null, array('orderby' => 'id'));
            $data['prepared_by'] =  $this->session->userdata()['username'];
          
            $data['da_type'] = $this->datype_model->findAll(null, array('orderby' => 'datype','order' => 'ASC'));
            $data['buyer'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['declaration'] = $this->declaration->findAll();

            $data['label']  = $this->label->findall(null, array('orderby' => 'label','order' => 'ASC'));
            $data['country'] = $this->country->findAll();
            $data['payment_terms'] = $this->payment_terms->findAll(null, array('orderby' => 'paymentterms' ,'order' => 'ASC'));
            $data['shipment_mode'] = $this->shipment_mode->findAll(null, array('orderby' => 'shippingmode' ,'order' => 'ASC'));
            $data['agent'] = $this->agent->findAll(null, array('orderby' => 'agent','order' => 'ASC'));

            $data['currency'] = $this->currency->findAll(null, array('orderby' => 'currency','order' => 'ASC'));
            $data['product_form'] = $this->product_form->findAll(null, array('orderby' => 'productform','order' => 'ASC'));
            $data['product_grade'] = $this->product_grade->findAll(null, array('orderby' => 'productgrade','order' => 'ASC'));

            $data['despatch_to'] =  $this->despatch->findAll(null, array('orderby' => 'despatchto','order' => 'ASC'));
            $data['transport_mode_to_cha'] =  $this->transport_mode->findAll(null, array('orderby' => 'transportmodetocha','order' => 'ASC'));

            $data['delivery_term'] = $this->delivery_term->findAll(null, array('orderby' => 'deliveryterm','order' => 'ASC'));
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Entry Edit';
            $data['template']  = 'logistics/da-entry-edit';
            $this->load->view('template_admin',$data);
            
        }



        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_sample() {
            
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
        
          $da_sample_list = $this->da_header->get_all_da_entry($where, array('type'=> 1));
          if(empty($da_sample_list)) {
             $this->session->set_flashdata('error','No Record Found.');
          }
          $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
          $data['da_sample'] = $da_sample_list;

          $data['pageTitle'] = 'Neclife- Logistics | DA Sample';
          $data['template']  = 'logistics/da-sample';
          $this->load->view('template_admin',$data);
            
        }

        /**
        * Function logistics da sample add.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_sample_add() {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {

                $first_letter = $this->datype_model->findone($post['datype']);
                $da_number = 'DA-'.date('Y').'-'.random_string('numeric', 5);
                define('DA_NUM' , $da_number);

                if(!empty($post['document'])) { 
                   $this->form_validation->set_rules('document[]', 'document' , 'required');
                }
                if(!empty($post['approve_preshipment'])) {
                    $this->form_validation->set_rules('quantity_1', 'quantity' , 'required');
                }
                $this->form_validation->set_rules('financial_year', 'financial year' , 'required');
                $this->form_validation->set_rules('datype', 'DA type' , 'required');
               //$this->form_validation->set_rules('lc_no', 'LC no.' , 'required');
                $this->form_validation->set_rules('lc_date', 'LC date' , 'required');
                $this->form_validation->set_rules('da_date', 'DA date' , 'required');
                $this->form_validation->set_rules('po_no', 'PO no.' , 'required');
                $this->form_validation->set_rules('po_date', 'PO date' , 'required');
                $this->form_validation->set_rules('buyer', 'buyer' , 'required');
                $this->form_validation->set_rules('consignee', 'consignee' , 'required');
                $this->form_validation->set_rules('notify_1', 'notify 1' , 'required');
                $this->form_validation->set_rules('notify_2', 'notify 2' , 'required');
                //$this->form_validation->set_rules('instructions', 'instructions' , 'required');
                $this->form_validation->set_rules('despatch_instructions', 'despatch instructions' , 'required');
                //$this->form_validation->set_rules('bank_details', 'bank details' , 'required');
                $this->form_validation->set_rules('special_instructions', 'special instructions' , 'required');
                $this->form_validation->set_rules('shipping_marks', 'shipping marks' , 'required');
                $this->form_validation->set_rules('declaration', 'declaration' , 'required');
                $this->form_validation->set_rules('country', 'country' , 'required');
                $this->form_validation->set_rules('delivery_terms', 'delivery terms' , 'required');
                $this->form_validation->set_rules('payment_terms', 'payment terms' , 'required');
                $this->form_validation->set_rules('month_of_sale', 'month of sale' , 'required');
                $this->form_validation->set_rules('shipment_mode', 'shipment mode' , 'required');
                $this->form_validation->set_rules('despatch_to', 'despatch to' , 'required');
                $this->form_validation->set_rules('transport_mode_to_cha', 'transport mode to cha' , 'required');
                $this->form_validation->set_rules('agent', 'agent' , 'required');
                $this->form_validation->set_rules('ordered_by', 'ordered by' , 'required');
                $this->form_validation->set_rules('label', 'label' , 'required');
                $this->form_validation->set_rules('prepared_by', 'prepared by' , 'required');
                $this->form_validation->set_rules('currency', 'currency' , 'required');
                $this->form_validation->set_rules('exchange_rate', 'exchange rate' , 'required');
                //$this->form_validation->set_rules('gst_rate', 'gst rate' , 'required');
                //$this->form_validation->set_rules('gst_amount', 'gst amount' , 'required');
                //$this->form_validation->set_rules('comm_amount_for_capsule', 'commmunication amount for capsule' , 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','<span>');

                if($this->form_validation->run() == TRUE) {

                    $quantity = !empty($post['quantity_1']) ? $post['quantity_1'] : '';
                    $pre_shipment_sample = !empty($post['approve_preshipment']) ? 1 : 0;
  
                    $table_array  = array(

                         'financial_year' => strip_tags($post['financial_year']),
                         'lc_no' => strip_tags($post['lc_no']),
                         'da_type' => strip_tags($post['datype']),
                         'type' => 1,
                         'lc_date' => strip_tags( nice_date( $post['lc_date'], 'Y-m-d')),
                         'po_no' => strip_tags($post['po_no']),
                         'da_no' => $da_number,
                         'da_date' => strip_tags( nice_date( $post['da_date'], 'Y-m-d') ),
                         'po_date' => strip_tags( nice_date( $post['po_date'], 'Y-m-d') ),
                         'buyer' => strip_tags($post['buyer']), 
                         'consignee' => strip_tags($post['consignee']),
                         'notify' => strip_tags($post['notify_1']),
                         'notify_1' => strip_tags($post['notify_2']),
                         'instructions' => strip_tags($post['instructions']),
                         'despatching_instructions' => strip_tags($post['despatch_instructions']),
                         'bank_details' => strip_tags($post['bank_details']),
                         'specifications' => strip_tags($post['specification']),
                         'special_instructions' => strip_tags($post['special_instructions']),
                         'shipping_marks' => strip_tags($post['shipping_marks']),
                         'declaration' => strip_tags($post['declaration']),
                         'country' => strip_tags($post['country']),
                         'term_of_delivery' => strip_tags($post['delivery_terms']),
                         'payment_terms' => strip_tags($post['payment_terms']),
                         'pre_shipment_sample' => $pre_shipment_sample,
                         'sample_quantity' => $quantity,
                         'month_of_sale' => strip_tags($post['month_of_sale']),
                         'shipping_mode' => strip_tags($post['shipment_mode']),
                         'despatch_to' => strip_tags($post['despatch_to']),
                         'transport_mode_to_cha' => strip_tags($post['transport_mode_to_cha']),
                         'agent' => strip_tags($post['agent']),
                         'ordered_by' => strip_tags($post['ordered_by']),
                         'label' => strip_tags($post['label']),
                         'prepared_by' => strip_tags($post['prepared_by']),
                         'currency' => strip_tags($post['currency']),
                         'exchange_rate' => strip_tags($post['exchange_rate']),
                         'gst_per' => strip_tags($post['gst_rate']),
                         'gst_amt' => strip_tags($post['gst_amount']),
                         'total_commission' => strip_tags($post['comm_amount_for_capsule']),
                         
                    );
                    $insert = $this->da_header->insert($table_array);

                    if(!empty($insert)) {
                     
                        if(!empty($post['product'])) {

                            $count = count($post['product']);
                             $da_items_table_array = array();

                              for($i = 0; $i <= $count - 1; $i++) {
                               if(!empty($post['product'][$i])) {
                                $da_items_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $insert,
                                    'product' => $post['product'][$i],
                                    'hscode' => $post['hs_code'][$i],
                                    'product_form' => $post['product_form'][$i],
                                    'grade' => $post['product_grade'][$i],
                                    'packing_type' => $post['packing_type'][$i],
                                    'quantity' => $post['qty'][$i],
                                    'rate' => $post['rate'][$i],
                                    'amount' => $post['amount'][$i],
                                    'freight' => $post['freight'][$i],
                                    'logistic' => $post['logistics'][$i],
                                    'fob_rate' => $post['fob_rate'][$i],
                                    'fob_rate_plant' => $post['rate'][$i] - $post['freight'][$i],
                                    'quantity_discount' => $post['qty_discount'][$i],
                                    'commission_per' => $post['comm_per'][$i],
                                    'commission_amount' => $post['comm_amount'][$i],
                                    'net_price' => $post['net_price'][$i]
                                );
                               }
                            }     
                             if(!empty($da_items_table_array)){
                                     $this->da_items->insertBatch($da_items_table_array);
                             }
                   
                         }
                         if(!empty($post['document'])) {
                            
                            $count = count($post['document']);
                            for($i = 0; $i <= $count - 1; $i++) {
                                $document_requred_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $insert,
                                    'documents_required' => $post['document'][$i]
                                );
                            }
                            if(!empty($document_requred_table_array)) {
                              $this->da_document->insertBatch($document_requred_table_array);
                            }
                        }

                         $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Add DA-NO:'.DA_NUM,
                         );
                         $this->audit->insert($audit_trial);

                         $this->session->set_flashdata('success','Record added successfully.');
                         return redirect(base_url().'logistics/da_sample');

                    } else {

                         $this->session->set_flashdata('error','Unable to process your request.Please try again later');
                          return redirect(base_url().'logistics/da_sample');
                    }
                } else {
                    $this->session->set_flashdata('error','Validation error.Please check the form.');
                }

            }
            
            $data['users'] = $this->user_model->findAll(null, array('orderby' => 'id'));
            $data['prepared_by'] =  $this->session->userdata()['username'];
          
            $data['da_type'] = $this->datype_model->findAll(null, array('orderby' => 'datype','order' => 'ASC'));
            $data['buyer'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['declaration'] = $this->declaration->findAll();

            $data['label']  = $this->label->findall(null, array('orderby' => 'label','order' => 'ASC'));
            $data['country'] = $this->country->findAll();
            $data['payment_terms'] = $this->payment_terms->findAll(null, array('orderby' => 'paymentterms' ,'order' => 'ASC'));
            $data['shipment_mode'] = $this->shipment_mode->findAll(null, array('orderby' => 'shippingmode' ,'order' => 'ASC'));
            $data['agent'] = $this->agent->findAll(null, array('orderby' => 'agent','order' => 'ASC'));

            $data['currency'] = $this->currency->findAll(null, array('orderby' => 'currency','order' => 'ASC'));
            $data['product_form'] = $this->product_form->findAll(null, array('orderby' => 'productform','order' => 'ASC'));
            $data['product_grade'] = $this->product_grade->findAll(null, array('orderby' => 'productgrade','order' => 'ASC'));

            $data['despatch_to'] =  $this->despatch->findAll(null, array('orderby' => 'despatchto','order' => 'ASC'));
            $data['transport_mode_to_cha'] =  $this->transport_mode->findAll(null, array('orderby' => 'transportmodetocha','order' => 'ASC'));

            $data['delivery_term'] = $this->delivery_term->findAll(null, array('orderby' => 'deliveryterm','order' => 'ASC'));
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Sample Add';
            $data['template']  = 'logistics/da-sample-add';
            $this->load->view('template_admin',$data);
            
        }


        /**
        * Function logistics da_entry.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_sample_edit($id = '') {
            
            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
                 
                //echo "<pre>";print_r($post);die;
                $da_number = 'DA-'.date('Y').'-'.random_string('alnum', 5);

                if(!empty($post['document'])) { 
                   $this->form_validation->set_rules('document[]', 'document' , 'required');
                }
                if(!empty($post['approve_preshipment'])) {
                    $this->form_validation->set_rules('quantity_1', 'quantity' , 'required');
                }
                $this->form_validation->set_rules('financial_year', 'financial year' , 'required');
                $this->form_validation->set_rules('datype', 'Da type' , 'required');
                //$this->form_validation->set_rules('lc_no', 'LC no.' , 'required');
                $this->form_validation->set_rules('lc_date_1', 'LC date' , 'required');
                $this->form_validation->set_rules('da_date_1', 'Da date' , 'required');
                $this->form_validation->set_rules('po_no', 'PO no.' , 'required');
                $this->form_validation->set_rules('po_date_1', 'PO date' , 'required');
                $this->form_validation->set_rules('buyer', 'buyer' , 'required');
                $this->form_validation->set_rules('consignee', 'consignee' , 'required');
                $this->form_validation->set_rules('notify_1', 'notify 1' , 'required');
                $this->form_validation->set_rules('notify_2', 'notify 2' , 'required');
                //$this->form_validation->set_rules('instructions', 'instructions' , 'required');
                $this->form_validation->set_rules('despatch_instructions', 'Despatch Instructions' , 'required');
                //$this->form_validation->set_rules('bank_details', 'bank details' , 'required');
                $this->form_validation->set_rules('special_instructions', 'special instructions' , 'required');
                $this->form_validation->set_rules('shipping_marks', 'shipping marks' , 'required');
                $this->form_validation->set_rules('declaration', 'declaration' , 'required');
                $this->form_validation->set_rules('country', 'country' , 'required');
                $this->form_validation->set_rules('delivery_terms', 'delivery terms' , 'required');
                $this->form_validation->set_rules('payment_terms', 'payment terms' , 'required');
                $this->form_validation->set_rules('month_of_sale', 'month of sale' , 'required');
                $this->form_validation->set_rules('shipment_mode', 'shipment mode' , 'required');
                $this->form_validation->set_rules('despatch_to', 'despatch to' , 'required');
                $this->form_validation->set_rules('transport_mode_to_cha', 'transport mode to cha' , 'required');
                $this->form_validation->set_rules('agent', 'agent' , 'required');
                $this->form_validation->set_rules('ordered_by', 'ordered by' , 'required');
                $this->form_validation->set_rules('label', 'label' , 'required');
                $this->form_validation->set_rules('prepared_by', 'prepared by' , 'required');
                $this->form_validation->set_rules('currency', 'currency' , 'required');
                $this->form_validation->set_rules('exchange_rate', 'exchange rate' , 'required');
                //$this->form_validation->set_rules('gst_rate', 'gst rate' , 'required');
                //$this->form_validation->set_rules('gst_amount', 'gst amount' , 'required');
                //$this->form_validation->set_rules('comm_amount_for_capsule', 'commmunication amount for capsule' , 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','<span>');

                if($this->form_validation->run() == TRUE) {
                  
                    $quantity = !empty($post['quantity_1']) ? $post['quantity_1'] : '';
                    $pre_shipment_sample = !empty($post['approve_preshipment']) ? 1 : 0;
  
                    $table_array  = array(

                         'financial_year' => strip_tags($post['financial_year']),
                         'lc_no' => strip_tags($post['lc_no']),
                         'da_type' => strip_tags($post['datype']),
                         'type' => 1,
                         'lc_date' => strip_tags( nice_date( $post['lc_date_1'], 'Y-m-d')),
                         'po_no' => strip_tags($post['po_no']),
                         'da_no' => $da_number,
                         'da_date' => strip_tags( nice_date( $post['da_date_1'], 'Y-m-d') ),
                         'po_date' => strip_tags( nice_date( $post['po_date_1'], 'Y-m-d') ),
                         'buyer' => strip_tags($post['buyer']), 
                         'consignee' => strip_tags($post['consignee']),
                         'notify' => strip_tags($post['notify_1']),
                         'notify_1' => strip_tags($post['notify_2']),
                         'instructions' => strip_tags($post['instructions']),
                         'despatching_instructions' => strip_tags($post['despatch_instructions']),
                         'bank_details' => strip_tags($post['bank_details']),
                         'specifications' => strip_tags($post['specification']),
                         'special_instructions' => strip_tags($post['special_instructions']),
                         'shipping_marks' => strip_tags($post['shipping_marks']),
                         'declaration' => strip_tags($post['declaration']),
                         'country' => strip_tags($post['country']),
                         'term_of_delivery' => strip_tags($post['delivery_terms']),
                         'payment_terms' => strip_tags($post['payment_terms']),
                         'pre_shipment_sample' => $pre_shipment_sample,
                         'sample_quantity' => $quantity,
                         'month_of_sale' => strip_tags($post['month_of_sale']),
                         'shipping_mode' => strip_tags($post['shipment_mode']),
                         'despatch_to' => strip_tags($post['despatch_to']),
                         'transport_mode_to_cha' => strip_tags($post['transport_mode_to_cha']),
                         'agent' => strip_tags($post['agent']),
                         'ordered_by' => strip_tags($post['ordered_by']),
                         'label' => strip_tags($post['label']),
                         'prepared_by' => strip_tags($post['prepared_by']),
                         'currency' => strip_tags($post['currency']),
                         'exchange_rate' => strip_tags($post['exchange_rate']),
                         'gst_per' => strip_tags($post['gst_rate']),
                         'gst_amt' => strip_tags($post['gst_amount']),
                         'total_commission' => strip_tags($post['comm_amount_for_capsule']),
                         
                    );
                    $update = $this->da_header->update($table_array, array('id' => $id));

                    if(!empty($update)) {
                     
                        if(!empty($post['product'])) {

                            $count = count($post['product']);
                            $da_items_table_array = array();
                            for($i = 0; $i <= $count - 1; $i++) {
                                if(!empty($post['product'][$i])) {
                                $da_items_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $id,
                                    'product' => $post['product'][$i],
                                    'hscode' => $post['hs_code'][$i],
                                    'product_form' => $post['product_form'][$i],
                                    'grade' => $post['product_grade'][$i],
                                    'packing_type' => $post['packing_type'][$i],
                                    'quantity' => $post['qty'][$i],
                                    'rate' => $post['rate'][$i],
                                    'amount' => $post['amount'][$i],
                                    'freight' => $post['freight'][$i],
                                    'logistic' => $post['logistics'][$i],
                                    'fob_rate' => $post['fob_rate'][$i],
                                    'fob_rate_plant' => $post['rate'][$i] - $post['freight'][$i],
                                    'quantity_discount' => $post['qty_discount'][$i],
                                    'commission_per' => $post['comm_per'][$i],
                                    'commission_amount' => $post['comm_amount'][$i],
                                    'net_price' => $post['net_price'][$i]
                                );
                              }
                            }     
                            
                            if(!empty($da_items_table_array)) {
                           
                              $this->da_items->deleteWhere(array('da_no' => $id));
                              $this->da_items->insertBatch($da_items_table_array);  
                            }                 
                         }
                         if(!empty($post['document'])) {
                            
                            $count = count($post['document']);
                            $document_requred_table_array = array();
                            for($i = 0; $i <= $count - 1; $i++) {
                                $document_requred_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_no' => $id,
                                    'documents_required' => $post['document'][$i]
                                );
                            }

                            if(!empty($document_requred_table_array)){
                              $this->da_document->deleteWhere(array('da_no' => $id));
                              $this->da_document->insertBatch($document_requred_table_array);
                            }
                        }

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Edit DA-NO:'.DA_NUM,
                         );

                         $this->audit->insert($audit_trial);


                         $this->session->set_flashdata('success','Record updated successfully.');
                         return redirect(base_url().'logistics/da_sample');

                    } else {

                         $this->session->set_flashdata('error','Unable to process your request.Please try again later');
                          return redirect(base_url().'logistics/da_sample');
                    }
                } else {

                    //echo validation_errors();die;
                    $this->session->set_flashdata('error','Validation error.Please check the form.');
                }

            }
            $findone  = $this->da_header->findOne($id);
            if(empty($findone) || $findone['type'] == 0) {
               return redirect(base_url().'logistics/da_sample');
            }
            $da_header = $this->da_header->findAll(array('id' => $id));
            $da_items = $this->da_items->findAll(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header[0];
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
 
            $da_type = $da_header[0]['da_type'];

            $data['product'] = $this->product->findAll(array('datype'=> $da_type));
           
            $data['packing_type'] = $this->packages->findAll(array('datype'=> $da_type));
             //echo "<pre>";print_r($data['packing_type']);die;
            $data['users'] = $this->user_model->findAll(null, array('orderby' => 'id'));
            $data['prepared_by'] =  $this->session->userdata()['username'];
          
            $data['da_type'] = $this->datype_model->findAll(null, array('orderby' => 'datype','order' => 'ASC'));
            $data['buyer'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['declaration'] = $this->declaration->findAll();

            $data['label']  = $this->label->findall(null, array('orderby' => 'label','order' => 'ASC'));
            $data['country'] = $this->country->findAll();
            $data['payment_terms'] = $this->payment_terms->findAll(null, array('orderby' => 'paymentterms' ,'order' => 'ASC'));
            $data['shipment_mode'] = $this->shipment_mode->findAll(null, array('orderby' => 'shippingmode' ,'order' => 'ASC'));
            $data['agent'] = $this->agent->findAll(null, array('orderby' => 'agent','order' => 'ASC'));

            $data['currency'] = $this->currency->findAll(null, array('orderby' => 'currency','order' => 'ASC'));
            $data['product_form'] = $this->product_form->findAll(null, array('orderby' => 'productform','order' => 'ASC'));
            $data['product_grade'] = $this->product_grade->findAll(null, array('orderby' => 'productgrade','order' => 'ASC'));

            $data['despatch_to'] =  $this->despatch->findAll(null, array('orderby' => 'despatchto','order' => 'ASC'));
            $data['transport_mode_to_cha'] =  $this->transport_mode->findAll(null, array('orderby' => 'transportmodetocha','order' => 'ASC'));

            $data['delivery_term'] = $this->delivery_term->findAll(null, array('orderby' => 'deliveryterm','order' => 'ASC'));
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));

           // echo "<pre>";print_r($data['da_document']);die;
            $data['pageTitle'] = 'Neclife- Logistics | DA Entry Edit';
            $data['template']  = 'logistics/da-sample-edit';
            $this->load->view('template_admin',$data);
            
        }
        

        /**
        * Function logistics DA Check Listing.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_check() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            
            $data = array();

            $post = $this->input->post();

            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
          
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('da_checked' => 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }

            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Check';
            $data['template']  = 'logistics/da-check/index';
            $this->load->view('template_admin',$data);


        }



        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_check_form($id = '') {
            
            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
               
               $table_array = array(
                   'da_checked' => 1,
                   'checked_by' => $this->session->userdata()['username'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                    $this->session->set_flashdata('success','DA checked and successfully sent for the approval!');
                    return redirect(base_url().'logistics/da_check');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'logistics/da_check');
               }
            }

            $findone  = $this->da_header->findOne($id);
            //echo "<pre>";print_r($findone);die;
            if(empty($findone) || ($findone['type'] == 1 || $findone['cancelled_by'] != null) 
            || !empty($findone['checked_by']) ) {
                 $this->session->set_flashdata('error','No direct access allowed.');
                 return redirect(base_url().'logistics/da_check');
            }
          /*  if(empty($findone) || !empty($findone['checked_by']) ) {
                 
            }*/
            $data['findOne'] = $findone;

            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Check Form';
            $data['template']  = 'logistics/da-check/da-check-form';
            $this->load->view('template_admin',$data);

            
        }

        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_approve() {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('da_checked' => 1, 'approved' => 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- Logistics | DA Approve';
            $data['template']  = 'logistics/da-approve/index';
            $this->load->view('template_admin',$data);
            
        }

               /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_approve_form($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
               
               $table_array = array(
                   'approved' => 1,
                   'approved_by' => $this->session->userdata()['username'],
               );
               
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                    $this->session->set_flashdata('success','DA Approved and successfully sent for the final approval!');
                    return redirect(base_url().'logistics/da_approve');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'logistics/da_approve');
               }
            }

            $findone  = $this->da_header->findOne($id);

            if(empty($findone) || empty($findone['checked_by'])) {
                 return redirect(base_url().'logistics/da_approve');
            }

              $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
                
              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;
              $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
              
              $data['pageTitle'] = 'Neclife- Logistics | DA Approve Form';
              $data['template']  = 'logistics/da-approve/form';
              $this->load->view('template_admin',$data);

            
        }

        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_final_approve() {
            
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('da_checked' => 1, 'approved' => 1, 'final_approved' => 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- Logistics | DA Final Approve';
            $data['template']  = 'logistics/da-final-approve/index';
            $this->load->view('template_admin',$data);
            
        }
         
        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_final_approve_form($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
               
               $table_array = array(
                   'final_approved' => 1,
                   'final_approved_by' => $this->session->userdata()['username'],
               );
               
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                    $this->session->set_flashdata('success','DA Finally Approved successfully!');
                    return redirect(base_url().'logistics/da_final_approve');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'logistics/da_final_approve');
               }
            }

            $findone  = $this->da_header->findOne($id);

            if(empty($findone) || empty($findone['approved'])) {
                 return redirect(base_url().'logistics/da_approve');
            }
             $data['findOne'] = $findone;
             $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
                
              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;

              $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
              
              $data['pageTitle'] = 'Neclife- Logistics | DA Final Approve Form';
              $data['template']  = 'logistics/da-final-approve/form';
              $this->load->view('template_admin',$data);

            
        }
        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_revised() {
            
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
          
           $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('da_checked' => 1, 'approved' => 1, 'final_approved' => 1,'da_revised' => 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Revised';
            $data['template']  = 'logistics/da-revised';
            $this->load->view('template_admin',$data);
            
        }

        /**
        * Manage Revised da request
        * @param POST
        * 
        */

        public function revised_da($id = '') {
          
            if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class());
            }

          if($this->session->userdata('error') ) {
             $this->session->unset_userdata('error');
          }
           $data = array();
           $post = $this->input->post();

           if(!empty($post)) {
               
               $table_array = array (
                   'da_no' => $post['revised_number'],
                   'da_revised' => 1,
                   'da_checked' => 0,
                   'checked_by' => '',
                   'approved' => '',
                   'approved_by' => '',
                   'final_approved' => '',
                   'final_approved_by' => '',
                );
                 
               // echo "<pre>"; print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {

                    $audit_trial = array(
                       'transaction_date' => date('Y-m-d'),
                       'transaction_time' => date("H:i:s"),
                       'username' => $this->session->userdata()['username'],
                       'action' => 'Revised DA-NO:'.$post['old_number']. 'to'.$post['revised_number'],
                    );
                    $this->audit->insert($audit_trial);

                  $this->session->set_flashdata('success', 'DA REvised successfully!');
                  return redirect(base_url().'logistics/da_revised');
            
               } else {
                  $this->session->set_flashdata('error', 'Unable to process your request. Please try again.');
                  return redirect(base_url().'logistics/da_revised');
               }
           } 

            $findone = $this->da_header->findOne($id);
               if(empty($findone) || empty($findone['final_approved'])) {
                  return redirect(base_url().'logistics/da_revised');
               }

              $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
                
              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;
              $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));


             $data['pageTitle'] = 'Neclife- Logistics | DA Revised Form';
             $data['template'] = 'logistics/da-revised-form';
             $this->load->view('template_admin',$data);

        }
        
        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_cancel() {
            
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
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- Logistics | DA Cancel';
            $data['template']  = 'logistics/da-cancel';
            $this->load->view('template_admin',$data);
            
        }



        /**
        * Manage da cancel form
        * @param POST
        * 
        */

        public function da_cancel_form($id = '') {

           if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
          
          if($this->session->userdata('error') ) {
             $this->session->unset_userdata('error');
          }
           $data = array();
           $post = $this->input->post();

           if(!empty($post)) {
               

               $this->form_validation->set_rules('da_no' , 'DA NO' ,'required');
               $this->form_validation->set_rules('cancelled_by' , 'Cancelled By' ,'required');
               $this->form_validation->set_rules('cancellation_date' , 'Cancelllation Date' ,'required');
               $this->form_validation->set_rules('remarks' , 'Cancellations Remarks' ,'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
               
               if($this->form_validation->run() == TRUE) {

                    $table_array = array (
                      
                       'cancelled_by' => strip_tags($post['cancelled_by']),
                       'cancel_date' => strip_tags(nice_date($post['cancellation_date'] ,'Y-m-d')),
                       'cancel_remarks' =>  strip_tags($post['remarks']),

                   );

                   $update = $this->da_header->update($table_array, array('id' => $id));
                   if(!empty($update)) {
                        $audit_trial = array(
                           'transaction_date' => date('Y-m-d'),
                           'transaction_time' => date("H:i:s"),
                           'username' => $this->session->userdata()['username'],
                           'action' => 'Cancel DA-NO:'.$post['old_number']. 'to'.$post['revised_number'],
                        );
                        $this->audit->insert($audit_trial);

                      $this->session->set_flashdata('success', 'DA Cancelled successfully!');
                      return redirect(base_url().'logistics/da_cancel');

                      } else {
                          $this->session->set_flashdata('error', 'Unable to process your request. Please try again.');
                          return redirect(base_url().'logistics/da_cancel');
                    }
                

               } else {
                  $this->session->set_flashdata('error', 'Validation error. Please check the form.');
               }
           } 

           $findone = $this->da_header->findOne($id);
          
           if(empty($findone) || $findone['cancelled_by'] != '') {
            
              return redirect(base_url().'logistics/da_cancel');
           }
           
              $data['cancelled_by'] =  $this->session->userdata()['username'];
              $data['users'] = $this->user_model->findAll(null, array('orderby' => 'id'));

              $data['cancel'] = $findone;
              $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
                
              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;
              $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
               
               $data['pageTitle'] = 'Neclife- Logistics | DA Cancel Form';
               $data['template'] = 'logistics/da-cancel-form';
               $this->load->view('template_admin',$data);

        }


        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function view_da($id ='') {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
    
             $findone  = $this->da_header->findOne($id);
                if(empty($findone)) {
                   return redirect(base_url().'logistics');
            }

              $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
              $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));

              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;
              $data['da_out_standing'] = $da_out_standing;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Entry View';
            $data['template']  = 'logistics/view-da';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_attachment($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $findOne  = $this->da_header->findOne($id);
            if(empty($findOne) || $findOne['cancelled_by'] != '') {
                return redirect(base_url().'logistics');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {
                
                if(!empty($_FILES['attachement']['name'])){
                    //die('first');
                    $config['upload_path'] = 'resources/da-attachement/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|csv|pdf|doc|docx|xlsx|word';
                    $config['file_name'] = $_FILES['attachement']['name'];
                    
                    //Load upload library and initialize configuration
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    
                    if($this->upload->do_upload('attachement')){
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    }else{
                        
                        $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                         return redirect(base_url().'logistics/da_attachment/'.$id);
                        $picture = '';
                    }
                }else{
                    $picture = '';
                }
                
                $table_array = array (
                       'financial_year' => $this->session->userdata('financial_year'),
                       'da_no' => $id,
                       'attachement' => $picture
                );
                //echo "<pre>";print_r($table_array);die;
                $insert = $this->attachement->insert($table_array);
                if(!empty($insert)) {
                     $this->session->set_flashdata('success', 'Attachment added successfully!');
                     return redirect(base_url().'logistics/da_attachment/'.$id);
                } else {
                     $this->session->set_flashdata('error', 'Unable to process the request. Please try again later.');
                     return redirect(base_url().'logistics/da_attachment/'.$id);
                }
            }
            
            $attachement = $this->attachement->findAll(array('da_no' => $id), array('orderby' => 'id'));
            $data['attachement'] = $attachement;
            $data['findOne'] = $findOne;

            $data['pageTitle'] = 'Neclife- Logistics | Manage DA Attachement';
            $data['template']  = 'logistics/da-attachement';
            $this->load->view('template_admin',$data);

        }
        

        /**
        * Function index to  delete user.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function delete_attachement($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
           
            if(!empty($id)) {
                
                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->attachement->delete($id);
                     if(!empty($result)) {
                        $response = array ('success' => 'Record deleted successfully!');
                    }  else {
                         $response = array ('error' => 'Unable to process your request, please try again later.');
                    }
                    echo json_encode($response);die;
                } 
            }  

        }


        
        

         /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function view_sample_da($id ='') {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
    
            $findone  = $this->da_header->findOne($id);
            if(empty($findone)) {
               return redirect(base_url().'logistics');
            }

              $data['findOne'] = $findone;
              $da_header = $this->da_header->findHeaderItems($id);
              $da_items = $this->da_items->findDAItems(array('da_no' => $id));
              $da_document = $this->da_document->findAll(array('da_no' => $id));
              $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));
                
              $data['da_header'] = $da_header;
              $data['da_items'] = $da_items;
              $data['da_document'] = $da_document;
              $data['da_out_standing'] = $da_out_standing;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Sample View';
            $data['template']  = 'logistics/view-sample-da';
            $this->load->view('template_admin',$data);
        }
        

        /**
        * Manage product ajax request.
        *
        * @return Response
        */

        public function get_product($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->product->findAll('datype ='.$id , array('orderby' => 'product','order' => 'ASC'));
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
        * Manage packing type ajax request.
        *
        * @return Response
        */

        public function get_packing_type($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->packages->findAll('datype ='.$id , array('orderby' => 'kindofpackages','order' => 'ASC'));
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
        * Manage product hscode ajax request.
        *
        * @return Response
        */

        public function get_product_hscode($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->product->findAll('id ='.$id);
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
        * Function logistics.
        * @param 
        * Created On:  26-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_plant_despatch_date() {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0));
            //echo "<pre>";print_r($da_entry_list);die;
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));

            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- Logistics | DA Plant Despatch Date';
            $data['template']  = 'logistics/da-plant/index';
            $this->load->view('template_admin',$data);
            
        }
         
        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_plant_despatch_date_form($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post) && $this->input->is_ajax_request()) {
               
               if($post['tentative_date'] =='' || $post['actual_date'] =='') {
                 $response = array('error' => 'Please choose tentative and actual despatch date');
                 echo json_encode($response);die;
               }

               $table_array = array(
                   'plant_despatched_date' => nice_date($post['tentative_date'], 'Y-m-d'),
                   'plant_despatched_date_actual' => nice_date($post['actual_date'], 'Y-m-d'),
               );
               $update = $this->da_items->update($table_array, array('id' => $post['id']));
               if(!empty($update)) {
                    $response = array ('success' => 'Despatch date updated successfully!.');
                } else {
                    $response = array ('error' => 'Unable to update the despatch date');
               }
                   echo json_encode($response);die;
            }

              $findAll = $this->da_items->findDAItems(array('da_no' => $id));
              if(empty($findAll)) {
                 $this->session->set_flashdata('error', 'No DA items Found.');
                 return redirect(base_url().'logistics/da_plant_despatch_date');
              }

              $data['da_items'] = $findAll;
              $data['findone'] = $this->da_header->findOne($id);

              $data['pageTitle'] = 'Neclife- Logistics | DA Plant Despatch Date Form';
              $data['template']  = 'logistics/da-plant/form';
              $this->load->view('template_admin',$data); 
        }

                /**
        * Function logistics.
        * @param 
        * Created On:  26-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_register() {
            
            
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
                       $this->session->set_flashdata('info','No result found between '.$post['from_date'].' To '. $post['upto_date']);
                    }
                
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }

            }
            $da_type = $this->datype_model->findAll(null, array('orderby' => 'id'));
            $data['da_type'] = $da_type;

            $data['pageTitle'] = 'Neclife- Logistics | DA Register';
            $data['template']  = 'logistics/da-register/index';
            $this->load->view('template_admin',$data);
            
        }

                /**
        * Function logistics DA Check Listing.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function bussiness_manager_check_da() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            
            $data = array();

            $post = $this->input->post();

            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
          
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0), array('final_approved' => 1, 'bussiness_manger_checked'=> 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }

            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Bussiness Manager';
            $data['template']  = 'logistics/da-bussiness-manager/index';
            $this->load->view('template_admin',$data);


        }



        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function bussiness_manager_check_da_form($id = '') {

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            
            $post = $this->input->post();

            if(!empty($post)) {
               
               $table_array = array(
                   'bussiness_manger_checked' => 1,
                   'bussiness_manager_check_by' => $this->session->userdata()['username'],
               );
               //print_r($table_array);die;
               $update = $this->da_header->update($table_array, array('id' => $id));
               if(!empty($update)) {
                    $this->session->set_flashdata('success','DA checked successfully!');
                    return redirect(base_url().'logistics/bussiness_manager_check_da');
               } else {
                    $this->session->set_flashdata('error','Unbale to process the request.Please try agian later.');
                    return redirect(base_url().'logistics/bussiness_manager_check_da');
               }
            }

            $findone = $this->da_header->findOne($id);
            //echo "<pre>";print_r($findone);die;
            if(empty($findone) || !empty($findone['bussiness_manger_checked'])) {
                 return redirect(base_url().'logistics/bussiness_manager_check_da');
            }
            $data['findOne'] = $findone;

            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['documents_required'] = $this->document_required->findAll(null, array('orderby' => 'documentsrequired','order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Bussiness Manager Form';
            $data['template']  = 'logistics/da-bussiness-manager/form';
            $this->load->view('template_admin',$data);

            
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
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_account() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }

            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0));
            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;

            $data['pageTitle'] = 'Neclife- Logistics | DA Account';
            $data['template']  = 'logistics/da-copy/index-account';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_account_copy($id = '') {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();

            $findone = $this->da_header->findOne($id);
           
            if(empty($findone) || !empty($findone['bussiness_manger_checked'])) {
                 return redirect(base_url().'logistics/bussiness_manager_check_da');
            }
            $data['findOne'] = $findone;

            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));
           // echo "<pre>";print_r($da_header);die;
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['da_out_standing'] = $da_out_standing;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Account Copy';
            $data['template']  = 'logistics/da-copy/account-copy';
            $this->load->view('template_admin',$data);

        }
         
        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_plant() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            
            $data = array();

            $post = $this->input->post();

            if(!empty($post)) {
                 $where = array('buyer' => $post['buyer'] );
            }  else {
               $where = null;
            }
          
            $da_entry_list = $this->da_header->get_all_da_entry($where, array('type' => 0));

            if(empty($da_entry_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }

            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['da_entry'] = $da_entry_list;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Plant';
            $data['template']  = 'logistics/da-copy/index-plant';
            $this->load->view('template_admin',$data);
        }


        /**
        * Function logistics.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function da_plant_copy($id = '') {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();

            $findone = $this->da_header->findOne($id);
           
            if(empty($findone) || !empty($findone['bussiness_manger_checked'])) {
                 return redirect(base_url().'logistics/bussiness_manager_check_da');
            }
            $data['findOne'] = $findone;

            $da_header = $this->da_header->findHeaderItems($id);
            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $da_document = $this->da_document->findAll(array('da_no' => $id));
            $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));
           // echo "<pre>";print_r($da_header);die;
            
            $data['da_header'] = $da_header;
            $data['da_items'] = $da_items;
            $data['da_document'] = $da_document;
            $data['da_out_standing'] = $da_out_standing;
            
            $data['pageTitle'] = 'Neclife- Logistics | DA Plant Copy';
            $data['template']  = 'logistics/da-copy/plant-copy';
            $this->load->view('template_admin',$data);

        }

        
        /**
        * Function logistics.
        * @param 
        * Created On:  28-May-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list() {

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

            $packing_list = $this->packing_list->findAllPackingList($where);

            //echo "<pre>";print_r($packing_list);die;
            if(empty($packing_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['packing_list'] = $packing_list;
            $data['pageTitle'] = 'Neclife- Logistics | DA Packing List';
            $data['template']  = 'logistics/packing-list/index';
            $this->load->view('template_admin',$data);

        }

         /**
        * Function logistics.
        * @param 
        * Created On:  28-May-2020
        * Created By:  karan.parihar@ids
        */

        public function view_packing_list_raw() {

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

            $packing_list = $this->packing_list->findAllPackingList($where);

            if(empty($packing_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            $data['buyers'] =$this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['packing_list'] = $packing_list;
            $data['pageTitle'] = 'Neclife- Logistics | DA Packing List Raw';
            $data['template']  = 'logistics/packing-list/view-raw';
            $this->load->view('template_admin',$data);

        }

 
        /**
        * Function downlaod all attachments.
        * @param 
        * Created On:  12-June-2020
        * Created By:  karan.parihar@ids
        */


        public function download($id = '') {
              
            if(empty($id)) {
                $this->session->set_flashdata('warning','Invalid source.');
                return redirect(base_url().$this->router->fetch_class());
            }
            $this->load->library('zip');
            $this->load->helper('download');

            if($this->sessionSelected != $this->currentSession) {
                $this->session->set_flashdata('session-mismatch','session-mismatch');
                return redirect(base_url().$this->router->fetch_class());
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
             
            $data =  array();
            $findOne = $this->da_header->findOne($id);
            if(!empty($findOne)) {
                $da_number = $findOne['da_no'];
                $attachments = $this->attachement->findAll(array('da_no'=>$id));
               
                if(!empty($attachments)) {
                    
                    foreach ($attachments as $value) {
                        $path = base_url().'resources/da-attachement';
                        $filepath = $path.'/'.$value['attachement'];
                        $this->zip->add_data($value['attachement'], file_get_contents($filepath));
                    }  
                    $zip_file_name =  $da_number."-attachments.zip";
                    $this->zip->download($zip_file_name);
                } else {
                    $this->session->set_flashdata('info','Sorry! No attachment available to download.');
                   return redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('warning','No direct script access allowed!');

                return redirect($_SERVER['HTTP_REFERER']);

            }

        }
    }

