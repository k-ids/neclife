    <?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Commercial_invoice extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model(array('user_model', 'datype_model','department_model'));
            $this->load->model('userrole_model', 'role');
            $this->load->model('audittrail_model', 'audit');
            $this->load->model('financialyear_model','financial_year');
            $this->load->model('label_model', 'label');
            $this->load->model('admin_model');
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
            $this->load->model('plantpackinglist_model', 'packinglist');
            $this->load->model('documentsrequired_model', 'document_required');
            $this->load->model('invoice_model', 'invoice');
            $this->load->model('advance_model', 'advance');
            $this->load->model('packing_list_invoice_model', 'packing_invoice');
            $this->load->model('epgc_model');
            $this->load->model('invoiceheader_model', 'invoiceheader');
            $this->load->model('invoicedaitems_model', 'invoiceidaitems');
            $this->load->model('invoiceheaderpacking_model', 'invoice_header_packing');
            $this->load->model('invoicepackinglist_model', 'invoiceipackinglist');
            $this->load->model('invoicelicqty_model', 'iqty');
            $this->load->model('emailsender_model');

            $this->load->model('gskpacking_model', 'gsk_packing');
            $this->load->model('gskpackingmap_model', 'gsk_packing_map');

            $this->load->model('exportgskdaitems_model', 'export_gsk_daitems');
            $this->load->model('exportgskheader_model', 'export_gsk_header');
            $this->load->model('exportgskpacking_model', 'export_gsk_packing');
            
            $this->load->model('payment_model', 'invoice_payment');
          
            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 2 && $this->role != 3) {
               $this->session->set_flashdata('session-mismatch', true);
               return redirect(base_url());
           } 


       }

        /*
        | -------------------------------------------------------------------------
        | COMMERCIAL INVOICE SECTION START 
        | -------------------------------------------------------------------------
        | All commercial invoice functions enclosed in this section
        |
        */

        /**
        * Function to commercial invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function index() {
          
           if ($this->session->userdata('error')) {
               $this->session->unset_userdata('error');
           }

           $data = array();
           $post = $this->input->post();
           if(!empty($post)) {
                   $where = $post['buyer'];
               } else {
                $where = null;
            }
            $da_entry_list = $this->da_header->da_entry($where, array('cancelled' => 0),array('type' => 0));
                       //echo "<pre>";print_r($da_entry_list);die;
                if(empty($da_entry_list)) {
                 $this->session->set_flashdata('error','No Record Found.');
             }
             $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
             $data['da_entry'] = $da_entry_list;

             $data['pageTitle'] = 'Neclife - Commercial Invoice';
             $data['template']  = 'commercial-invoice/index';
             $this->load->view('template_admin',$data);
         }

        /**
        * Function to generate commercial invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function generate_invoice($id = '') {

           if(empty($id)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class());
            }
            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {

              //echo "<pre>";print_r($post);die;

                if($this->sessionSelected != $this->currentSession) {
                      $this->session->set_flashdata('session-mismatch','session-mismatch');
                      return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
                }
              
                if(!empty($post['ad_lic_no_array']) && isset($post['ad_lic_no_array'])) {
                    
                    $implode_lic = implode(',', $post['ad_lic_no_array']);
                    $implode_qty = implode(',', $post['lic_quantity']);
                    $advance_lic_number = $implode_lic;
                    $advance_lic_qty = $implode_qty;
                  
                } else {
                   $advance_lic_number = '';
                   $advance_lic_qty = '';
                }
              
             $salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 11);
             $table_array = array (
          
                   'invoice_id' =>$salt.md5($id),
                   'invoice_type' => !empty($post['type']) ? $post['type'][0]: '',
                   'financial_year' => strip_tags($post['financial_year']), 
                   'address' => $post['address'],
                   'buyer_order_number' => strip_tags($post['buyer_order_number']),
                   'buyer_order_date' => strip_tags($post['buyer_order_date']),
                   'contract_number' => strip_tags($post['contract_number']),
                   'contract_date' => strip_tags($post['contract_date']),
                   'da_no' => $id,
                   'da_no_name' => strip_tags($post['da_no']),
                   'da_date' => strip_tags($post['da_date']),
                   'po_no' => strip_tags($post['po_no']),
                   'lic_no' => strip_tags($post['lic_no']),
                   'lic_date' => strip_tags($post['lic_date']),
                   'indent_no' => strip_tags($post['indent_no']),
                   'indent_date' => strip_tags($post['indent_date']),
                   'invoice_no' => strip_tags($post['invoice_no']),
                   'invoice_date' => strip_tags($post['invoice_date']),
                   'export_reference' => $post['export_reference'],
                   'other_reference' => strip_tags($post['other_reference']),
                   'buyer' => strip_tags($post['buyer_inv']),
                   'consignee' => strip_tags($post['consignee_inv']),
                   'notify' => strip_tags($post['notify_inv']),
                   'notify_1' => strip_tags($post['notify_1_inv']),
                   'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
                   'Place_of_reciept' => strip_tags($post['place_of_reciept']),
                   'vessel_flight_no' => strip_tags($post['vessal_flight']),
                   'port_of_loading' => strip_tags($post['port_of_loading']),
                   'port_of_discharge' => strip_tags($post['port_of_discharge']),
                   'final_destination' => strip_tags($post['final_destination']),
                   'country' => strip_tags($post['country']),
                   'term_of_delivery' => strip_tags($post['term_of_delivery']),
                   'term_of_delivery1' => '',
                   'payment_terms' => strip_tags($post['payment_terms']),
                   'payment_terms1' => '',
                   'mfg_date' => strip_tags($post['mfg_date']),
                   'exp_date' => strip_tags($post['exp_date']),
                   'shipping_marks' => strip_tags($post['shipping_marks_inv']),
                   'net_weight' => strip_tags($post['net_weight']),
                   'tare_weight' => strip_tags($post['tare_weight']),
                   'gross_weight' => strip_tags($post['gross_weight']),
                   'declaration' => strip_tags($post['declaration']),
                   'total_amount' => strip_tags(isset($post['total_amount']) ? $post['total_amount'] :'') ,
                   'total' => strip_tags($post['total']),
                   'total_amount_words' =>  strip_tags($post['total_words']),
                   'exchange_rate' => strip_tags(isset($post['exchange_rate']) ? $post['exchange_rate'] : ''),
                   'gst_per' => strip_tags($post['gst_rate_hidden']),
                   'gst_amount' => strip_tags($post['gst_amount_hidden']),
                   'eunder_lut' => strip_tags(isset($post['eunder_lut']) ? $post['eunder_lut']: ''),
                   'taxable' => strip_tags(isset($post['taxable']) ? $post['taxable'] : ''),
                   'pan_number' => strip_tags($post['pan_number']),
                   'batch_no' => strip_tags($post['batch_no']),
                   'ie_code_no' => strip_tags($post['ie_code_no']) ,
                   'ad_lic_no' =>  $advance_lic_number,
                   'under_dbk' =>  strip_tags($post['under_dbk']),
                   'epcg_lic_no' => isset($post['epcg_lic_no_array']) ? $post['epcg_lic_no_array'] :'',
                   'license_qty_used' => $advance_lic_qty,
                   'cin_no' => strip_tags($post['cin_no']),
                   'gstin' => strip_tags($post['gstin']),
                   'state ' => strip_tags($post['state']),
                   'state_code' => strip_tags($post['state_code']),
                   'tin_number' => strip_tags($post['tin_number']),
                   'state_of_origin' => strip_tags($post['state_of_origin']),
                   'district_code' => strip_tags($post['district_code']),
                   'district_of_origin' => strip_tags($post['district_of_origin']),
                   'declaretion_final' => $post['declaration_final'],
                   'currency_name' => strip_tags($post['currency_name']),
                   'created_by' => $this->session->userdata('admin_id'),
                   'created_at' => date('Y-m-d'),

               );

              $insert = $this->invoiceheader->insert($table_array);
              //$insert = 1;
              if(!empty($insert)) {
                     
                     $invoice_payment = array (

                        'da_no' => $id ,
                        'invoice_type' => '1',
                        'invoice_no' => strip_tags($post['invoice_no']) ,
                        'invoice_id' => $salt.md5($id) ,
                        'total_amount' => strip_tags($post['total_amount']) ,
                        'balance' => strip_tags($post['total_amount']) ,
                        'da_name' => strip_tags($post['da_no']) ,
                        'currency_name' => strip_tags($post['currency_name']),
                        'financial_year' => strip_tags($post['financial_year']), 
                     );
                     
                     $this->invoice_payment->insert($invoice_payment);

                     if(!empty($post['packing_type'])) {
                        $count = count($post['packing_type']);
                        $da_items_table_array = array();
                        $total_quantity = false;
                        for($i = 0; $i <= $count - 1; $i++) {
                            $total_quantity += strip_tags($post['quantity'][$i]);
                            $da_items_table_array[] = array (
                                'financial_year' => $post['financial_year'],
                                'da_financial_year' => $post['financial_year'],
                                'invoice_no' => $salt.md5($id),
                                'da_no' => $id,
                                'drum_nos' => strip_tags($post['drum_nos'][$i]),
                                'packing_type' => strip_tags($post['packing_type'][$i]),
                                'product' => strip_tags($post['description_of_goods'][$i]),
                                'qty' => strip_tags($post['quantity'][$i]),
                                'rate' => strip_tags($post['rate'][$i]),
                                'amount' => strip_tags($post['amount'][$i]),
                                'date' => date('Y-m-d')
                            );
                      }     
                      if(!empty($da_items_table_array)) {
                          $this->invoiceidaitems->insertBatch($da_items_table_array); 
                      }                  
                  }
                
                  /** Advance License and EPCG Number Calculation start**/  
                  if(isset($post['ad_lic_no_array']) && !empty($post['ad_lic_no_array'])) {

                      $count = count($post['ad_lic_no_array']);
                      $license_table_array = array();
                      $invoice_lic_table_array = array();
                      for($counter = 0; $counter <= ($count- 1); $counter++) {

                           $invoice_lic_table_array[] = array(
                                'invoice_no' => $salt.md5($id),
                                'da_no' => $id,
                                'product' =>  strip_tags($post['ad_lic_no_array'][$counter]),
                                'lic_qty' => strip_tags($post['lic_quantity'][$counter]),
                                'index' => $counter
                           ); 

                           $license_table_array = array(
                                'eo_fulfilled' => (strip_tags($post['eo_fulfilled'][$counter])) + (strip_tags($post['lic_quantity'][$counter])),
                           );
                           $this->advance->update($license_table_array, array('id' => $post['ad_lic_no_array'][$counter]));
                      }

                      if(!empty($invoice_lic_table_array)) {
                          $this->iqty->insert_batch('invoice_lic_qty', $invoice_lic_table_array);
                      }
                  }
             
                  if(isset($post['epcg_lic_no_array']) && !empty($post['epcg_lic_no_array'])) {

                      $epcg_lic_details = $this->epgc_model->findOne(array('id' => $post['epcg_lic_no_array']));
                        if(!empty($epcg_lic_details)) {
                           $new_eo_fulfilled = $epcg_lic_details['eo_fulfilled'] + $total_quantity;
                           $table_array_epcg = array('eo_fulfilled' => $new_eo_fulfilled);
                           $this->epgc_model->update($table_array_epcg, array('id' => $epcg_lic_details['id']));
                      }
                  }

                     /** Advance License Number Calculation start**/

                    $da = $this->da_header->findOne(array('id' =>$id));
                    $audit_trial = array(
                        'transaction_date' => date('Y-m-d'),
                        'transaction_time' => date("H:i:s"),
                        'username' => $this->session->userdata()['username'],
                        'action' => 'Invocie added for da ---'.$da['da_no'],
                    );
                    $this->audit->insert($audit_trial);

                    $this->session->set_flashdata('success', 'Invoice generated successfully!');
                    return redirect(base_url().$this->router->fetch_class());
                    } else {
                        $this->session->set_flashdata('error', 'Unable to process the request. Please try agian later.');
                        return redirect(base_url().$this->router->fetch_class());
                    }
                  }

                  $findone = $this->da_header->findOne(array('id' =>$id) );
                  
                  $existPacking = $this->packinglist->findOne(array('da_no' =>$id) );
                  //echo "<pre>";print_r($existPacking);die;
                  if(empty($findone) ||  empty($existPacking) || empty($existPacking['manager_qa'])) {
                      $this->session->set_flashdata('info', 'Unable to process the request because packing list is not available for this DA Or approved by quality manager ');
                      return redirect(base_url().$this->router->fetch_class());
                  }
                  $data['findOne'] = $findone;

                  $da_header = $this->da_header->findHeaderItems($id);
                  $da_items = $this->da_items->findDAItemsForInvoice($id);
                  //echo "<pre>"; print_r( $da_items );die;
                  $da_document = $this->da_document->findAll(array('da_no' => $id));
                  $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));
                  $packing_list  = $this->packinglist->findAllPackingListByDa($id);
                  //echo "<pre>"; print_r($packing_list);die;
                  $net_weight = 0;
                  $gross_weight = 0;
                  $tare_weight = 0;
                  $batch_array = array();
                  $batch_no = 0;
                  $mfg_date_array = array();
                  $exp_date_array = array();
                  $mfg_date_value = 0;
                  $exp_date_value = 0;

                  if(!empty($packing_list)) {

                      $final_array = array();
                      $final_array_mfg_date = array();
                      $final_array_exp_date = array();

                     foreach ($packing_list as $j => $data) {
                        $final_array[$data['batch_no']][] = $data;  
                        $final_array_mfg_date[$data['mfg_date']][] = $data;  
                        $final_array_exp_date[$data['exp_date']][] = $data;   
                    }

                    if(!empty($final_array)) {
                      foreach($final_array as $key => $value) {
                          $batch_array[] = $key;
                      }
                    }
                    if(!empty($final_array_mfg_date)) {
                      foreach($final_array_mfg_date as $key => $value) {
                          $mfg_date_array[] = $key;
                      }
                    }
                    if(!empty($final_array_exp_date)) {
                      foreach($final_array_exp_date as $key => $value) {
                          $exp_date_array[] = $key;
                      }
                    }
                    
                    //echo "<pre>";print_r($batch_array).'<br>';
                    //echo "<pre>";print_r($batch_array).'<br>';

                    $batch_no =  implode(", ",$batch_array);
                    $mfg_date_value = implode(",",$mfg_date_array);
                    $exp_date_value = implode(", ",$exp_date_array);
                     
                    foreach($packing_list as $key => $value) { 

                        $net_weight+= $value['net_weight'];
                        $gross_weight+= $value['outer_gross_weight'];
                        $tare_weight+= $value['outer_tare_weight'];
                        
                    }

                    }

                    if(!empty($da_items)) {
                        $products = array();
                        foreach($da_items as $value) {
                         $products[] = $value['product'];
                      }
                    } 
                  
                  $license_array = $this->advance->getLicnese($products);
                  $epcg_license = $this->epgc_model->findAll();
                  $check_packing_invoice = $this->invoice_header_packing->findOne(array('da_no' => $id));
                  //echo "<pre>";print_r($da_header);die;
                  $data['da_header'] = $da_header;
                  $data['da_items'] = $da_items;
                  $data['da_document'] = $da_document;
                  $data['da_out_standing'] = $da_out_standing;
                  $data['batch_no'] = $batch_no;
                  $data['net_weight'] = $net_weight;
                  $data['gross_weight'] = $gross_weight;
                  $data['tare_weight'] = $tare_weight;
                  $data['mfg_date_value'] = $mfg_date_value;
                  $data['exp_date_value'] = $exp_date_value;
                  $data['license_array'] = $license_array;
                  $data['epcg_license'] = $epcg_license;
                  $data['packing_invoice'] = $check_packing_invoice;
                  
                  $data['pageTitle'] = 'Neclife - Commercial Invoice | Create';
                  $data['template']  = 'commercial-invoice/create-invoice-new';
                  $this->load->view('template_admin',$data);

        }

        /**
        * Function to generate commercial invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function update_invoice($id = '') {

            if(empty($id)) {
              $this->session->set_flashdata('warning', 'No direct script access allowed.');
              return redirect(base_url().$this->router->fetch_class());
            }

              $find = $this->invoiceheader->findOne(array('invoice_id' =>$id));

              if(empty($find)) {
                return redirect(base_url().$this->router->fetch_class());
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {

              if($this->sessionSelected != $this->currentSession) {
                  $this->session->set_flashdata('session-mismatch','session-mismatch');
                  return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
              }

              /********* restrict to add changes if packing list has been made  start**/

                  
            /*  $checkMadeOrNot = $this->invoice_header_packing->findOne(array('da_no' => strip_tags($post['da_no'])));
              if(!empty($checkMadeOrNot)) {
                $this->session->set_flashdata('restriction', strip_tags($post['da_no_name']));
                return redirect(base_url().$this->router->fetch_class());
              }
                */ 

              /********* restrict to add changes if packing list has been made end**/
              
              if(!empty($post['ad_lic_no_array']) && isset($post['ad_lic_no_array'])) {
                    
                    $implode_lic = implode(',', $post['ad_lic_no_array']);
                    $implode_qty = implode(',', $post['lic_quantity']);
                    $advance_lic_number = $implode_lic;
                    $advance_lic_qty = $implode_qty;
                  
                } else {
                   $advance_lic_number = '';
                   $advance_lic_qty = '';
                }
              
            //echo $advance_lic_qty;die;
             $table_array = array (
               'invoice_id' => strip_tags($post['invoice_id']),
               'invoice_type' => !empty($post['type']) ? $post['type'][0]: '',
               'financial_year' => strip_tags($post['financial_year']), 
               'address' => $post['address'],
               'buyer_order_number' => strip_tags($post['buyer_order_number']),
               'buyer_order_date' => strip_tags($post['buyer_order_date']),
               'contract_number' => strip_tags($post['contract_number']),
               'contract_date' => strip_tags($post['contract_date']),
               'da_no' => strip_tags($post['da_no']),
               'da_no_name' => strip_tags($post['da_no_name']),
               'da_date' => strip_tags($post['da_date']),
               'po_no' => strip_tags($post['po_no']),
               'lic_no' => strip_tags($post['lic_no']),
               'lic_date' => strip_tags($post['lic_date']),
               'indent_no' => strip_tags($post['indent_no']),
               'indent_date' => strip_tags($post['indent_date']),
               'invoice_no' => strip_tags($post['invoice_no_e']),
               'invoice_date' => strip_tags($post['invoice_date']),
               'export_reference' => $post['export_reference'],
               'other_reference' => strip_tags($post['other_reference']),
               'buyer' => strip_tags($post['buyer_inv']),
               'consignee' => strip_tags($post['consignee_inv']),
               'notify' => strip_tags($post['notify_inv']),
               'notify_1' => strip_tags($post['notify_1_inv']),
               'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
               'Place_of_reciept' => strip_tags($post['place_of_reciept']),
               'vessel_flight_no' => strip_tags($post['vessal_flight']),
               'port_of_loading' => strip_tags($post['port_of_loading']),
               'port_of_discharge' => strip_tags($post['port_of_discharge']),
               'final_destination' => strip_tags($post['final_destination']),
               'country' => strip_tags($post['country']),
               'term_of_delivery' => strip_tags($post['term_of_delivery']),
               'term_of_delivery1' => '',
               'payment_terms' => strip_tags($post['payment_terms']),
               'payment_terms1' => '',
               'mfg_date' => strip_tags($post['mfg_date']),
               'exp_date' => strip_tags($post['exp_date']),
               'shipping_marks' => $post['shipping_marks_inv'],
               'net_weight' => strip_tags($post['net_weight']),
               'tare_weight' => strip_tags($post['tare_weight']),
               'gross_weight' => strip_tags($post['gross_weight']),
               'declaration' => strip_tags($post['declaration']),
               'total_amount' => strip_tags($post['total_amount']) ,
               'total' => strip_tags($post['total']),
               'total_amount_words' =>  strip_tags($post['total_words']),
               'gst_per' => strip_tags($post['gst_rate_hidden']),
               'gst_amount' => strip_tags($post['gst_amount_hidden']),
               'exchange_rate' => strip_tags($post['exchange_rate']),
               'eunder_lut' => strip_tags($post['eunder_lut']),
               'taxable' => strip_tags($post['taxable']),
               'pan_number' => strip_tags($post['pan_number']),
               'batch_no' => strip_tags($post['batch_no']),
               'ie_code_no' => strip_tags($post['ie_code_no']) ,
               'ad_lic_no' =>  $advance_lic_number,
               'under_dbk' =>  strip_tags($post['under_dbk']),
               'epcg_lic_no' => isset($post['epcg_lic_no_array']) ? $post['epcg_lic_no_array'] :'',
               'license_qty_used' => $advance_lic_qty,
               'cin_no' => strip_tags($post['cin_no']),
               'gstin' => strip_tags($post['gstin']),
               'state ' => strip_tags($post['state']),
               'state_code' => strip_tags($post['state_code']),
               'tin_number' => strip_tags($post['tin_number']),
               'state_of_origin' => strip_tags($post['state_of_origin']),
               'district_code' => strip_tags($post['district_code']),
               'district_of_origin' => strip_tags($post['district_of_origin']),
               'declaretion_final' => $post['declaration_final'],
               'currency_name' => strip_tags($post['currency_name']),
               'created_by' => $this->session->userdata('admin_id'),
               'created_at' => date('Y-m-d')
           );

               //echo "<pre>";print_r($table_array);die;

            $update  = $this->invoiceheader->update($table_array, array('invoice_id'=> $id));
            //$update = 1;
            if(!empty($update)) {

                    $invoice_payment = array (
                      
                        'da_no' => strip_tags($post['da_no']) ,
                        'invoice_type' => '1',
                        'invoice_no' => strip_tags($post['invoice_no_e']) ,
                        'invoice_id' => $id ,
                        'total_amount' => strip_tags($post['total_amount']) ,
                        'balance' => strip_tags($post['total_amount']) ,
                        'da_name' => strip_tags($post['da_no_name']) ,
                        'currency_name' => strip_tags($post['currency_name']),
                        'last_modified' => date('Y-m-d'),
                        'financial_year' => strip_tags($post['financial_year']), 
                     );
                     
                     $this->invoice_payment->update($invoice_payment, array('invoice_id'=> $id));
                    
                    $prev_total_quantity = strip_tags($post['prev_total_quantity']);

                    if(!empty($post['packing_type'])) {

                        $count = count($post['packing_type']);
                        $da_items_table_array = array();
                        $total_quantity = false;
                        for($i = 0; $i <= $count - 1; $i++) {
                            $total_quantity += strip_tags($post['quantity'][$i]);
                            $da_items_table_array[] = array (
      
                                'financial_year' => $post['financial_year'],
                                'da_financial_year' => $post['financial_year'],
                                'invoice_no' => strip_tags($post['invoice_id']),
                                'da_no' => $post['da_no'],
                                'drum_nos' => strip_tags($post['drum_nos'][$i]),
                                'packing_type' => strip_tags($post['packing_type'][$i]),
                                'product' => strip_tags($post['description_of_goods'][$i]),
                                'qty' => strip_tags($post['quantity'][$i]),
                                'rate' => strip_tags($post['rate'][$i]),
                                'amount' => strip_tags($post['amount'][$i]),
                                'date' => date('Y-m-d')
                            );
                        }     
                        
                        //echo "<pre>";print_r($da_items_table_array);die;
                        if(!empty($da_items_table_array)) {

                          // $this->db->update_batch('exportinvoiceitems',$da_items_table_array,'id');
                            $this->invoiceidaitems->deleteWhere(array('da_no' => $post['da_no']));
                            $this->invoiceidaitems->insertBatch($da_items_table_array); 
                        }                  
                    }


              /** Advance License Number Calculation start**/ 

              if(!empty($post['db_lic_no'])) {
                   $db_lic = explode(',', $post['db_lic_no']);
                   $db_lic_qty = explode(',', $post['db_lic_qty']);
                   $array_combine = array_combine($db_lic, $db_lic_qty);
                   //echo "<pre>";print_r($array_combine);die;
                   if(!empty($array_combine)) {
                        foreach($array_combine as $aLicKey => $aLicValue) {
                            
                            $lic_array = $this->advance->findOne(array('id' => $aLicKey));
                            $table_array = array(
                                  'eo_fulfilled' => $lic_array['eo_fulfilled'] - $aLicValue
                            );
                            ///echo "<pre>";print_r($table_array);die;
                            $this->advance->update($table_array, array('id' => $aLicKey));
                            $this->iqty->deleteWhere(array('invoice_no' => $id));
                        } 
                   }
              }

              if(isset($post['ad_lic_no_array']) && !empty($post['ad_lic_no_array'])) {
                      
                      $count = count($post['ad_lic_no_array']);
                      $license_table_array = array();
                      $invoice_lic_table_array = array();

                      for($counter = 0; $counter <= ($count- 1); $counter++) {
                           
                           $invoice_lic_table_array[] = array(
                                'invoice_no' => $id,
                                'da_no' => strip_tags($post['da_no']),
                                'product' =>  strip_tags($post['ad_lic_no_array'][$counter]),
                                'lic_qty' => strip_tags($post['lic_quantity'][$counter]),
                                'index' => $counter
                           ); 

                           $db_eo = $this->advance->findOne(array('id' => $post['ad_lic_no_array'][$counter]));

                           $license_table_array = array(
                                'eo_fulfilled' => $db_eo['eo_fulfilled'] + (strip_tags($post['lic_quantity'][$counter])),
                           );
                           $this->advance->update($license_table_array, array('id' => $post['ad_lic_no_array'][$counter]));
                      }

                      if(!empty($invoice_lic_table_array)) {
                          $this->iqty->insert_batch('invoice_lic_qty', $invoice_lic_table_array);
                      }
                  }


                if(isset($post['epcg_lic_no_array'])) {
                        $epgc_license = $post['epcg_lic_no_array'];
                  } else {
                        $epgc_license = '';
                }

                if($epgc_license != $post['db_epcg_lic']) {
                    $epcg_lic_details_pre = $this->epgc_model->findOne(array('id' => $post['db_epcg_lic']));

                    if(!empty($epcg_lic_details_pre)) {

                       $new_eo_fulfilled = $epcg_lic_details_pre['eo_fulfilled'] - $prev_total_quantity;
                       $table_array = array('eo_fulfilled' => $new_eo_fulfilled);
                       $ii = $this->epgc_model->update($table_array, array('id' => $epcg_lic_details_pre['id']));
                   }

                   $epcg_lic_details = $this->epgc_model->findOne(array('id' => $epgc_license));
                   if(!empty($epcg_lic_details)) {
                       $new_eo_fulfilled = $epcg_lic_details['eo_fulfilled'] + $total_quantity;
                       $table_array = array('eo_fulfilled' => $new_eo_fulfilled);
                       $this->epgc_model->update($table_array, array('id' => $epgc_license));
                   }
                }

                /** Advance License Number Calculation start**/

                $num = $this->invoice->findOne(array('invoice_id' =>$id));
                $da = $this->da_header->findOne(array('id' =>$num['da_no']));
                                        //echo "<pre>";print_r($da);die;
                $audit_trial = array(
                    'transaction_date' => date('Y-m-d'),
                    'transaction_time' => date("H:i:s"),
                    'username' => $this->session->userdata()['username'],
                    'action' => 'Invocie updated for da ---'.$da['da_no'],
                );
                $this->audit->insert($audit_trial);

                $this->session->set_flashdata('success','Invoice update successfully!');
                return redirect(base_url().$this->router->fetch_class());
                } else {

                    $this->session->set_flashdata('error','Unable to process your request.Please try again later.');
                    return redirect(base_url().$this->router->fetch_class());
                }
                }

                $invoice_items = $this->invoiceidaitems->findAll(array('invoice_no' => $find['invoice_id']));

                $da_items = $this->da_items->findDAItems(array('da_no' => $invoice_items[0]['da_no']));

                if(!empty($da_items)) {
                    $products = array();
                    foreach($da_items as $value) {
                     $products[] = $value['product'];
                 }
                } 

                $license_array = $this->advance->getLicnese($products);
                $epcg_license = $this->epgc_model->findAll();
                $data['invoice_data'] = $find;
                $data['da_items'] = $invoice_items;
                $data['license_array'] = $license_array;
                $data['epcg_license'] = $epcg_license;

                $data['pageTitle'] = 'Neclife - Commercial Invoice | Update Invocie';
                $data['template']  = 'commercial-invoice/update-invoice';
                $this->load->view('template_admin',$data);

        }

        /**
        * Function to generate packinglist invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function download_invoice($type = '', $id ='') {

            $data = array();
            
            $invoice_data =  $this->invoiceheader->getInvoiceData($id);

            if(empty($invoice_data)) {
              $this->session->set_flashdata('error', 'No direct script access allowed.');
              return redirect(base_url().$this->router->fetch_class());
            }

            $invoice_da_items =  $this->invoiceidaitems->findAll(array('invoice_no' => $invoice_data[0]['invoice_id']));
            $explode_lic = explode(',', $invoice_data[0]['ad_lic_no']); 
            $license_nos = $this->advance->getLicneseOne($explode_lic);

               if(!empty($license_nos)) {
                    $lic_name = array();
                    foreach ($license_nos as $key => $value) {
                       $lic_name[] = $value['lic_no'];
                   }
               }

               $implode_lic = !empty($lic_name) ? implode(', ',  $lic_name) : '';
               $invoice_creator_info = $this->admin_model->findOne(array('id' => $invoice_data[0]['created_by']));

               $data['advance_lic_no'] =  $implode_lic;
               $data['invoice_data'] = $invoice_data[0];
               $data['invoice_da_items'] = $invoice_da_items;
               $data['user_info'] = $invoice_creator_info;
              
               $explode_batch = explode(',', $invoice_data[0]['batch_no']);
               $explode_mfg = explode(',', $invoice_data[0]['mfg_date']);
               $explode_exp = explode(',', $invoice_data[0]['exp_date']);

                $result = array_map(function ($explode_batch, $explode_mfg, $explode_exp) {
                return array_combine(
                    ['batch', 'mfg', 'exp'],
                    [$explode_batch, $explode_mfg, $explode_exp]
                  );
                }, $explode_batch, $explode_mfg, $explode_exp);
              
                if(!empty($result)) {
                  $combined_array = array();
                  foreach($result as $key => $res) {
                         $combined_array[trim($res['exp'].'/'.$res['mfg'])][] = $res['batch'];
                  }
                }

              //echo "<pre>"; print_r($combined_array);die;
                
               $data['combined_data'] = $combined_array;

               if(!empty($type)) {
                if($type =='customs') {
                    $data['pageTitle'] = 'Neclife - Commercial Invoice | Download Customs Invoice';
                    $data['template']  = 'commercial-invoice/create-invoice';
                } else {
                    $data['pageTitle'] = 'Neclife - Commercial Invoice | Download Customer Invoice';
                    $data['template']  = 'commercial-invoice/customer/create-invoice';
                }
            } else {
                $this->session->set_flashdata('info', 'Unable to process the request something went wrong. Please refresh the page and try again.');
                return redirect(base_url().$this->router->fetch_class());
            }
            $this->load->view('template_admin',$data);
        }

        /**
        * Function to commercial_invoice_pdf
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function commercial_invoice_pdf($type = '', $id ='') {

              $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
              $mpdf->SetDisplayMode('fullwidth');
              //$mpdf->autoPageBreak = false;
              $data = array();
              $invoice_data =  $this->invoiceheader->getInvoiceData($id);
              
              if(empty($invoice_data)) {
                  $this->session->set_flashdata('error', 'No direct script access allowed.');
                  return redirect(base_url().$this->router->fetch_class());
              }

              $invoice_da_items =  $this->invoiceidaitems->findAll(array('invoice_no' => $invoice_data[0]['invoice_id']));
              $explode_lic = explode(',', $invoice_data[0]['ad_lic_no']); 
              $license_nos = $this->advance->getLicneseOne($explode_lic);

              if(!empty($license_nos)) {
                    $lic_name = array();
                    foreach ($license_nos as $key => $value) {
                       $lic_name[]= $value['lic_no'];
                   }
              }
              $implode_lic = !empty($lic_name) ? implode(', ',  $lic_name) : '';
              $invoice_creator_info = $this->admin_model->findOne(array('id' => $invoice_data[0]['created_by']));

              $data['advance_lic_no'] =  $implode_lic;
              $data['invoice_data'] = $invoice_data[0];
              $data['invoice_da_items'] = $invoice_da_items;
              $data['user_info'] = $invoice_creator_info;
                     $explode_batch = explode(',', $invoice_data[0]['batch_no']);
               $explode_mfg = explode(',', $invoice_data[0]['mfg_date']);
               $explode_exp = explode(',', $invoice_data[0]['exp_date']);

                $result = array_map(function ($explode_batch, $explode_mfg, $explode_exp) {
                return array_combine(
                    ['batch', 'mfg', 'exp'],
                    [$explode_batch, $explode_mfg, $explode_exp]
                  );
                }, $explode_batch, $explode_mfg, $explode_exp);
              
                if(!empty($result)) {
                  $combined_array = array();
                  foreach($result as $key => $res) {
                         $combined_array[trim($res['exp'].'/'.$res['mfg'])][] = $res['batch'];
                  }
                }

              //echo "<pre>"; print_r($combined_array);die;
                
               $data['combined_data'] = $combined_array;
              if(!empty($type)) {
                if($type =='customs') {
                    $html = $this->load->view('commercial-invoice/commercial-pdf', $data , true);
                    $filename = $invoice_data[0]['da_no_name'].'-Customs-Commercial-Invoice.pdf';
                } else {
                    $html = $this->load->view('commercial-invoice/customer/commercial-pdf', $data , true);
                    $filename = $invoice_data[0]['da_no_name'].'-Customer-Commercial-Invoice.pdf';
                }
              } else {
                  $this->session->set_flashdata('info', 'Unable to process the request something went wrong. Please refresh the page and try again.');
                  return redirect(base_url().$this->router->fetch_class());
              }
              $mpdf->WriteHTML($html);
              $mpdf->Output($filename, 'D'); 
        }

        /**
        * Function to delete the invoice and open the invoice to re-generate again.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function delete_invoice($id = '') {

          if(!empty($id)) {
            $findOne = $this->invoiceheader->findOne(array('invoice_id' => $id));
            $deleted = $this->invoiceheader->deleteWhere(array('invoice_id' => $id));
             
            if(!empty($deleted)) {
              
                /************ invoice payment *************/
                
                 $this->invoice_payment->deleteWhere(array('invoice_id' => $id));
                 $this->invoice_payment_map->deleteWhere(array('invoice_id' => $id));

               /********* update advance licnese on delete ***********/
                 $delete = $this->invoiceidaitems->deleteWhere(array('invoice_no' => $id));
                 $this->iqty->deleteWhere(array('invoice_no' => $id));
              
                 $db_lic = explode(',', $findOne['ad_lic_no']);
                 $db_lic_qty = explode(',', $findOne['license_qty_used']);
                 $array_combine = array_combine($db_lic, $db_lic_qty);
                 //echo "<pre>";print_r($array_combine);die;
                 if(!empty($array_combine)) {
                      foreach($array_combine as $aLicKey => $aLicValue) {
                          
                      if(!empty($aLicKey)){
                          $lic_array = $this->advance->findOne(array('id' => $aLicKey));
                          $table_array = array(
                                'eo_fulfilled' => $lic_array['eo_fulfilled'] - $aLicValue
                          );
                          //echo "<pre>";print_r($table_array);die;
                          $this->advance->update($table_array, array('id' => $aLicKey));
                        }
                      } 
                 }
           
  
                /********* update epcg licnese on delete ***********/
                $epcg_lic_details_pre = $this->epgc_model->findOne(array('id' => $findOne['epcg_lic_no']));
                if(!empty($epcg_lic_details_pre)) {
                   $new_eo_fulfilled = $epcg_lic_details_pre['eo_fulfilled'] - 1;
                   $table_array = array('eo_fulfilled' => $new_eo_fulfilled);
                   $ii = $this->epgc_model->update($table_array, array('id' => $epcg_lic_details_pre['id']));
               }

           $response = array('success' => 'Commercial Invoice of '.$findOne['da_no_name'].' ready to regenerate.', 'id' => $findOne['da_no'] , 'url'=> base_url().'commercial_invoice/generate_invoice/'.$findOne['da_no']);
           echo json_encode($response);die;

           } else {
                $response = array('error' => 'Bad Request.');
                echo json_encode($response);die;
           }
        } else {
                $response = array('error' => 'Bad Request.');
                echo json_encode($response);die;
        }
        }


        /*
        | -------------------------------------------------------------------------
        | COMMERCIAL INVOICE SECTION END 
        | -------------------------------------------------------------------------
        |
        |
        |
        |
        | -------------------------------------------------------------------------
        | PACKING LIST INVOICE SECTION START 
        | -------------------------------------------------------------------------
        | 
        | All packing list invoice functions enclosed in this section
        |
        |
        |
        */

        /**
        * Function to packing list invoice .
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_invoice() {

            if ($this->session->userdata('error')) {
                 $this->session->unset_userdata('error');
            }

               $data = array();
               $post = $this->input->post();
               if(!empty($post)) {
                   $where = $post['buyer'];
               } else {
                $where = null;
            }
            $da_entry_list = $this->da_header->da_entry_packing_list($where, array('cancelled' => 0),array('type' => 0));
                    //echo "<pre>";print_r($da_entry_list);die;
             if(empty($da_entry_list)) {
                 $this->session->set_flashdata('error','No Record Found.');
             }

             $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
             $data['da_entry'] = $da_entry_list;

             $data['pageTitle'] = 'Neclife - Commercial Invoice | Packing List';
             $data['template']  = 'commercial-invoice/packing/index';
             $this->load->view('template_admin',$data);
         }

        /**
        * Function to generate packing list invoice .
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */
        public function generate_packing_invoice($id = '') {

            if(empty($id)) {
              $this->session->set_flashdata('warning', 'No direct script access allowed.');
              return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
            }
              $data = array();
              $post = $this->input->post();
              if(!empty($post)) {

                  if($this->sessionSelected != $this->currentSession) {
                      $this->session->set_flashdata('session-mismatch','session-mismatch');
                      return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
                  }
                  
                    //echo "<pre>";print_r($post);die;
                  $salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 11);
                  $table_array = array (
                   'invoice_id' => $salt.md5($id),
                   'invoice_type' =>'2',
                   'financial_year' => strip_tags($post['financial_year']), 
                   'address' => $post['address'],
                   'buyer_order_number' => strip_tags($post['buyer_order_number']),
                   'buyer_order_date' => strip_tags($post['buyer_order_date']),
                   'contract_number' => strip_tags($post['contract_number']),
                   'contract_date' => strip_tags($post['contract_date']),
                   'da_no' => $id,
                   'da_no_name' => strip_tags($post['da_no']),
                   'da_date' => strip_tags($post['da_date']),
                   'po_no' => strip_tags($post['po_no']),
                   'lic_no' => strip_tags($post['lic_no']),
                   'lic_date' => strip_tags($post['lic_date']),
                   'indent_no' => strip_tags($post['indent_no']),
                   'indent_date' => strip_tags($post['indent_date']),
                   'invoice_no' => strip_tags($post['invoice_no']),
                   'invoice_date' => strip_tags($post['invoice_date']),
                   'export_reference' => $post['export_reference'],
                   'other_reference' => strip_tags($post['other_reference']),
                   'buyer' => strip_tags($post['buyer_inv']),
                   'consignee' => strip_tags($post['consignee_inv']),
                   'notify' => strip_tags($post['notify_inv']),
                   'notify_1' => strip_tags($post['notify_1_inv']),
                   'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
                   'Place_of_reciept' => strip_tags($post['place_of_reciept']),
                   'vessel_flight_no' => strip_tags($post['vessal_flight']),
                   'port_of_loading' => strip_tags($post['port_of_loading']),
                   'port_of_discharge' => strip_tags($post['port_of_discharge']),
                   'final_destination' => strip_tags($post['final_destination']),
                   'country' => strip_tags($post['country']),
                   'term_of_delivery' => strip_tags($post['term_of_delivery']),
                   'term_of_delivery1' => '',
                   'payment_terms' => strip_tags($post['payment_terms']),
                   'payment_terms1' => '',
                   'mfg_date' => strip_tags($post['mfg_date']),
                   'exp_date' => strip_tags($post['exp_date']),
                   'shipping_marks' => strip_tags($post['shipping_marks_inv']), 
                   'batch_no' => strip_tags($post['batch_no']),
                   'declaretion_final' => $post['declaration_final'],
                   'created_by' => $this->session->userdata('admin_id'),
                   'created_at' => date('Y-m-d'),

               );
              //echo "<pre>";print_r($table_array);die;
              $insert = $this->invoice_header_packing->insert($table_array);
              //$insert = 1;

              if(!empty($insert)) {

                if(!empty($post['packing_type'])) {

                   $count = count($post['packing_type']);
                   $da_items_table_array = array();
                   for($i = 0; $i <= $count - 1; $i++) {

                    $da_items_table_array[] = array (
                        'financial_year' => $post['financial_year'],

                        'invoice_no' => $salt.md5($id),
                        'da_no' => $id,
                        'drum_nos' => strip_tags($post['drum_nos'][$i]),
                        'packing_type' => strip_tags($post['packing_type'][$i]),
                        'product' => strip_tags($post['description_of_goods'][$i]),
                        'excise_sr_no' => strip_tags($post['excise_sr_no'][$i]),
                        'box_no' => strip_tags($post['box_no'][$i]),
                        'total_no_boxes' => strip_tags($post['total_no_boxes'][$i]),
                        'total_no_packs' => strip_tags($post['total_no_packs'][$i]),
                        'batch_no' => strip_tags($post['batch_nos'][$i]),
                        'net_weight' => strip_tags($post['net_weight'][$i]),
                        'outer_gross_weight' => strip_tags($post['outer_gross_weight'][$i]),
                        'date' => date('Y-m-d'),
                        'seal_no' => strip_tags($post['seal_no'][$i])
                    );
                }     

                //echo "<pre>"; print_r($da_items_table_array);die;
                if(!empty($da_items_table_array)) {
                   $this->invoiceipackinglist->insertBatch($da_items_table_array); 
               }                  
           } else {

            if(!empty($_FILES['packing_excel']['name'])){

                $file_name = $post['da_no'].'-'.$post['financial_year'].'-'.time().'-'.$_FILES['packing_excel']['name'];
                $config['upload_path'] = 'packing-invoice-file/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $file_name;

                                    //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('packing_excel')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

                }else {

                    $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                    return redirect(base_url().$this->router->fetch_class().'/add_packing_list_form/'.$id.'/'.$itemId);
                    $picture = '';
                }
                } else { 

                    $filepath = 'resources/packing-list-import/'.$post['db-file-name'];
                    $new_location = 'resources/packing-invoice-file/'.$post['db-file-name'];
                    if (copy($filepath, $new_location)) {
                        $picture = $post['db-file-name'];

                    } else {
                     $this->session->set_flashdata('error', 'Unable to move the file to new location.');
                     return redirect(base_url().$this->router->fetch_class().'/add_packing_list_form/'.$id.'/'.$itemId);
                 }
             }

             $sub_table_array = array(
                 'import_file' => $picture,
                 'financial_year' => $post['financial_year'],
                 'invoice_no' => $salt.md5($id),
                 'da_no' => $id,
                 'date' => date('Y-m-d')
             );

             $this->invoiceipackinglist->insert($sub_table_array);
                }

                 $da = $this->da_header->findOne(array('id' =>$id));
                 $audit_trial = array(
                   'transaction_date' => date('Y-m-d'),
                   'transaction_time' => date("H:i:s"),
                   'username' => $this->session->userdata()['username'],
                   'action' => 'packing list invoice added for da ---'.$da['da_no'],
               );
                 $this->audit->insert($audit_trial);

                 $this->session->set_flashdata('success', 'Invoice generated successfully!');
                 return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
             } else {
                $this->session->set_flashdata('error', 'Unable to process the request. Please try agian later.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
            }
        }

        $findone = $this->da_header->findOne(array('id' =>$id) );
        $existPacking = $this->packinglist->findOne(array('da_no' =>$id) );

        if(empty($findone) ||  empty($existPacking) || empty($existPacking['manager_qa'])) {
            $this->session->set_flashdata('info', 'Unable to process the request because packing list is not available for this DA.');
            return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
        }
        $data['findOne'] = $findone;

        $da_header = $this->da_header->findHeaderItems($id);

        $da_items = $this->da_items->findDAItems(array('da_no' => $id));
        $da_document = $this->da_document->findAll(array('da_no' => $id));
        $da_out_standing = $this->outstanding->findAll(array('da_no' => $id));

        $packing_list  = $this->packinglist->findAllPackingListByDa($id);

        //echo "<pre>"; print_r($this->db->last_query());die;
        $net_weight = 0;
        $gross_weight = 0;
        $tare_weight = 0;
        $batch_array = array();
        $batch_no = 0;

        $mfg_date_array = array();
        $exp_date_array = array();

        $mfg_date_value = 0;
        $exp_date_value = 0;
        if(!empty($packing_list)) {

            $final_array = array();
            $final_array_mfg_date = array();
            $final_array_exp_date = array();
            foreach ($packing_list as $j => $data) {
                  $final_array[$data['batch_no']][]=$data;   
            }

            if(!empty($final_array)) {
               foreach($final_array as $key => $value) {
                    $batch_array[] = $key;
            }
            if(!empty($final_array_mfg_date)) {
                foreach($final_array_mfg_date as $key => $value) {
                          $mfg_date_array[] = $key;
                }
            }
            if(!empty($final_array_exp_date)) {
              foreach($final_array_exp_date as $key => $value) {
                          $exp_date_array[] = $key;
              }
            }
        }


        $batch_no =  implode(", ",$batch_array);

          foreach($packing_list as $key => $value) { 
              $net_weight+= $value['net_weight'];
              $gross_weight+= $value['outer_gross_weight'];
              $tare_weight+= $value['outer_tare_weight'];
            
          }
        }

        $batch_no =  implode(", ",$batch_array);
        $mfg_date_value = implode(",",$mfg_date_array);
        $exp_date_value = implode(", ",$exp_date_array);

        if(!empty($da_items)) {
            $products = array();
            foreach($da_items as $value) {
             $products[] = $value['product'];
         }
        } 
        $check_commercial_invoice = $this->invoiceheader->findOne(array('da_no' => $id));

        $data['da_header'] = $da_header;
        $data['da_items'] = $da_items;
        $data['da_document'] = $da_document;
        $data['da_out_standing'] = $da_out_standing;
        $data['packing_list'] = $packing_list;
        $data['batch_no'] = $batch_no;
        $data['net_weight'] = $net_weight;
        $data['gross_weight'] = $gross_weight;
        $data['tare_weight'] = $tare_weight;
        $data['mfg_date_value'] = $mfg_date_value;
        $data['exp_date_value'] = $exp_date_value;
        $data['packing_invoice'] = $check_commercial_invoice;
                    //echo "<pre>";print_r($packing_list);die;
        $data['pageTitle'] = 'Neclife - Commercial Invoice | Packing list';
        $data['template']  = 'commercial-invoice/packing/create-invoice';
        $this->load->view('template_admin',$data);

        }

        /**
        * Function to generate commercial invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function update_packinglist_invoice($id = '') {

            if(empty($id)) {
                  $this->session->set_flashdata('warning', 'No direct script access allowed.');
                  return redirect(base_url().$this->router->fetch_class());
              }

              $find = $this->invoice_header_packing->findOne(array('invoice_id' =>$id));

              if(empty($find)) {
                return redirect(base_url().$this->router->fetch_class());
            }

            $data =array();
            $post = $this->input->post();

            if(!empty($post)) {

                //echo "<pre>";print_r($post);die;
                if($this->sessionSelected != $this->currentSession) {
                  $this->session->set_flashdata('session-mismatch','session-mismatch');
                  return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
              }

              /********* restrict to add changes if packing list has been made  start**/

           /*   $checkMadeOrNot = $this->invoiceheader->findOne(array('da_no' => strip_tags($post['da_no'])));
              if(!empty($checkMadeOrNot)) {
                $this->session->set_flashdata('restriction', strip_tags($post['da_no_name']));
                return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
              }*/
                
              /********* restrict to add changes if packing list has been made end**/

              $table_array = array (
               'invoice_id' => $id,
               'invoice_type' =>'2',
               'financial_year' => strip_tags($post['financial_year']), 
               'address' => $post['address'],
               'buyer_order_number' => strip_tags($post['buyer_order_number']),
               'buyer_order_date' => strip_tags($post['buyer_order_date']),
               'contract_number' => strip_tags($post['contract_number']),
               'contract_date' => strip_tags($post['contract_date']),
               'da_no' => $post['da_no'],
               'da_no_name' => strip_tags($post['da_no_name']),
               'da_date' => strip_tags($post['da_date']),
               'po_no' => strip_tags($post['po_no']),
               'lic_no' => strip_tags($post['lic_no']),
               'lic_date' => strip_tags($post['lic_date']),
               'indent_no' => strip_tags($post['indent_no']),
               'indent_date' => strip_tags($post['indent_date']),
               'invoice_no' => strip_tags($post['invoice_no_e']),
               'invoice_date' => strip_tags($post['invoice_date']),
               'export_reference' => $post['export_reference'],
               'other_reference' => strip_tags($post['other_reference']),
               'buyer' => strip_tags($post['buyer_inv']),
               'consignee' => strip_tags($post['consignee_inv']),
               'notify' => strip_tags($post['notify_inv']),
               'notify_1' => strip_tags($post['notify_1_inv']),
               'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
               'Place_of_reciept' => strip_tags($post['place_of_reciept']),
               'vessel_flight_no' => strip_tags($post['vessal_flight']),
               'port_of_loading' => strip_tags($post['port_of_loading']),
               'port_of_discharge' => strip_tags($post['port_of_discharge']),
               'final_destination' => strip_tags($post['final_destination']),
               'country' => strip_tags($post['country']),
               'term_of_delivery' => strip_tags($post['term_of_delivery']),
               'term_of_delivery1' => '',
               'payment_terms' => strip_tags($post['payment_terms']),
               'payment_terms1' => '',
               'mfg_date' => strip_tags($post['mfg_date']),
               'exp_date' => strip_tags($post['exp_date']),
               'shipping_marks' => strip_tags($post['shipping_marks_inv']), 
               'batch_no' => strip_tags($post['batch_no']),
               'declaretion_final' => $post['declaration_final'],
               'created_by' => $this->session->userdata('admin_id'),
               'created_at' => date('Y-m-d'),
           );

                   //echo "<pre>";print_r($table_array);'<br>';
              $update  = $this->invoice_header_packing->update($table_array, array('invoice_id'=>$id));

              if(!empty($update)) {

                if(!empty($post['packing_type'])) {

                  $count = count($post['packing_type']);
                  $da_items_table_array = array();
                  for($i = 0; $i <= $count - 1; $i++) {

                    $da_items_table_array[] = array (
                        'financial_year' => $post['financial_year'],
                        'invoice_no' => $id,
                        'da_no' => $post['da_no'],
                        'drum_nos' => strip_tags($post['drum_nos'][$i]),
                        'packing_type' => strip_tags($post['packing_type'][$i]),
                        'product' => strip_tags($post['description_of_goods'][$i]),
                        'excise_sr_no' => strip_tags($post['excise_sr_no'][$i]),
                        'box_no' => strip_tags($post['box_no'][$i]),
                        'total_no_boxes' => strip_tags($post['total_no_boxes'][$i]),
                        'total_no_packs' => strip_tags($post['total_no_packs'][$i]),
                        'batch_no' => strip_tags($post['batch_nos'][$i]),
                        'net_weight' => strip_tags($post['net_weight'][$i]),
                        'outer_gross_weight' => strip_tags($post['outer_gross_weight'][$i]),
                        'date' => date('Y-m-d'),
                        'seal_no' => strip_tags($post['seal_no'][$i])
                    );
                }     
                            
                if(!empty($da_items_table_array)) {
                  $this->invoiceipackinglist->deleteWhere(array('da_no' => $post['da_no']));
                  $this->invoiceipackinglist->insertBatch($da_items_table_array); 
              }                  
          } else {

           if(!empty($_FILES['packing_excel']['name'])){
                 
                unlink('resources/packing-invoice-file/'.$post['db-file-name']);

                $file_name = $post['da_no_name'].'-'.time().'-'.$_FILES['packing_excel']['name'];
                $config['upload_path'] = 'resources/packing-invoice-file/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $file_name;

                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('packing_excel')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];

                }else {

                    $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                    return redirect(base_url().$this->router->fetch_class().'/update_packinglist_invoice/'.$id);
                    $picture = '';
                }
            } else { 
                
                    $picture = $post['db-file-name'];
                }
                
                $sub_table_array = array(
                     'import_file' => $picture,
                     'financial_year' => $post['financial_year'],
                     'invoice_no' => $id,
                     'da_no' => $id,
                     'date' => date('Y-m-d')
                 );
                    $this->invoiceipackinglist->update($sub_table_array, array('invoice_no' => $id));
            }

            $num = $this->invoice->findOne(array('invoice_id' =>$id));
            $da = $this->da_header->findOne(array('id' =>$num['da_no']));
                                    //echo "<pre>";print_r($da);die;
            $audit_trial = array(
               'transaction_date' => date('Y-m-d'),
               'transaction_time' => date("H:i:s"),
               'username' => $this->session->userdata()['username'],
               'action' => 'Invocie updated for da ---'.$da['da_no'],
            );
            $this->audit->insert($audit_trial);

            $this->session->set_flashdata('success','Invoice update successfully!');
            return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
            } else {
                $this->session->set_flashdata('error','Unable to process your request.Please try again later.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
              }
            }

            $packing_list = $this->invoiceipackinglist->findAll(array('invoice_no' => $find['invoice_id']));
            $data['invoice_data'] = $find;
            $data['packing_list'] = $packing_list;

            $data['pageTitle'] = 'Neclife - Invoice | Update Packing List Invocie';
            $data['template']  = 'commercial-invoice/packing/update-invoice';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function to generate packinglist invoice.
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

        public function download_packing_invoice($type ='' ,$id ='') {

            $data = array();
            
             $invoice_data =  $this->invoice_header_packing->findOne(array('invoice_id' => $id));
            
             if(empty($invoice_data)) {
                $this->session->set_flashdata('error', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class());
             }
              
              $showSealNo = $this->packinglist->findOne(array('da_no' => $invoice_data['da_no']));
              $data['show_seal_no'] =  !empty($showSealNo['show_seal_no']) ? $showSealNo['show_seal_no'] : '0';

              $invoice_packing_list  = $this->invoiceipackinglist->findAll(array('invoice_no' => $invoice_data['invoice_id']));

              $da_type = $this->da_header->findOne(array('id' => $invoice_data['da_no']));
              $data['invoice_datype'] = $da_type['da_type'];
               
              if(!empty($invoice_packing_list[0]['import_file'])) {
        
               $this->load->library('Excel');
               $filename = 'resources/packing-invoice-file/'.$invoice_packing_list[0]['import_file'];
               $objPHPExcel = PHPExcel_IOFactory::load($filename);

               $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
               
               $arrayCount = count($allDataInSheet); 
               $packingArray = array();

               for($i = 2; $i<= $arrayCount; $i++)
                {                   
                    $packingArray[$i]['marks_n_drums'] = $allDataInSheet[$i]["A"];
                    $packingArray[$i]['packing_type'] = $allDataInSheet[$i]["B"];
                    $packingArray[$i]['product'] = $allDataInSheet[$i]["C"];
                    $packingArray[$i]['drum_nos'] = $allDataInSheet[$i]["D"];
                    $packingArray[$i]['batch'] = $allDataInSheet[$i]["E"];
                    $packingArray[$i]['net_weight'] = $allDataInSheet[$i]["F"];
                    $packingArray[$i]['gross_weight'] = $allDataInSheet[$i]["G"];

                    if( isset($allDataInSheet[$i]["H"])) {
                      $this->session->set_flashdata('file_error','We are not able to process the request because you have uplaoded the wrong formatted file. Please re-uploaded the file by updating the invoice and proceed further.');
                      return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
                    }
                }

                $data['invoice_packing_list'] = $packingArray;
                $data['import'] = true;
            
              } else {

                      $first_element = reset($invoice_packing_list);
                      $last_element = end($invoice_packing_list);
                      $drum_nos = $first_element['drum_nos'].' to '.$last_element['drum_nos'];
                      $data['invoice_packing_list'] = $invoice_packing_list;
                      $data['drum_nos'] = $drum_nos;
              }

               //echo "<pre>"; print_r($packingArray);die;

              $invoice_creator_info = $this->admin_model->findOne(array('id' => $invoice_data['created_by']));
              
              $data['invoice_data'] = $invoice_data;
              $data['user_info'] = $invoice_creator_info;

              $explode_batch = explode(',', $invoice_data['batch_no']);
              $explode_mfg = explode(',', $invoice_data['mfg_date']);
              $explode_exp = explode(',', $invoice_data['exp_date']);

              $result = array_map(function ($explode_batch, $explode_mfg, $explode_exp) {
                return array_combine(
                    ['batch', 'mfg', 'exp'],
                    [$explode_batch, $explode_mfg, $explode_exp]
                  );
                }, $explode_batch, $explode_mfg, $explode_exp);
              
                if(!empty($result)) {
                  $combined_array = array();
                  foreach($result as $key => $res) {
                         $combined_array[trim($res['exp'].'/'.$res['mfg'])][] = $res['batch'];
                  }
                }
              //echo "<pre>"; print_r($combined_array);die;
               $data['combined_data'] = $combined_array;

              if(!empty($type)) {
                if($type =='customs') {
                   $data['pageTitle'] = 'Neclife - Invoice | Download Customs Packing List Invoice';
                   $data['template']  = 'commercial-invoice/packing/invoice';
               } else {
                   $data['pageTitle'] = 'Neclife - Invoice | Download Customer Packing List Invoice';
                   $data['template']  = 'commercial-invoice/packing/customer/invoice';
               }
            } else {
                $this->session->set_flashdata('info', 'Unable to process the request something went wrong. Please refresh the page and try again.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
            }
            $this->load->view('template_admin',$data);
        }      

        /**
        * Function to commercial_invoice_pdf
        * @param 
        * Created On:  19-june-2020
        * Created By:  karan.parihar@ids
        */

         public function packinglist_invoice_pdf($type = '', $id ='') {

                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'debug' => true, 'allow_output_buffering' => true]);
                    $data = array();
                    $invoice_data =  $this->invoice_header_packing->findOne(array('invoice_id' => $id));

                     $showSealNo = $this->packinglist->findOne(array('da_no' => $invoice_data['da_no']));

                     $data['show_seal_no'] =  !empty($showSealNo['show_seal_no']) ? $showSealNo['show_seal_no'] : '0';

                     $da_type = $this->da_header->findOne(array('id' => $invoice_data['da_no']));
                     $data['invoice_datype'] = $da_type['da_type'];
                     if(empty($invoice_data)) {
                          $this->session->set_flashdata('error', 'No direct script access allowed.');
                          return redirect(base_url().$this->router->fetch_class());
                      }

                  $invoice_packing_list  = $this->invoiceipackinglist->findAll(array('invoice_no' => $invoice_data['invoice_id']));

                  if(!empty($invoice_packing_list[0]['import_file'])) {
        
                       $this->load->library('Excel');

                       $filename = 'resources/packing-invoice-file/'.$invoice_packing_list[0]['import_file'];
                       $objPHPExcel = PHPExcel_IOFactory::load($filename);
                       $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                       $arrayCount = count($allDataInSheet); 
                       $packingArray = array();

                       for($i = 2; $i<= $arrayCount; $i++)
                        {                   
                            $packingArray[$i]['marks_n_drums'] = $allDataInSheet[$i]["A"];
                            $packingArray[$i]['packing_type'] = $allDataInSheet[$i]["B"];
                            $packingArray[$i]['product'] = $allDataInSheet[$i]["C"];
                            $packingArray[$i]['drum_nos'] = $allDataInSheet[$i]["D"];
                            $packingArray[$i]['batch'] = $allDataInSheet[$i]["E"];
                            $packingArray[$i]['net_weight'] = $allDataInSheet[$i]["F"];
                            $packingArray[$i]['gross_weight'] = $allDataInSheet[$i]["G"];

                            /*if( isset($allDataInSheet[$i]["H"])) {
                              $this->session->set_flashdata('file_error','We are not able to process the request because you have uplaoded the wrong formatted file. Please re-uploaded the file by updating the invoice and proceed further.');
                              return redirect(base_url().$this->router->fetch_class().'/packing_list_invoice');
                            }*/
                        }
                            $data['invoice_packing_list'] = $packingArray;
                            $data['import'] = true;

                      } else {
                            $first_element = reset($invoice_packing_list);
                            $last_element = end($invoice_packing_list);
                            $drum_nos = $first_element['drum_nos'].' to '.$last_element['drum_nos'];
                            $data['invoice_packing_list'] = $invoice_packing_list;
                            $data['drum_nos'] = $drum_nos;
                      }

                      $invoice_creator_info = $this->admin_model->findOne(array('id' => $invoice_data['created_by']));
                      $data['invoice_data'] = $invoice_data;
                      $data['user_info'] = $invoice_creator_info;

                      $explode_batch = explode(',', $invoice_data['batch_no']);
                      $explode_mfg = explode(',', $invoice_data['mfg_date']);
                      $explode_exp = explode(',', $invoice_data['exp_date']);

                      $result = array_map(function ($explode_batch, $explode_mfg, $explode_exp) {
                        return array_combine(
                            ['batch', 'mfg', 'exp'],
                            [$explode_batch, $explode_mfg, $explode_exp]
                          );
                        }, $explode_batch, $explode_mfg, $explode_exp);
                      
                        if(!empty($result)) {
                          $combined_array = array();
                          foreach($result as $key => $res) {
                                 $combined_array[trim($res['exp'].'/'.$res['mfg'])][] = $res['batch'];
                          }
                        }
                      $data['combined_data'] = $combined_array;

                      if(!empty($type)) {
                        if($type =='customs') {
                            $html = $this->load->view('commercial-invoice/packing/packing-invoice-pdf', $data , true);
                            $filename = $invoice_data['da_no_name'].'-Customs-Packing-List-Invoice.pdf';
                        } else {
                            $html = $this->load->view('commercial-invoice/packing/customer/packing-invoice-pdf', $data , true);
                            $filename = $invoice_data['da_no_name'].'-Customer-Packing-List-Invoice.pdf';
                        }
                    } else {
                        $this->session->set_flashdata('info', 'Unable to process the request something went wrong. Please refresh the page and try again.');
                        return redirect(base_url().$this->router->fetch_class());
                    }
                    //echo "<pre>"; print_r($html)
                    $mpdf->WriteHTML($html);
                    $mpdf->Output($filename, 'D'); 
         }


         public function delete_packing_invoice($id = '') {

                if(!empty($id)) {

                    $findOne = $this->invoice_header_packing->findOne(array('invoice_id' => $id));
                    $findOneMap = $this->invoiceipackinglist->findOne(array('invoice_no' => $id));
                    if(!empty($findOneMap['import_file'])) {

                        unlink('resources\packing-invoice-file/'.$findOneMap['import_file']);
                    }
                    $deleted = $this->invoice_header_packing->deleteWhere(array('invoice_id' => $id));

                    if(!empty($deleted)) {

                        $delete = $this->invoiceipackinglist->deleteWhere(array('invoice_no' => $id));
                        
                        $response = array('success' => 'Packing Invoice of '.$findOne['da_no_name'].' ready to regenerate.', 'id' => $findOne['da_no'] , 'url'=> base_url().'commercial_invoice/generate_packing_invoice/'.$findOne['da_no']);
                        echo json_encode($response);die;

                    } else {

                        $response = array('error' => 'Bad Request.');
                        echo json_encode($response);die;
                    }

                } else {

                    $response = array('error' => 'Bad Request.');
                    echo json_encode($response);die;
                }
         }

        /*
        | -------------------------------------------------------------------------
        | PACKING LIST INVOICE SECTION END 
        | -------------------------------------------------------------------------
        |
        */

        public function total_in_words() {

            if (!$this->input->is_ajax_request()) {
             exit('No direct script access allowed');
            } else {
              $num = $this->input->post('amount');

                $ones = array( 
                  1 => "One", 
                  2 => "Two", 
                  3 => "Three", 
                  4 => "Four", 
                  5 => "Five", 
                  6 => "Six", 
                  7 => "Seven", 
                  8 => "Eight", 
                  9 => "Nine", 
                  10 => "Ten", 
                  11 => "Eleven", 
                  12 => "Twelve", 
                  13 => "Thirteen", 
                  14 => "Fourteen", 
                  15 => "Fifteen", 
                  16 => "Sixteen", 
                  17 => "Seventeen", 
                  18 => "Eighteen", 
                  19 => "Nineteen" 
                ); 
                $tens = array( 
                  1 => "Ten",
                  2 => "Twenty", 
                  3 => "Thirty", 
                  4 => "Forty", 
                  5 => "Fifty", 
                  6 => "Sixty", 
                  7 => "Seventy", 
                  8 => "Eighty", 
                  9 => "Ninety" 
                ); 
                $hundreds = array( 
                  "Hundred", 
                  "Thousand", 
                  "Million", 
                  "Billion", 
                  "Trillion", 
                  "Quadrillion" 
                ); //limit t quadrillion 
                $num = number_format($num,2,".",","); 
                $num_arr = explode(".",$num); 
                $wholenum = $num_arr[0]; 
                $decnum = $num_arr[1]; 
                $whole_arr = array_reverse(explode(",",$wholenum)); 
                krsort($whole_arr); 
                $rettxt = ""; 
                foreach($whole_arr as $key => $i){ 
                  if($i < 20){ 
                          $rettxt .= $ones[$i]; 
                  }elseif($i < 100){ 
                    $rettxt .= $tens[substr($i,0,1)]; 
                    $rettxt .= " ".$ones[substr($i,1,1)]; 
                  }else{ 
                      $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
                      $rettxt .= " ".$tens[substr($i,1,1)]; 
                      $rettxt .= " ".$ones[substr($i,2,1)]; 
                  } 
                  if($key > 0){ 
                    $rettxt .= " ".$hundreds[$key]." "; 
                  } 
                } 
                if($decnum > 0){ 
                       $rettxt .= " and "; 
                  if($decnum < 20){ 
                         $rettxt .= $ones[$decnum]; 
                  } elseif($decnum < 100){ 
                    $rettxt .= $tens[substr($decnum,0,1)]; 
                    $rettxt .= " ".$ones[substr($decnum,1,1)]; 
                  } 
                } 
                
                $response = array('amount_in_words' => $rettxt);
                echo json_encode($response);die;
              
          }
      }  
      
        /*
        | -------------------------------------------------------------------------
        | GSK PACKING LIST INVOICE SECTION START 
        | -------------------------------------------------------------------------
        |
        */
            
         public function gsk_packing_invoice() {

                if($this->session->userdata('error')) {
                  $this->session->unset_userdata('error');
                }

                $data = array();
                $post = $this->input->post();              
                
                if(!empty($post)) {
                         $where = $post['buyer'];
                 } else {
                        $where = null;
                }

                $da_entry_list = $this->da_header->all_api_da_entry_for_gsk_invoice($where, array('cancelled' => 0),array('type' => 0));
                
                //echo "<pre>";print_r($this->db->last_query());die;
                
                if(empty($da_entry_list)) {
                     $this->session->set_flashdata('error','No Record Found.');
                 }

                 $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
                 $data['da_entry'] = $da_entry_list;
                
                $data['pageTitle'] = 'Neclife - GSK Invoice | Packing list';
                $data['template']  = 'commercial-invoice/gsk/index';
                $this->load->view('template_admin',$data);
         }


         public function generate_gsk_invoice($id = '') {
                 
            if($this->session->userdata('error')) {
               $this->session->unset_userdata('error');
            }
            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {

                //echo "<pre>"; print_r($post);die;
                 
            $salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 11);
             
             $table_array = array (
                   'invoice_id' =>$salt.md5($id),
                   'invoice_type' => !empty($post['type']) ? $post['type'][0]: '',
                   'financial_year' => strip_tags($post['financial_year']), 
                   'address' => $post['address'],
                   'buyer_order_number' => strip_tags($post['buyer_order_number']),
                   'buyer_order_date' => strip_tags($post['buyer_order_date']),
                   'contract_number' => strip_tags($post['contract_number']),
                   'contract_date' => strip_tags($post['contract_date']),
                   'da_no' => $id,
                   'da_no_name' => strip_tags($post['da_no']),
                   'da_date' => strip_tags($post['da_date']),
                   'po_no' => strip_tags($post['po_no']),
                   'lic_no' => strip_tags($post['lic_no']),
                   'lic_date' => strip_tags($post['lic_date']),
                   'indent_no' => strip_tags($post['indent_no']),
                   'indent_date' => strip_tags($post['indent_date']),
                   'invoice_no' => strip_tags($post['invoice_no']),
                   'invoice_date' => strip_tags($post['invoice_date']),
                   'export_reference' => $post['export_reference'],
                   'other_reference' => strip_tags($post['other_reference']),
                   'buyer' => strip_tags($post['buyer_inv']),
                   'consignee' => strip_tags($post['consignee_inv']),
                   'notify' => strip_tags($post['notify_inv']),
                   'notify_1' => strip_tags($post['notify_1_inv']),
                   'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
                   'Place_of_reciept' => strip_tags($post['place_of_reciept']),
                   'vessel_flight_no' => strip_tags($post['vessal_flight']),
                   'port_of_loading' => strip_tags($post['port_of_loading']),
                   'port_of_discharge' => strip_tags($post['port_of_discharge']),
                   'final_destination' => strip_tags($post['final_destination']),
                   'country' => strip_tags($post['country']),
                   'term_of_delivery' => strip_tags($post['term_of_delivery']),
                   'term_of_delivery1' => '',
                   'payment_terms' => strip_tags($post['payment_terms']),
                   'payment_terms1' => '',
                   'shipping_marks' => strip_tags($post['shipping_marks_inv']),
                   'net_weight' => strip_tags($post['net_weight']),
                   'tare_weight' => strip_tags($post['tare_weight']),
                   'gross_weight' => strip_tags($post['gross_weight']),
                   'declaration' => strip_tags($post['declaration']),
                   'total' => strip_tags($post['total']),
                   'total_amount_words' =>  strip_tags($post['total_words']),
                   'pan_number' => strip_tags($post['pan_number']),
                   'ie_code_no' => strip_tags($post['ie_code_no']) ,
                   'ad_lic_file_no' =>  strip_tags($post['adv_license_file_no']),
                   'cin_no' => strip_tags($post['cin_no']),
                   'gstin' => strip_tags($post['gstin']),
                   'state ' => strip_tags($post['state']),
                   'state_code' => strip_tags($post['state_code']),
                   'tin_number' => strip_tags($post['tin_number']),
                   'state_of_origin' => strip_tags($post['state_of_origin']),
                   'district_code' => strip_tags($post['district_code']),
                   'district_of_origin' => strip_tags($post['district_of_origin']),
                   'declaretion_final' => $post['declaration_final'],
                   'currency_name' => strip_tags($post['currency_name']),
                   'created_by' => $this->session->userdata('admin_id'),
                   'created_at' => date('Y-m-d'),

               );

                $insert = $this->export_gsk_header->insert($table_array);

                 if(!empty($insert)) {

                    if(!empty($post['packing_type'])) {

                          $count = count($post['packing_type']);
                            $da_items_table_array = array();
                             for($i = 0; $i <= $count - 1; $i++) {
                               if(!empty($post['packing_type'][$i])) {
                                    $da_items_table_array[] = array (
                                        'financial_year' => $post['financial_year'],
                                        'da_no' => $id,
                                        'invoice_no' => $salt.md5($id),
                                        'marks_drum_no' => $post['drum_nos'][$i],
                                        'kind_of_package' => $post['packing_type'][$i],
                                  'description_of_goods' => $post['description_of_goods'][$i],
                                        'qty' => $post['quantity'][$i],
                                        'rate' => $post['rate'][$i],
                                        'amount' => $post['amount'][$i],

                                      );

                                  }
                            }

                            if(!empty($da_items_table_array)) {
                                 $this->export_gsk_daitems->insertBatch($da_items_table_array); 
                             }
                      }

                      $this->session->set_flashdata('success', 'Gsk Invoice generated successfully.');
                     return redirect(base_url().$this->router->fetch_class(). '/gsk_packing_invoice');

                 } else {
                    $this->session->set_flashdata('error', 'Unable to process the request. Please try agian later.');
                    return redirect(base_url().$this->router->fetch_class(). '/gsk_packing_invoice');
                 }
            }
            
            $da_header = $this->da_header->findHeaderItems($id);
            if(!empty($da_header['cancelled'])) {
               $this->session->set_flashdata('warning', 'Unauthorised action.');
               return redirect(base_url(). $this->router->fetch_class(). '/gsk_packing_invoice');
            }

            $da_items = $this->da_items->findDAItems(array('da_no' => $id));
            $gsk_packing = $this->gsk_packing->findone(array('da_no' => $id)); 
            
            if(empty($gsk_packing['manager_qa'])) {
                
                $this->session->set_flashdata('info', 'Packing list is not approved from Manager QA yet.');
                return redirect(base_url(). $this->router->fetch_class(). '/gsk_packing_invoice');

            }   

            $gsk_packing_map = $this->gsk_packing_map->findAll(array('da_no' => $id));
           
            //echo "<pre>"; print_r($da_items);die;
            $data['da_header'] = $da_header;
            $data['da_items']  = $da_items;
            $data['gsk_packing'] = $gsk_packing;
            $data['gsk_packing_map'] = $gsk_packing_map;

            $data['net_weight'] = $gsk_packing['grand_net'];
            $data['tare_weight'] = $gsk_packing['grand_tare_coggurated'];
            $data['gross_weight'] = $gsk_packing['grand_gross'];

            $data['pageTitle'] = 'Neclife - GSK Invoice | Create';
            $data['template']  = 'commercial-invoice/gsk/create-invoice';
            $this->load->view('template_admin',$data);

         }

         public function update_gsk_invoice($id = '') {

             if($this->session->userdata('error')) {
                  $this->session->unset_userdata('error');
             }

             $data = array();
             $post = $this->input->post();

             if(!empty($post)) {

                    $table_array = array (
                         'invoice_id' => $id,
                         'invoice_type' => !empty($post['type']) ? $post['type'][0]: '',
                         'financial_year' => strip_tags($post['financial_year']), 
                         'address' => $post['address'],
                         'buyer_order_number' => strip_tags($post['buyer_order_number']),
                         'buyer_order_date' => strip_tags($post['buyer_order_date']),
                         'contract_number' => strip_tags($post['contract_number']),
                         'contract_date' => strip_tags($post['contract_date']),
                         'da_no' => $post['da_no'],
                         'da_no_name' => strip_tags($post['da_no_name']),
                         'da_date' => strip_tags($post['da_date']),
                         'po_no' => strip_tags($post['po_no']),
                         'lic_no' => strip_tags($post['lic_no']),
                         'lic_date' => strip_tags($post['lic_date']),
                         'indent_no' => strip_tags($post['indent_no']),
                         'indent_date' => strip_tags($post['indent_date']),
                         'invoice_no' => strip_tags($post['invoice_no_e']),
                         'invoice_date' => strip_tags($post['invoice_date']),
                         'export_reference' => $post['export_reference'],
                         'other_reference' => strip_tags($post['other_reference']),
                         'buyer' => strip_tags($post['buyer_inv']),
                         'consignee' => strip_tags($post['consignee_inv']),
                         'notify' => strip_tags($post['notify_inv']),
                         'notify_1' => strip_tags($post['notify_1_inv']),
                         'pre_carriage_by' => strip_tags($post['pre_carriage_by']),
                         'Place_of_reciept' => strip_tags($post['place_of_reciept']),
                         'vessel_flight_no' => strip_tags($post['vessal_flight']),
                         'port_of_loading' => strip_tags($post['port_of_loading']),
                         'port_of_discharge' => strip_tags($post['port_of_discharge']),
                         'final_destination' => strip_tags($post['final_destination']),
                         'country' => strip_tags($post['country']),
                         'term_of_delivery' => strip_tags($post['term_of_delivery']),
                         'term_of_delivery1' => '',
                         'payment_terms' => strip_tags($post['payment_terms']),
                         'payment_terms1' => '',
                         'shipping_marks' => strip_tags($post['shipping_marks_inv']),
                         'net_weight' => strip_tags($post['net_weight']),
                         'tare_weight' => strip_tags($post['tare_weight']),
                         'gross_weight' => strip_tags($post['gross_weight']),
                         'declaration' => strip_tags($post['declaration']),
                         'total' => strip_tags($post['total']),
                         'total_amount_words' =>  strip_tags($post['total_words']),
                         'pan_number' => strip_tags($post['pan_number']),
                         'ie_code_no' => strip_tags($post['ie_code_no']) ,
                         'ad_lic_file_no' =>  strip_tags($post['adv_license_file_no']),
                         'cin_no' => strip_tags($post['cin_no']),
                         'gstin' => strip_tags($post['gstin']),
                         'state ' => strip_tags($post['state']),
                         'state_code' => strip_tags($post['state_code']),
                         'tin_number' => strip_tags($post['tin_number']),
                         'state_of_origin' => strip_tags($post['state_of_origin']),
                         'district_code' => strip_tags($post['district_code']),
                         'district_of_origin' => strip_tags($post['district_of_origin']),
                         'declaretion_final' => $post['declaration_final'],
                         'currency_name' => strip_tags($post['currency_name']),
                         'created_by' => $this->session->userdata('admin_id'),
                         'created_at' => date('Y-m-d'),

                     );
                     //echo "<pre>"; print_r($table_array);die;
                     $update = $this->export_gsk_header->update($table_array, array('invoice_id' => $id));

                     if(!empty($update)) {
                           
                        if(!empty($post['packing_type'])) {

                          $count = count($post['packing_type']);
                            $da_items_table_array = array();
                             for($i = 0; $i <= $count - 1; $i++) {
                               if(!empty($post['packing_type'][$i])) {
                                    $da_items_table_array[] = array (
                                        'financial_year' => $post['financial_year'],
                                        'da_no' => $post['da_no'],
                                        'invoice_no' => $id,
                                        'marks_drum_no' => $post['drum_nos'][$i],
                                        'kind_of_package' => $post['packing_type'][$i],
                                  'description_of_goods' => $post['description_of_goods'][$i],
                                        'qty' => $post['quantity'][$i],
                                        'rate' => $post['rate'][$i],
                                        'amount' => $post['amount'][$i],

                                      );

                                  }
                            }

                            if(!empty($da_items_table_array)) {

                                 $this->export_gsk_daitems->deleteWhere(array('invoice_no' => $id));
                                 $this->export_gsk_daitems->insertBatch($da_items_table_array); 
                             }
                      }

                      $this->session->set_flashdata('success', 'Gsk Invoice updated successfully.');
                       return redirect(base_url().$this->router->fetch_class(). '/gsk_packing_invoice');

                     } else {
                         $this->session->set_flashdata('error', 'Unable to process the request. Please try agian later.');
                         return redirect(base_url(). $this->router->fetch_class(). '/gsk_packing_invoice');
                     }
             }

              $export_gsk_header  = $this->export_gsk_header->findOne(array('invoice_id' => $id));
              if(!empty($export_gsk_header)) {

                  $export_gsk_daitems = $this->export_gsk_daitems->findAll(array('da_no' => $export_gsk_header['da_no']));

                  $gsk_packing = $this->gsk_packing->findone(array('da_no' => $export_gsk_header['da_no']));
                  $gsk_packing_map = $this->gsk_packing_map->findAll(array('da_no' => $export_gsk_header['da_no']));

                  $data['invoice_data'] = $export_gsk_header;
                  $data['da_items'] = $export_gsk_daitems;
                  $data['gsk_packing'] = $gsk_packing;
                  $data['gsk_packing_map'] = $gsk_packing_map;
                  //echo "<pre>"; print_r($export_gsk_daitems);die;

              } else {
                  $this->session->set_flashdata('warning', 'Unauthorised action.');
                  return redirect(base_url(). $this->router->fetch_class().'/gsk_packing_invoice');
              }

             $data['pageTitle'] = 'Neclife - GSK Invoice | Create';
             $data['template']  = 'commercial-invoice/gsk/update-invoice';
             $this->load->view('template_admin',$data);
         }

         public function delete_gsk_invoice($id = '') {

                if(!empty($id) && $this->input->is_ajax_request()) {
                   
                    $findOne = $this->export_gsk_header->findOne(array('invoice_id' => $id));
                    $deleted = $this->export_gsk_header->deleteWhere(array('invoice_id' => $id));

                    if(!empty($deleted)) {

                        $delete = $this->export_gsk_daitems->deleteWhere(array('invoice_no' => $id));
                        
                        $response = array('success' => 'GSK Packing Invoice of '.$findOne['da_no_name'].' ready to regenerate.', 'id' => $findOne['da_no'] , 'url'=> base_url().'commercial_invoice/generate_gsk_invoice/'.$findOne['da_no']);
                        echo json_encode($response);die;

                    } else {

                        $response = array('error' => 'Bad Request.');
                        echo json_encode($response);die;
                    }

                } else {

                    $response = array('error' => 'Bad Request.');
                    echo json_encode($response);die;
                }
         }

         public function download_gsk_invoice($id = ''){
             
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            $data = array();
            $export_gsk_header = $this->export_gsk_header->findOne(array('invoice_id' => $id));
            if(empty($id) && empty($export_gsk_header)) {

                 $this->session->set_flashdata('error', 'Bad Request.');
                 return redirect( base_url(). $this->router->fetch_classs(). '/gsk_packing_invoice');

            } else {
                   
                $export_gsk_daitems = $this->export_gsk_daitems->findAll(array('da_no' => $export_gsk_header['da_no']));
                $gsk_packing = $this->gsk_packing->findone(array('da_no' => $export_gsk_header['da_no']));
                $gsk_packing_map = $this->gsk_packing_map->findAll(array('da_no' => $export_gsk_header['da_no']));

                if(!empty($gsk_packing_map)) {
                    
                   $combined_array = array();
                   foreach($gsk_packing_map as $key => $value) {
                       $combined_array[trim($value['mfg_date'].'/'.$value['retest_date'])][] = $value['batch_no'];
                   }
                }

                $data['invoice_data'] = $export_gsk_header;
                $data['invoice_da_items'] = $export_gsk_daitems;
                $data['gsk_packing'] = $gsk_packing;
                $data['gsk_packing_map'] = $gsk_packing_map;
                $data['combined_data'] = $combined_array;

            }

             $data['pageTitle'] = 'Neclife - GSK Invoice | Download';
             $data['template']  = 'commercial-invoice/gsk/invoice';
             $this->load->view('template_admin',$data);
 
         }

        public function pdf_gsk_invoice($id = ''){
            
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
            $mpdf->SetDisplayMode('fullwidth');
            $data = array();
            $export_gsk_header = $this->export_gsk_header->findOne(array('invoice_id' => $id));
            if(empty($id) && empty($export_gsk_header)) {

                 $this->session->set_flashdata('error', 'Bad Request.');
                 return redirect( base_url(). $this->router->fetch_classs(). '/gsk_packing_invoice');

            } else {
                   
                $export_gsk_daitems = $this->export_gsk_daitems->findAll(array('da_no' => $export_gsk_header['da_no']));
                $gsk_packing = $this->gsk_packing->findone(array('da_no' => $export_gsk_header['da_no']));
                $gsk_packing_map = $this->gsk_packing_map->findAll(array('da_no' => $export_gsk_header['da_no']));

                if(!empty($gsk_packing_map)) {
                    
                   $combined_array = array();
                   foreach($gsk_packing_map as $key => $value) {
                       $combined_array[trim($value['mfg_date'].'/'.$value['retest_date'])][] = $value['batch_no'];
                   }
                }

                $data['invoice_data'] = $export_gsk_header;
                $data['invoice_da_items'] = $export_gsk_daitems;
                $data['gsk_packing'] = $gsk_packing;
                $data['gsk_packing_map'] = $gsk_packing_map;
                $data['combined_data'] = $combined_array;

            }
             
             $filename = 'GSK-Packing-Invoice-'.$export_gsk_header['da_no_name'].'.pdf';
             $html = $this->load->view('commercial-invoice/gsk/invoice-pdf', $data , true);
             $mpdf->WriteHTML($html);
             $mpdf->Output($filename, 'D'); 
 
         }


        public function pdf_gsk_invoice1(){
            
             $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
             $filename = 'test.pdf';
             $html = $this->load->view('commercial-invoice/gsk/test', null , true);
             $mpdf->WriteHTML($html);
             $mpdf->Output($filename, 'D'); 
 
         }

          public function pdf_gsk_test(){
          

            $data['pageTitle'] = 'Neclife - GSK Invoice | Create';
             $data['template']  = 'commercial-invoice/gsk/test';
             $this->load->view('template_admin',$data);
 
         }


        /*
        | -------------------------------------------------------------------------
        | GSK PACKING LIST INVOICE SECTION END 
        | -------------------------------------------------------------------------
        |
        */

}


