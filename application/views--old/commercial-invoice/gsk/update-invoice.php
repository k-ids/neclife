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

<form method="POST" action="<?= base_url().$this->router->fetch_class().'/update_gsk_invoice/'.$invoice_data['invoice_id']?>">
  <div class="card mb-3">
        <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>ESSENTIAL DETAILS</b>
     </div>
  <div class="card-block">

        <div class="row">
           <div class="col-md-6 form-group">
              <label>Exporter/Manufacturer/Beneficiary - Name & Address:</label>
              <textarea class="form-control" name="address" rows="5" cols="5" placeholder="Enter the text here..."><?= $invoice_data['address']?></textarea>
              <?= form_error('address') ?>
           </div>
           <div class="col-md-6 form-group">
              <label>Export Reference:</label>
              <textarea class="form-control" name="export_reference" rows="5" cols="5" placeholder="Enter the text here..."><?= $invoice_data['export_reference']?></textarea>
           </div>
        </div>
        <hr>

        <div class="row">
           <div class="col-md-4 form-group">
              <label>Invoice Number:</label>
              <input type="text" name="invoice_no_e" id="invoice_no_e" class="form-control" value="<?= set_value('invoice_no_e', $invoice_data['invoice_no'] ) ?>" placeholder="Enter invoice number" required>
              <?= form_error('invoice_no') ?>
           </div>

           <div class="col-md-4 form-group">
              <label>Invoice Date:</label>
              <input type="text" name="invoice_date" id="invoice_date" class="form-control" value="<?= set_value('invoice_date', $invoice_data['invoice_date']) ?>" placeholder="Enter invoice date" required>
              <?= form_error('invoice_date') ?>
           </div>

           <div class="col-md-4 form-group">
              <label>Buyer Order Number:</label>
              <input type="text" name="buyer_order_number" id="buyer_order_number" class="form-control" value="<?= set_value('buyer_order_number' , $invoice_data['buyer_order_number']) ?>" placeholder="Enter buyer order number" required>
              <?= form_error('buyer_order_number') ?>
           </div>
        </div>

        <div class="row">
           <div class="col-md-4 form-group">
              <label>Buyer Order Date:</label>
              <input type="text" name="buyer_order_date" id="buyer_order_date" class="form-control" value="<?= set_value('buyer_order_date' , $invoice_data['buyer_order_date']) ?>" placeholder="Enter buyer order date" required>
              <?= form_error('buyer_order_date') ?>
           </div>

           <div class="col-md-4 form-group">
              <label>Contract Number:</label>
              <input type="text" name="contract_number" id="contract_number" class="form-control" value="<?= set_value('contract_number', $invoice_data['contract_number']) ?>" placeholder="Enter contract number">
              <?= form_error('contract_number') ?>
           </div>

           <div class="col-md-4 form-group">
              <label>Contract Date:</label>
              <input type="text" name="contract_date" id="contract_date" class="form-control" value="<?= set_value('contract_date', $invoice_data['contract_date']) ?>" placeholder="Enter contract date" >
              <?= form_error('contract_date') ?>
           </div>
        </div>
        <hr>

        <div class="row">
           <div class="col-md-12 form-group">
              <label>Other reference(s):</label>
              <input class="form-control" type="text" name="other_reference" value="<?= set_value('other_reference', $invoice_data['other_reference']) ?>" placeholder="Enter the text here..">
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
              <input class="form-control" type="text" name="da_date"  placeholder="DA date" value="<?= set_value('da_date', $invoice_data['da_date'] ) ?>" readonly required>
           </div>
        </div>
        <hr>
        <div class="row">
           <div class="col-md-6 form-group">
              <label>L/C Number:</label>
              <input class="form-control" type="text" name="lic_no" placeholder="LIC Number" value="<?= set_value('lic_no', $invoice_data['lic_no']) ?>">
           </div>
           <div class="col-md-6 form-group">
              <label>L/C Date</label>
              <input class="form-control" type="text" name="lic_date" id="liiic_date"  placeholder="LIC date" value="<?= set_value('lic_date', !empty($invoice_data['lic_date']) ? $invoice_data['lic_date'] : '') ?>">
           </div>
        </div>

        <hr>

         <div class="row">
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
              <input type="text" name="place_of_reciept" id="place_of_reciept" class="form-control" value="<?= set_value('place_of_reciept', $invoice_data['Place_of_reciept'])?>">
            </div>
            <div class="form-group col-md-4">
              <label>Country of Origin:</label>
              <input type="text" name="country" id="country" class="form-control" value="<?= set_value('country', $invoice_data['country'])?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
              <label>Country of Final Destination:</label>
              <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination', $invoice_data['final_destination'] )?>">
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
            <div class="form-group col-md-12">
              <label>Final Destination:</label>
              <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination', $invoice_data['final_destination'])?>">
            </div>
         
        </div>
        <hr>

        <div class="row">
          
           <div class="col-md-12">
            <div class="form-group">
              <label>Shipping marks:</label>
              <textarea class="form-control" name="shipping_marks_inv" rows="3" cols="5"><?= $invoice_data['shipping_marks']?></textarea>
            </div>
           </div>
        </div>      
     </div>
  </div>

  <div class="card mb-3">
     <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>DA ITEM</b>
     </div>
     <div class="card-block">
        
        <div class="card-block">
         <div class="table-responsive">
          <table class="table table-bordered re-calculate" width="200%" id="dataTable" cellspacing="0">
          <thead>
              <tr>
                  <th>Sr.No</th>
                  <th>Marks and Drum Nos</th>
                  <th>No. & Kind of Packages</th>
                  <th>Description of Goods and/or Services</th>
                  <th>Quantity(KGS)</th>
                  <th>Rate(<?= $invoice_data['currency_name'] ?>/KGS)</th>
                  <th>Amount (<?= $invoice_data['currency_name'] ?>)</th>
              </tr>
          </thead>
             <tbody>
              <?php if(!empty($da_items) ) {
                   $counter = 0;
                   $sum = 0;
                   $prev_total_quantity = 0;
                   foreach($da_items as $key => $daitems) {
                   $sum+= $daitems['amount'];
                   $prev_total_quantity += $daitems['qty'];
              ?>
                <tr>
                    <td>
                       <?= ++$counter; ?>
                    </td>
                    <td>
                       <input type="text" class="form-control" name="drum_nos[]" value="<?= $daitems['marks_drum_no'] ?>">
                    </td>  
                    <td>
                       <input type="text" class="form-control" name="packing_type[]" value="<?= $daitems['kind_of_package'] ?>" >
                    </td>      
                    <td>
                       <input type="text" class="form-control" name="description_of_goods[]" value="<?= $daitems['description_of_goods'] ?>" >
                    </td>
                    <td>
                       <input type="text" class="form-control" name="qty[]" value="<?= $daitems['qty'] ?>" id="re-qty-<?= $key ?>" onchange="reCalculation(<?= $key ?>)">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="rate[]" value="<?= $daitems['rate'] ?>" id="re-rate-<?= $key ?>" onchange="reCalculation(<?= $key ?>)">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="amount[]" value="<?= $daitems['amount'] ?>" id="re-amount-<?= $key ?>">
                    </td>
                    <input type="hidden" name="item_id_invoice[]" value="<?= $daitems['id'] ?>">
                </tr>   
              <?php } } ?>             
             </tbody>
          </table>
          
      </div>
      <hr>
      <div class="row">
        <div class="form-group col-md-4">
           <label>Total:</label>
           <input type="text" name="total" class="form-control" value="<?= set_value('total' , $invoice_data['total'] ) ?>" id="re-total" readonly>
        </div>
        <div class="form-group col-md-8">
           <label>Amount Chargeable (in words) <?= $invoice_data['currency_name'] ?>:</label>
           <input type="text" name="total_words" class="form-control" value="<?= set_value('total_words' ,$invoice_data['total_amount_words'] ) ?>" id="re-amount-words" readonly>
        </div>
      </div>
    </div>
  </div>
    
  </div>
    <div class="card mb-3">
      <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>GSK Packing For Review </b>(<small>Changes to GSK packing are not possible from here. you can only review the data.</small>)
      </div>

      <div class="card-block">
          <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="table-gsk-packing-list" cellspacing="0">
              <thead>
                 <tr>
                     <th>S.No.</th>
                     <th>Excise S.No.</th>
                     <th>Bag No. <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Add the Bag No to 1-6 format."></i></th>
                     <th>Batch No.</th>
                     <th>Mfg Date</th>
                     <th>Retest Date</th>
                     <th>Tare Wt.(Polybag)</th>
                     <th>Net Wt.</th>
                     <th>Gross Wt.(Bag)</th>
                     <th>Tare Wt.(Corrugated Box)</th>
                     <th>Gross Wt.(Corrugated Box) <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="CALCULATION:  (Gross Wt.(Bag) * 6) + Tare Wt.(Corrugated Box) = Gross Wt.(Corrugated Box)"></i></th>
                     <th>Gross Wt.(Pallet)</th>
                     
                 </tr>
              </thead>
              <tbody id="table-gsk-packing-list-row">
               <?php if(!empty($gsk_packing_map)) {
                foreach($gsk_packing_map as $key => $value) { ?>
    
                <tr class="db-data" style="background: aliceblue;">
                  <td>
                    <div class="form-group">
                      <input type="text" name="serial_no[]" class="form-control" value="<?= $value['serial_no'] ?>" id="serial_no-<?= $key + 1000 ?>" readonly>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="excise_serial_no[]" class="form-control" value="<?= $value['excise_serial_no'] ?>" id="excise_serial_no-<?= $key + 1000 ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="bag_no[]" class="form-control" value="<?= $value['bag_no'] ?>" id="bag_no-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="batch_no[]" class="form-control" value="<?= $value['batch_no'] ?>" id="batch_no-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="mfg_date[]" class="form-control mfg_date" value="<?= $value['mfg_date'] ?>" id="mfg_date-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="retest_date[]" class="form-control retest_date" value="<?= $value['retest_date'] ?>" id="retest_date-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt[]" class="form-control" value="<?= $value['tare_wt'] ?>" id="tare_wt-<?= $key + 1000 ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="net_wt[]" class="form-control" value="<?= $value['net_wt'] ?>" id="net_wt-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt[]" class="form-control" value="<?= $value['gross_wt'] ?>" id="gross_wt-<?= $key + 1000 ?>" onchange="grossWeightCalculation(<?= $key + 1000 ?>)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt_corrugated[]" class="form-control" value="<?= $value['tare_wt_corrugated'] ?>" id="tare_wt_corrugated-<?= $key + 1000 ?>" onchange="grossWeightCalculation(<?= $key + 1000 ?>)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_corrugated[]" class="form-control" value="<?= $value['gross_wt_corrugated'] ?>" id="gross_wt_corrugated-<?= $key + 1000 ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_pallet[]" class="form-control" value="<?= $value['gross_wt_pallet'] ?>" id="gross_wt_pallet-<?= $key + 1000 ?>">
                    </div>
                  </td>

                 </tr>
              <?php } } ?>
              
              </tbody>
           
              </table>
            </div>

              <div class="row">

             <div class="form-group col-md-12">
                 <label>GSK Packing Additional Information:</label>
                 <textarea class="form-control" rows="10" cols="5" name="gsk_info"><?= !empty($gsk_packing) ? $gsk_packing['gsk_info'] : ''?></textarea>
            </div>
            
            <div class="form-group col-md-12">
                 <label>Pallet Dimensions:</label>
                 <textarea class="form-control" rows="2" cols="2" name="pallet_dimensions"><?= !empty($gsk_packing) ? $gsk_packing['pallet_dimensions'] : ''?></textarea> 
          </div>

      </div>
      </div>
          
    </div>


  <div class="card mb-3">
    <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>ADVANCE LICENSE</b>
     </div>
    <div class="card-block">
        
       <div class="row">

         <div class="form-group col-md-8">
          <label>Advanace License File No.</label>

          <input type="text" name="adv_license_file_no" value="<?= set_value('adv_license_file_no', !empty($invoice_data['ad_lic_file_no']) ?  $invoice_data['ad_lic_file_no'] : '') ?>" class="form-control">

         </div>
         
       </div>  
       
     
  </div>
