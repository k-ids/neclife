<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Commercial Invoice</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class()?>">Update Packing Invoice</a></li>
   </li>
</ol>
<style type="text/css">
   hr {
   border-top: 1px solid #d9534f !important;
   }
</style>
<form method="POST" action="<?= base_url().$this->router->fetch_class().'/update_packinglist_invoice/'.$invoice_data['invoice_id']?>" enctype="multipart/form-data">
   <div class="card mb-3">
      <div class="card-header" style="background: aquamarine;">
         <i class="fa fa-table" style="color: green;"></i> <b>ESSENTIAL DETAILS</b>
      </div>
      <div class="card-block">
         <div class="row">
            <div class="col-md-6 form-group">
               <label>Exporter/Manufacturer/Beneficiary - Name & Address:</label>
               <textarea class="form-control" id="address" name="address" rows="5" cols="5" placeholder="Enter the text here..."><?= $invoice_data['address']?></textarea>
            </div>
            <div class="col-md-6 form-group">
               <label>Export Reference:</label>
               <textarea class="form-control" id="export_reference" name="export_reference" rows="5" cols="5" placeholder="Enter the text here..."><?= $invoice_data['export_reference']?></textarea>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-4 form-group">
               <label>Invoice Number:</label>
               <input type="text" name="invoice_no_e" id="invoice_no_e" class="form-control" value="<?= set_value('invoice_no_e', $invoice_data['invoice_no']) ?>" placeholder="Enter invoice number" required>
               <?= form_error('invoice_no_e') ?>
            </div>
            <div class="col-md-4 form-group">
               <label>Invoice Date:</label>
               <input type="text" name="invoice_date" id="invoice_date" class="form-control" value="<?= set_value('invoice_date', $invoice_data['invoice_date']) ?>" placeholder="Enter invoice date" required>
               <?= form_error('invoice_date') ?>
            </div>
            <div class="col-md-8 form-group">
               <label>Buyer/Intend/Contract Title:</label>
               <input type="text" name="buyer_order_number" id="buyer_order_number" class="form-control" value="<?= set_value('buyer_order_number', $invoice_data['buyer_order_number']) ?>" placeholder="Enter buyer order number" required>
               <?= form_error('buyer_order_number') ?>
            </div>
         </div>
         <div class="row">
            <div class="col-md-8 form-group">
               <label>Buyer/Intend/Contract Date:</label>
               <input type="text" name="buyer_order_date" id="buyer_order_date" class="form-control" value="<?= set_value('buyer_order_date', $invoice_data['buyer_order_date']) ?>" placeholder="Enter buyer order date" required>
               <?= form_error('buyer_order_date') ?>
            </div>

            <div class="col-md-4 form-group" style="display: none;">
               <label>Contract Number:</label>
               <input type="text" name="contract_number" id="contract_number" class="form-control" value="<?= set_value('contract_number', $invoice_data['contract_number']) ?>" placeholder="Enter contract number">
               <?= form_error('contract_number') ?>
            </div>
            <div class="col-md-4 form-group" style="display: none;">
               <label>Contract Date:</label>
               <input type="text" name="contract_date" id="contract_date" class="form-control" value="<?= set_value('contract_date', $invoice_data['contract_date']) ?>" placeholder="Enter contract date">
               <?= form_error('contract_date') ?>
            </div>
         </div>
         <hr>

         <div class="row">
            <div class="col-md-12 form-group">
               <label>Other reference(s):</label>
               <input class="form-control" type="text" name="other_reference" value="<?= set_value('other_reference', $invoice_data['other_reference'])?>" placeholder="Enter the text here..">
            </div>
         </div>

         <div class="row">
            <div class="col-md-6 form-group">
               <label>DA Number:</label>
               <input class="form-control" type="text" name="da_no_name" placeholder="DA Number" value="<?= set_value('da_no', $invoice_data['da_no_name']) ?>" readonly required>
            </div>
            <input type="hidden" name="da_no" value="<?= $invoice_data['da_no']?>">
            <div class="col-md-6 form-group">
               <label>DA Date</label>
               <input class="form-control" type="text" name="da_date"  placeholder="DA date" value="<?= set_value('da_date', $invoice_data['da_date'] )  ?>" readonly required>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6 form-group">
               <label>LIC Number:</label>
               <input class="form-control" type="text" name="lic_no" placeholder="LIC Number" value="<?= set_value('lic_no', $invoice_data['lic_no']) ?>">
            </div>
            <div class="col-md-6 form-group">
               <label>LIC Date</label>
               <input class="form-control" type="text" name="lic_date" id="lc_date"  placeholder="LIC date" value="<?= set_value('lic_date', !empty($invoice_data['lic_date']) ? $invoice_data['lic_date'] : '' ) ?>">
            </div>
         </div>
         <hr>

         <div class="row" style="display: none;">
           <div class="col-md-6 form-group">
              <label>Indent  Number:</label>
              <input class="form-control" type="text" name="indent_no" placeholder="" value="<?= set_value('indent_no', !empty($invoice_data['indent_no'])? $invoice_data['indent_no']: '') ?>">
           </div>
           <div class="col-md-6 form-group">
              <label>Indent Date</label>
              <input class="form-control" type="text" name="indent_date" placeholder="LIC date" value="<?= set_value('indent_date', !empty($invoice_data['indent_date']) ? $invoice_data['indent_date'] : '') ?>">
           </div>
        </div>

        <hr>
         <div class="row">
            <div class="form-group col-md-6">
               <label>Consignee:</label>
               <textarea name="consignee_inv" class="form-control" rows="5" cols="5"><?= $invoice_data['consignee'] ?></textarea>
            </div>
            <div class="form-group col-md-6">
               <label>Buyer (if other than Consignee):</label>
               <textarea name="buyer_inv" class="form-control" rows="5" cols="5"><?= $invoice_data['buyer'] ?></textarea>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-6">
               <label>Notify1:</label>
               <textarea name="notify_inv" class="form-control" rows="5" cols="5"><?= $invoice_data['notify'] ?></textarea>
            </div>
            <div class="form-group col-md-6">
               <label>Notify2: </label>
               <textarea name="notify_1_inv" class="form-control" rows="5" cols="5"><?= $invoice_data['notify_1'] ?></textarea>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Pre-carriage by:</label>
               <input type="text" name="pre_carriage_by" id="pre_carriage_by" class="form-control" value="<?= set_value('pre_carriage_by', $invoice_data['pre_carriage_by'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Place of Receipt:</label>
               <input type="text" name="place_of_reciept" id="place_of_reciept" class="form-control" value="<?= set_value('place_of_reciept',  $invoice_data['Place_of_reciept'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Country of Origin:</label>
               <input type="text" name="country" id="country" class="form-control" value="<?= set_value('country', $invoice_data['country'])?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Country of Final Destination:</label>
               <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination',  $invoice_data['final_destination'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Vessel/Flight no.:</label>
               <input type="text" name="vessal_flight" id="vessel_flight_no" class="form-control" value="<?= set_value('vessel_flight_no', $invoice_data['vessel_flight_no'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Port of Loading:</label>
               <input type="text" name="port_of_loading" id="port_of_loading" class="form-control" value="<?= set_value('port_of_loading', $invoice_data['port_of_loading'])?>">
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Terms of Delivery :</label>
               <input type="text" name="term_of_delivery" id="term_of_delivery" class="form-control" value="<?= set_value('term_of_delivery', $invoice_data['term_of_delivery'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Payment:</label>
               <input type="text" name="payment_terms" id="payment_terms" class="form-control" value="<?= set_value('payment_terms', $invoice_data['payment_terms'])?>">
            </div>
            <div class="form-group col-md-4">
               <label>Port of Discharge:</label>
               <input type="text" name="port_of_discharge" id="port_of_discharge" class="form-control" value="<?= set_value('port_of_discharge', $invoice_data['port_of_discharge'])?>">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-md-4">
               <label>Final Destination:</label>
               <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination' , $invoice_data['final_destination'])?>">
            </div>
            <div class="form-group col-md-8">
               <label>Batch No:</label>
               <input type="text" name="batch_no"  class="form-control" value="<?= set_value('batch_no',  $invoice_data['batch_no'] )?>">
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label>Manufacturing date:</label>
                  <input type="text" name="mfg_date" id="mfg_date" class="form-control" value="<?= set_value('mfg_date', $invoice_data['mfg_date'])?>">
               </div>
               <div class="form-group">
                  <label>Expiry Date:</label>
                  <input type="text" name="exp_date" id="exp_date" class="form-control" value="<?= set_value('exp_date', $invoice_data['exp_date'])?>">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Shipping marks:</label>
                  <textarea class="form-control" name="shipping_marks_inv" rows="3" cols="5"><?= $invoice_data['shipping_marks'] ?></textarea>
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
         <?php if(!empty($packing_list[0]['import_file'])) { ?>
        
          <div class="row">
            <div class="col-md-3">
               <a href="<?= base_url().'resources/packing-invoice-file/'.$packing_list[0]['import_file'] ?>" data-toggle="tooltip" data-placement="top" title="Click me to preview the packing list.">  
               <img src="<?= base_url().'resources/packing-list-import/excel-2016-mac-icon-100610905-gallery.png'?>" alt="excel-icon" height="200px" width="300px">   
               </a>
            </div>
            <div class="col-md-9">
               <p style="padding-top: 70px; font-weight: 500;">
                  ~ If you want to make changes, please add the changes into the same file and re-upload from below by clicking on <br> <span class="text-danger">"click to upload the file section".</span> <br>
                  ~ Otherwise, click save and generate invoice button to genertate the invoice with same file data.
               </p>
            </div>
         </div>
         <div class="upload-drop-zone text-danger" id="drop-zone">
            Click to upload the file.
         </div>
         <input id="upload_excel" name="packing_excel" type="file"/ style="display: none;">
         <input type="hidden" name="db-file-name" value="<?= $packing_list[0]['import_file'] ?>">
       <?php  } else {  ?>
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
                        <input type="text" class="form-control" name="drum_nos[]" value="<?= $daitems['drum_nos'] ?>">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="packing_type[]" value="<?= $daitems['packing_type'] ?>" >
                     </td>
                     <td>
                        <input type="text" class="form-control" name="description_of_goods[]" value="<?= $daitems['product']?>">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="excise_sr_no[]" value="<?= $daitems['excise_sr_no'] ?>">
                     </td>
                     <td>
                        <input type="text" class="form-control" name="box_no[]" value="<?= $daitems['box_no'] ?>">
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
                     <input type="hidden" name="packing_id_invoice[]" value="<?= $daitems['id'] ?>">
                     <input type="hidden" name="seal_no[]" value="<?= $daitems['seal_no']?>">
                  </tr>
                  <?php } } ?>             
               </tbody>
            </table>
         </div>
         <?php }  ?>
        
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
               <textarea class="form-control" rows="10" cols="15" name="declaration_final"><?= $invoice_data['declaretion_final']?>
               </textarea>
            </div>
         </div>
         <input type="hidden" name="financial_year" value="<?= $invoice_data['financial_year'] ?>">
         <input type="hidden" name="po_no" value="<?= $invoice_data['po_no'] ?>">
         <input type="hidden" name="invoice_no" value="<?= $invoice_data['id'] ?>">
         <input type="hidden" name="invoice_id" value="<?= $invoice_data['invoice_id'] ?>">
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-block">
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save Data And Generate Invoice</button>
         <a href="<?= base_url().$this->router->fetch_class().'/packing_list_invoice'?>" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;Cancel</a>
      </div>
   </div>
</form>