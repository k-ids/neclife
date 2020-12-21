<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Commercial Invoice</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class()?>">Generate Invoice</a></li>
   </li>
</ol>
<style type="text/css">
   hr {
   border-top: 1px solid #d9534f !important;
   }
</style>
<form method="POST" action="<?= base_url().$this->router->fetch_class().'/generate_packing_invoice/'.$da_header['id']?>" enctype="multipart/form-data">
   <div class="card mb-3">
      <div class="card-header" style="background: aquamarine;">
         <i class="fa fa-table" style="color: green;"></i> <b>ESSENTIAL DETAILS</b>
      </div>
      <div class="card-block">
         <div class="row">
            <div class="col-md-6 form-group">
               <label>Exporter/Manufacturer/Beneficiary - Name & Address:</label>
               <textarea class="form-control" id="address" name="address" rows="5" cols="5" placeholder="Enter the text here..."><?= !empty($packing_invoice['address']) ? $packing_invoice['address'] : (
                  !empty($da_header['address']) ? $da_header['address']: '') ?></textarea>
            </div>
            <div class="col-md-6 form-group">
               <label>Export Reference:</label>
               <textarea class="form-control" id="export_reference" name="export_reference" rows="5" cols="5" placeholder="Enter the text here..."></textarea>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-4 form-group">
               <label>Invoice Number:</label>
               <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="<?= set_value('invoice_no', !empty($packing_invoice['invoice_no']) ? $packing_invoice['invoice_no'] : '') ?>" placeholder="Enter invoice number" required>
               <?= form_error('invoice_no') ?>
            </div>
            <div class="col-md-4 form-group">
               <label>Invoice Date:</label>
               <input type="text" name="invoice_date" id="invoice_date" class="form-control" value="<?= set_value('invoice_date', !empty($packing_invoice['invoice_date']) ? $packing_invoice['invoice_date'] : '') ?>" placeholder="Enter invoice date" required>
               <?= form_error('invoice_date') ?>
            </div>
            <div class="col-md-8 form-group">
               <label>Buyer/Intend/Contract Title:</label>
               <input type="text" name="buyer_order_number" id="buyer_order_number" class="form-control" value="<?= set_value('buyer_order_number' , !empty($packing_invoice['buyer_order_number']) ? $packing_invoice['buyer_order_number'] : '') ?>" placeholder="Enter buyer order number" required>
               <?= form_error('buyer_order_number') ?>
            </div>
         </div>
         <div class="row">
            <div class="col-md-8 form-group">
               <label>Buyer/Intend/Contract Date:</label>
               <input type="text" name="buyer_order_date" id="buyer_order_date" class="form-control" value="<?= set_value('buyer_order_date', !empty($packing_invoice['buyer_order_date']) ? $packing_invoice['buyer_order_date'] : '') ?>" placeholder="Enter buyer order date" required>
               <?= form_error('buyer_order_date') ?>
            </div>
            <div class="col-md-4 form-group" style="display: none;">
               <label>Contract Number:</label>
               <input type="text" name="contract_number" id="contract_number" class="form-control" value="<?= set_value('contract_number' , !empty($packing_invoice['contract_number']) ? $packing_invoice['contract_number'] : '') ?>" placeholder="Enter contract number">
               <?= form_error('contract_number') ?>
            </div>
            <div class="col-md-4 form-group" style="display: none;">
               <label>Contract Date:</label>
               <input type="text" name="contract_date" id="contract_date" class="form-control" value="<?= set_value('contract_date', !empty($packing_invoice['contract_date']) ? $packing_invoice['contract_date'] : '') ?>" placeholder="Enter contract date">
               <?= form_error('contract_date') ?>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-12 form-group">
               <label>Other reference(s):</label>
               <input class="form-control" type="text" name="other_reference" value="<?= set_value('other_reference', !empty($packing_invoice['other_reference']) ? $packing_invoice['other_reference'] : '') ?>" placeholder="Enter the text here..">
            </div>
         </div>
         <div class="row">
            <div class="col-md-6 form-group">
               <label>DA Number:</label>
               <input class="form-control" type="text" name="da_no" placeholder="DA Number" value="<?= set_value('da_no', $da_header['da_no'].' '.$da_header['financial_year']) ?>" readonly required>
            </div>
            <div class="col-md-6 form-group">
               <label>DA Date</label>
               <input class="form-control" type="text" name="da_date"  placeholder="DA date" value="<?= set_value('da_date', nice_date($da_header['da_date'], 'd-M-Y') ) ?>" readonly required>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6 form-group">
               <label>L/C Number:</label>
               <input class="form-control" type="text" name="lic_no" placeholder="LIC Number" value="<?= set_value('lic_no', !empty($packing_invoice['lic_no']) ? $packing_invoice['lic_no'] : (
                  !empty($da_header['lic_no']) ? $da_header['lic_no']: '') ) ?>" >
            </div>
            <div class="col-md-6 form-group">
               <label>L/C Date</label>
               <input class="form-control" type="text" name="lic_date" id="liiic_date"  placeholder="LIC date" value="<?= set_value('lic_date', !empty($packing_invoice['lic_date']) ? $packing_invoice['lic_date'] : ( !empty($da_header['lic_date']) ?$da_header['lic_date'] : '') ) ?>" >
            </div>
         </div>
         <hr>
         <div class="row" style="display: none;">
           <div class="col-md-6 form-group">
              <label>Indent Number:</label>
              <input class="form-control" type="text" name="indent_no" placeholder="" value="<?= set_value('indent_no', !empty($packing_invoice['indent_no']) ? $packing_invoice['indent_no'] : '' ) ?>" >
           </div> 
           <div class="col-md-6 form-group">
              <label>Indent Date:</label>
              <input class="form-control" type="text" name="indent_date" id="indent_date"  placeholder="" value="<?= set_value('indent_date', !empty($packing_invoice['indent_date']) ? $packing_invoice['indent_date']  : '' ) ?>" >
           </div>
        </div>  
        <hr>
         <div class="row">
            <div class="form-group col-md-6">
               <label>Consignee:</label>
               <?php 
                  $party =  getName( $da_header['consignee'] ) ;
                  $consignee =   $party['party'] . '<br>' .$party['address1']. '<br>' .$party['address2']. '<br>' .$party['address3'].'<br>' .$party['fax'].'<br>' .$party['phone'];
                  ?>
               <textarea name="consignee_inv" class="form-control" rows="5" cols="5"><?= $consignee ?></textarea>
            </div>
            <div class="form-group col-md-6">
               <label>Buyer (if other than Consignee):</label>
               <?php 
                  $party =  getName( $da_header['buyer'] ); 
                  $buyer =   $party['party'] . '<br>' .$party['address1']. '<br>' .$party['address2']. '<br>' .$party['address3'].'<br>' .$party['fax'].'<br>' .$party['phone'];
                  ?> 
               <textarea name="buyer_inv" class="form-control" rows="5" cols="5"><?= $buyer ?></textarea>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               <label>Notify1:</label>
               <?php 
                  $party =  getName( $da_header['notify'] ); 
                  $notify =   $party['party'] . '<br>' .$party['address1']. '<br>' .$party['address2']. '<br>' .$party['address3'].'<br>' .$party['fax'].'<br>' .$party['phone'];
                  ?> 
               <textarea name="notify_inv" class="form-control" rows="5" cols="5"><?= $notify ?></textarea>
            </div>
            <div class="form-group col-md-6">
               <label>Notify2: </label>
               <?php 
                  $party =  getName( $da_header['notify_1'] ); 
                  $notify_1 =   $party['party'] . '<br>' .$party['address1']. '<br>' .$party['address2']. '<br>' .$party['address3'].'<br>' .$party['fax'].'<br>' .$party['phone'];
                  ?> 
               <textarea name="notify_1_inv" class="form-control" rows="5" cols="5"><?= $notify_1 ?></textarea>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Pre-carriage by:</label>
               <input type="text" name="pre_carriage_by" id="pre_carriage_by" class="form-control" value="<?= set_value('pre_carriage_by' , !empty($packing_invoice['pre_carriage_by']) ? $packing_invoice['pre_carriage_by'] : '')?>">
            </div>
            <div class="form-group col-md-4">
               <label>Place of Receipt:</label>
               <input type="text" name="place_of_reciept" id="place_of_reciept" class="form-control" value="<?= set_value('place_of_reciept', !empty($packing_invoice['place_of_reciept']) ? $packing_invoice['place_of_reciept'] : 'by Pre-Carrier')?>">
            </div>
            <div class="form-group col-md-4">
               <label>Country of Origin:</label>
               <input type="text" name="country" id="country" class="form-control" value="<?= set_value('country', !empty($packing_invoice['country']) ? $packing_invoice['country'] : 'INDIA' )?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Country of Final Destination:</label>
               <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination',  !empty($packing_invoice['final_destination']) ? $packing_invoice['final_destination'] : $da_header['county_name'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Vessel/Flight no.:</label>
               <input type="text" name="vessal_flight" id="vessel_flight_no" class="form-control" value="<?= set_value('vessal_flight', !empty($packing_invoice['vessel_flight_no']) ? $packing_invoice['vessel_flight_no'] : '')?>">
            </div>
            <div class="form-group col-md-4">
               <label>Port of Loading:</label>
               <input type="text" name="port_of_loading" id="port_of_loading" class="form-control" value="<?= set_value('port_of_loading', !empty($packing_invoice['port_of_loading']) ? $packing_invoice['port_of_loading'] : 'IGI AIRPORT NEW DELHI' )?>">
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Terms of Delivery :</label>
               <input type="text" name="term_of_delivery" id="term_of_delivery" class="form-control" value="<?= set_value('term_of_delivery', !empty($packing_invoice['term_of_delivery']) ? $packing_invoice['term_of_delivery'] : $da_header['deliveryterm'] )?>">
            </div>
            <div class="form-group col-md-4">
               <label>Payment:</label>
               <input type="text" name="payment_terms" id="payment_terms" class="form-control" value="<?= set_value('payment_terms', !empty($packing_invoice['payment_terms']) ? $packing_invoice['payment_terms']: $da_header['paymentterms'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Port of Discharge:</label>
               <input type="text" name="port_of_discharge" id="port_of_discharge" class="form-control" value="<?= set_value('port_of_discharge', !empty($packing_invoice['port_of_discharge']) ? $packing_invoice['port_of_discharge']: '')?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Final Destination:</label>
               <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination', !empty($packing_invoice['final_destination']) ? $packing_invoice['final_destination']: $da_header['despatchto'])?>">
            </div>
            <div class="form-group col-md-8">
               <label>Batch No:</label>
               <input type="text" name="batch_no"  class="form-control" value="<?= set_value('batch_no', !empty($packing_invoice['batch_no']) ? $packing_invoice['batch_no'] : ( !empty($batch_no) ? $batch_no : '') )?>">
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label>Manufacturing date:</label>
                  <input type="text" name="mfg_date" id="mfg_date" class="form-control" value="<?= set_value('mfg_date', !empty($packing_invoice['mfg_date']) ? $packing_invoice['mfg_date'] : ( !empty($mfg_date_value) ? $mfg_date_value: '') )?>">
               </div>
               <div class="form-group">
                  <label>Expiry Date:</label>
                  <input type="text" name="exp_date" id="exp_date" class="form-control" value="<?= set_value('exp_date', !empty($packing_invoice['exp_date']) ? $packing_invoice['exp_date'] : ( !empty($exp_date_value) ? $exp_date_value : ''))?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Shipping marks:</label>
                  <textarea class="form-control" name="shipping_marks_inv" rows="3" cols="5"><?= set_value('shipping_marks_inv', !empty($packing_invoice['shipping_marks']) ? $packing_invoice['shipping_marks']: '') ?></textarea>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-header" style="background: aquamarine;">
         <i class="fa fa-table" style="color: green;"></i> <b>Packing List Data</b>
      </div>
      <div class="card-block">
         <?php if($packing_list[0]['da_type'] == '1' || $packing_list[0]['da_type'] == '3' || $packing_list[0]['da_type'] == '5') { ?>
        <div class="table-responsive">
            <table class="table table-bordered re-calculate" width="200%" id="dataTable" cellspacing="0">
               <thead>
                  <tr>
                     <th>Sr.No</th>
                     <th>Marks and Nos</th>
                     <th>No. & Kind of Packages</th>
                     <th>Description of Goods <br>and/or Services</th>
                     <th>Drum<br>No.</th>
                     <th>Box No <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                     <th>Total Nos. of Boxes <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                     <th>Total Nos. of Packs<i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                     <th>Batch Nos.</th>
                     <th>Net Wt.<br>(IN KGS)</th>
                     <th>Gross Wt..<br>(IN KGS)</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!empty($packing_list) ) {
                     $counter = 0;
                     //$sum = 0;
                     foreach($packing_list as $key => $daitems) {
                     //$sum+= $daitems['amount'];
                     ?>
                  <tr>
                     <td>
                        <?= ++$counter; ?>
                     </td>
                     <td>
                        <input type="text" class="form-control" name="drum_nos[]" value="">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="packing_type[]" value="<?= $daitems['kindofpackages'] ?>" >
                     </td>
                     <td>
                        <input type="text" class="form-control" name="description_of_goods[]" value="<?= $daitems['product_name'].' HS CODE: '.$daitems['product_hscode'] ?>">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="excise_sr_no[]" value="<?= $daitems['excise_sr_no'] ?>">
                     </td>
                     <td>
                          <input type="text" name="box_no[]" value="<?= $daitems['box_no'] ?>" class="form-control" >
                 
                     </td>
                      <td>
                          <input type="text" name="total_no_boxes[]" value="<?= $daitems['total_no_boxes'] ?>" class="form-control" >
                 
                     </td>
                      <td>
                          <input type="text" name="total_no_packs[]" value="<?= $daitems['total_no_packs'] ?>" class="form-control" >
                 
                     </td>
                     <td>
                        <input type="text" class="form-control" name="batch_nos[]" value="<?= $daitems['batch_no'] ?>">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="net_weight[]" value="<?= $daitems['net_weight'] ?>" >
                     </td>
                     <td>
                        <input type="text" class="form-control" name="outer_gross_weight[]" value="<?= $daitems['outer_gross_weight'] ?>" >
                     </td>
                     <input type="hidden" name="seal_no[]" value="<?= $daitems['seal_no']?>">
                  </tr>
                  <?php } } ?>             
               </tbody>
            </table>
         </div>
         <?php } else { ?>

            <div class="row">
            <div class="col-md-3">
               <a href="<?= base_url().'resources/packing-list-import/'.$packing_list[0]['file_path'] ?>" data-toggle="tooltip" data-placement="top" title="Click me to preview the packing list.">  
               <img src="<?= base_url().'resources/packing-list-import/excel-2016-mac-icon-100610905-gallery.png'?>" alt="excel-icon" height="200px" width="300px">   
               </a>
            </div>
            <div class="col-md-9">
               <p style="padding-top: 45px; font-weight: 500;">
                  ~ File Name:  <b class="text-danger"><?= $packing_list[0]['file_path'] ?></b><br>
                  ~ If you want to make changes, please add the changes into the same file and re-upload from below by clicking on <br> <span class="text-danger">"click to upload the file section".</span> <br>
                  ~ Otherwise, click save and generate invoice button to genertate the invoice with same file data.
               </p>
            </div>
         </div>
         <div class="upload-drop-zone text-danger" id="drop-zone">
            Click to upload the file.
         </div>
         <input id="upload_excel" name="packing_excel" type="file"/ style="display: none;">
         <input type="hidden" name="db-file-name" value="<?= $packing_list[0]['file_path'] ?>">
         
         <hr>
         <?php } ?>
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-header" style="background: aquamarine;">
         <i class="fa fa-table" style="color: green;"></i> <b>ESSENTIAL DETAILS</b>
      </div>
      <div class="card-block">
         <div class="row">
            <div class="form-group col-md-12">
               <label>Banker’s details / Payment Instructions are as under::</label>
               <textarea class="form-control" rows="10" cols="15" name="declaration_final"><p>Beneficiary : Nectar Lifesciences Limited</p>
             <p>S.C.O. 38-39, Sector 9-D</p>
             <p>Chandigarh-160 009 (India)</p>
             <p>Beneficiary Account No. : 0575008700004684 </p>
             <p>Beneficiary Bank :  Punjab National Bank, </p>
             <p>Large Corporate Branch,Bank Square  </p>
             <p>1st Floor, Sector 17-B, Chandigarh</p>
             <p>SWIFT CODE: PUNBINBBCMC</p>
             <p>Intermediary Bank Detail.</p>
             <p>Account No. 36003588 of Punjab National Bank</p>
             <p>FEO NEW DELHI SWIFT CODE : PUNBINBBDIB WITH</p>
             <p>Citi Bank N.A.- New York, USA Swift Code: CITIUS33</p>
            </textarea>
            </div>
         </div>
         <input type="hidden" name="financial_year" value="<?= $da_header['financial_year'] ?>">
         <input type="hidden" name="po_no" value="<?= $da_header['po_no'] ?>">
         <input type="hidden" name="currency_name" value="<?= $da_header['currency_name'] ?>">
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-block">
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save Data And Generate Invoice</button>
         <a href="<?= base_url().$this->router->fetch_class().'/packing_list_invoice'?>" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;Cancel</a>
      </div>
   </div>
</form>