</div>
   

  
  <div class="card mb-3">
     <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>ESSENTIAL DETAILS</b>
     </div>
     <div class="card-block">
        <div class="row">
            <div class="form-group col-md-6">
              <label>Pan Number:</label>
              <input type="text" name="pan_number" class="form-control" value="<?= set_value('pan_number', $invoice_data['pan_number']) ?>">
            </div>
            <div class="form-group col-md-6">
              <label>I.E. CODE NO.:</label>
              <input type="text" name="ie_code_no" class="form-control" value="<?= set_value('ie_code_no', $invoice_data['ie_code_no'])?>">
            </div>
        </div>    
      
        <div class="row">
            <div class="form-group col-md-6">
              <label>TIN Number:</label>
              <input type="text" name="tin_number" class="form-control" value="<?= set_value('tin_number', $invoice_data['tin_number']) ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label>CIN NO.:</label>
              <input type="text" name="cin_no" class="form-control" value="<?= set_value('cin_no' , $invoice_data['cin_no']) ?>" required>
            </div>
        </div>
         <div class="row">
            <div class="form-group col-md-6">
              <label>GSTIN:</label>
              <input type="text" name="gstin" class="form-control" value="<?= set_value('gstin', $invoice_data['gstin']) ?>" required>
            </div>
          </div>
         <div class="row">
            <div class="form-group col-md-5">
              <label>STATE:</label>
              <input type="text" name="state" class="form-control" value="<?= set_value('state' , $invoice_data['state']) ?>" required>
            </div>
            <div class="form-group col-md-2">
              <label>State CODE:</label>
              <input type="text" name="state_code" class="form-control" value="<?= set_value('state_code' , $invoice_data['state_code'] )?>" required>
            </div>
            <div class="form-group col-md-5">
              <label>State of Origin:</label>
              <input type="text" name="state_of_origin" class="form-control" value="<?= set_value('state_of_origin' , $invoice_data['state_of_origin'])?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
              <label>District Code:</label>
              <input type="text" name="district_code" class="form-control" value="<?= set_value('district_code' , $invoice_data['district_code']) ?>" required>
            </div>
        
            <div class="form-group col-md-6">
              <label>District of origin:</label>
              <input type="text" name="district_of_origin" class="form-control" value="<?= set_value('district_of_origin' , $invoice_data['district_of_origin'])?>" required>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="form-group col-md-12">
              <label>Declaration:</label>
              <input type="text" name="declaration" class="form-control" value="<?= $invoice_data['declaration']?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
              <label>NET WEIGHT:</label>
              <input type="text" name="net_weight" class="form-control" value="<?= set_value('net_weight', $invoice_data['net_weight']) ?>" required>
            </div>
            <div class="form-group col-md-4">
              <label>TARE WEIGHT:</label>
              <input type="text" name="tare_weight" class="form-control" value="<?= set_value('net_weight', $invoice_data['tare_weight']) ?> " required>
            </div>
           <div class="form-group col-md-4">
              <label>GROSS WEIGHT:</label>
              <input type="text" name="gross_weight" class="form-control" value="<?= set_value('gross_weight', $invoice_data['gross_weight']) ?>" required>
            </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12">
             <label>Declaration:</label>
             <textarea class="form-control" rows="10" cols="5" name="declaration_final"><?= set_value('declaration_final', $invoice_data['declaretion_final']) ?></textarea>
           </div>
        </div>

        <input type="hidden" name="financial_year" value="<?= $invoice_data['financial_year'] ?>">
        <input type="hidden" name="po_no" value="<?= $invoice_data['po_no'] ?>">

         <input type="hidden" name="invoice_no" value="<?= $invoice_data['id'] ?>">
         <input type="hidden" name="invoice_id" value="<?= $invoice_data['invoice_id'] ?>">
        <input type="hidden" name="currency_name" value="<?= $invoice_data['currency_name'] ?>">

     </div>
  </div>

  <div class="card mb-3">
     <div class="card-block">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save Data And Generate Invoice</button>

        <a href="<?= base_url().$this->router->fetch_class()?>" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;Cancel</a>

     </div>
  </div>
</form>

