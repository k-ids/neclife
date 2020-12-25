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

<form method="POST" action="<?= base_url().$this->router->fetch_class().'/update_invoice/'.$invoice_data['invoice_id']?>">
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

           <div class="col-md-8 form-group">
              <label>Buyer/Intend/Contract Title:</label>
              <input type="text" name="buyer_order_number" id="buyer_order_number" class="form-control" value="<?= set_value('buyer_order_number' , $invoice_data['buyer_order_number']) ?>" placeholder="Enter buyer order number" required>
              <?= form_error('buyer_order_number') ?>
           </div>
        </div>

        <div class="row">
           <div class="col-md-8 form-group">
              <label>Buyer/Intend/Contract Date:</label>
              <input type="text" name="buyer_order_date" id="buyer_order_date" class="form-control" value="<?= set_value('buyer_order_date' , $invoice_data['buyer_order_date']) ?>" placeholder="Enter buyer order date" required>
              <?= form_error('buyer_order_date') ?>
           </div>

           <div class="col-md-4 form-group" style="display: none;">
              <label>Contract Number:</label>
              <input type="text" name="contract_number" id="contract_number" class="form-control" value="<?= set_value('contract_number', $invoice_data['contract_number']) ?>" placeholder="Enter contract number">
              <?= form_error('contract_number') ?>
           </div>

           <div class="col-md-4 form-group" style="display: none;">
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
            <div class="form-group col-md-4">
              <label>Final Destination:</label>
              <input type="text" name="final_destination" id="final_destination" class="form-control" value="<?= set_value('final_destination', $invoice_data['final_destination'])?>">
            </div>
         
            <div class="form-group col-md-8">
              <label>Batch No:</label>
              <input type="text" name="batch_no" id="payment" class="form-control" value="<?= set_value('batch_no', $invoice_data['batch_no'] )?>">
            </div>
        </div>
        <hr>

        <div class="row">
           <div class="col-md-6">
               <div class="form-group">
                 <label>Manufacturing date:</label>
                 <input type="text" name="mfg_date" id="mfg_date" class="form-control" value="<?= set_value('mfg_date', $invoice_data['mfg_date'] )?>">
               </div>
               <div class="form-group">
                 <label>Expiry Date:</label>
                 <input type="text" name="exp_date" id="exp_date" class="form-control" value="<?= set_value('exp_date', $invoice_data['exp_date'])?>">
               </div>
           </div>
           <div class="col-md-6">
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
                       <input type="text" class="form-control" name="drum_nos[]" value="<?= $daitems['drum_nos'] ?>">
                    </td>  
                    <td>
                       <input type="text" class="form-control" name="packing_type[]" value="<?= $daitems['packing_type'] ?>" >
                    </td>      
                    <td>
                       <input type="text" class="form-control" name="description_of_goods[]" value="<?= $daitems['product'] ?>" >
                    </td>
                    <td>
                       <input type="text" class="form-control" name="quantity[]" value="<?= $daitems['qty'] ?>" id="re-quantity-<?= $key ?>" onchange="reCalculation(<?= $key ?>)">
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
          <input type="hidden" name="prev_total_quantity" value="<?= $prev_total_quantity ?>">
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
     <hr>
      <div class="row">
          <div class="form-group col-md-6">
            <p class="text-danger">Only checked item data will be display on invoice respectively.</p>
          </div>
      </div>
      <div class="row">
          <div class="form-group col-md-6">
            <input class="check-box-invoice" type="checkbox" id="gst" name="type[]" value="1" <?= !empty($invoice_data['invoice_type'] == '1') ? 'checked' : ''?>>
            <label for="vehicle2">GST</label>
          </div>
          <div class="form-group col-md-6" >
            <input class="check-box-invoice" type="checkbox" id="lut" name="type[]" value="2" <?= !empty($invoice_data['invoice_type'] == '2') ? 'checked' : ''?>>
            <label for="vehicle2">EUNDER LUT Number</label>
          </div>
      </div>

     <div class="row">
        <div class="form-group col-md-4">
           <label>Exchange Rate (<?= $invoice_data['currency_name'] ?>):</label>
           <input type="text" name="exchange_rate" class="form-control" value="<?= set_value('exchange_rate', $invoice_data['exchange_rate'] ) ?>" id="exchange_rate" onchange="exchangeRate()" <?= !empty($invoice_data['invoice_type'] == '2') ? 'readonly' : ''?>>
        </div>
        
        <div class="form-group col-md-4">
           <label>IGST Rate:</label>
           <input type="text" name="gst_rate_hidden" class="form-control" value=" <?= $invoice_data['gst_per']?>" id="gst_rate_hidden" onchange="igstCalculation()">
        </div>

        <div class="form-group col-md-4">
           <label>IGST Amount:</label>
           <input type="text" name="gst_amount_hidden" class="form-control" value=" <?= $invoice_data['gst_amount']?>" id="gst_amount_hidden" readonly>
        </div>

      </div>

      <div class="row">
          <div class="form-group col-md-6">
           <label>Taxable Value (INR):</label>
           <input type="text" name="taxable" class="form-control" value="<?= set_value('exchange_rate', $invoice_data['taxable'] ) ?>" id="taxable_amount_inr" <?= !empty($invoice_data['invoice_type'] == '2') ? 'readonly' : ''?> readonly>
          </div>
           <div class="form-group col-md-6">
             <label>Total Amount (INR)</label>
             <input type="text" name="total_amount" class="form-control" value="<?= set_value('exchange_rate', $invoice_data['total_amount'] ) ?>" id="total_amount_inr" <?= !empty($invoice_data['invoice_type'] == '2') ? 'readonly' : ''?> readonly>
        </div>

      </div>

      <div class="row">
          <div class="form-group col-md-6">
             <label>EUNDER LUT:</label>
             <input type="text" name="eunder_lut" class="form-control" value="<?= set_value('exchange_rate', $invoice_data['eunder_lut'] ) ?>" <?= !empty($invoice_data['invoice_type'] == '1') ? 'readonly' : ''?> id="eunder_lut"> 
          </div>
      </div>
    </div>
    </div>
  </div>
   

  <div class="card mb-3">
     <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>ADVANCE AND EPCG LICENSE</b>
      </div>
    <div class="card-block">
      
      <input type="hidden" name="db_lic_no" value="<?= $invoice_data['ad_lic_no'] ?>">
      <input type="hidden" name="db_lic_qty" value="<?= $invoice_data['license_qty_used']?>">

        <p class="text-danger"><b>NOTE:</b> Please make the license or under dbk selection wisely as per your needs.</p>

        <div class="row">
          <div class="col-md-12">
               <label>UNDER DBK:</label>

               <input type="text" name="under_dbk" class="form-control" placeholder="ENTER UNDER DBK" value="<?= $invoice_data['under_dbk']?>">

          </div>
        </div>
        <br> <hr>


      <label>Advance Licnese Number:</label>
      <?php if(!empty($license_array)) {  ?>
        <div class="table-responsive">
          <table class="table table-bordered" width="200%" id="dataTable" cellspacing="0">
          <thead>
              <tr>
                  <th>Check License</th>
                  <th>License Number</th>
                  <th>Product</th>
                  <th>Enter Quantity</th>
                  <th>Total Quantity</th>
                  <th>EO Fulfilled</th>
                  <th>EO Remaining</th>
              </tr>
          </thead>
           <tbody>
            <?php      
                    foreach($license_array as $licenseKey => $value) { ?>
                    
                    <tr  id="row-<?= $licenseKey ?>">
                      <td>
                        <input type="checkbox" name="ad_lic_no_array[]" class="form-control" value="<?= $value['id'] ?>" id="check-id-<?= $licenseKey ?>" data-id="<?= $licenseKey?>"  <?= selectedLicense($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <td>
                        <input type="text" name="license_number[]" class="form-control my-class" value="<?= $value['lic_no'] ?>"  <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <td>
                        <input type="text" name="product[]" class="form-control my-class" value="<?= $value['product_name'] ?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                        <input class="my-class" type="hidden" name="product_id[]" value="<?= $value['product'] ?>" disabled>
                      </td>
                      <td>
                        <input type="text" name="lic_quantity[]" class="form-control my-class" value="<?= lic_quantity($invoice_data['da_no'], $value['id'], $invoice_data['invoice_id']) ?>"  onclick="calculateLicnese(<?= $licenseKey ?>)" id="lic-quantity-<?= $licenseKey ?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <td>
                        <input type="text" name="total_quantity[]" class="form-control my-class" value="<?= $value['qty'] ?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <td>
                        <input type="text" name="eo_fulfilled[]" class="form-control my-class" value=" <?= $value['eo_fulfilled'] ?>" id="eo-fulfilled-<?= $licenseKey ?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <td>
                        <input type="text" name="eo_remaining[]" class="form-control my-class" value=" <?= $value['qty'] - $value['eo_fulfilled'] ?>" id="eo-remaining-<?= $licenseKey ?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                      </td>
                      <input class="my-class" type="hidden" name="lic_id[]" value="<?= $value['id']?>" <?= disabled($invoice_data['da_no'], $value['id']) ?>>
                    </tr> 

               <?php } ?>                 
             </tbody>
          </table>
      </div>
      <?php } else { ?>
             <p class="text-danger text-center">No Advance Licnese availbale.</p>
      <?php } ?>
      <hr>

         <div class="row">
            <div class="form-group col-md-12">              
                <label>EPCG License No:</label>
                <select class="form-control" name="epcg_lic_no_array">
                    <option value="">Select one</option>
                    <?php if(!empty($epcg_license)) { 
                    foreach($epcg_license as $value) { ?>
                        <option value="<?= $value['id'] ?>" <?php if($invoice_data['epcg_lic_no'] == $value['id']) { echo "selected"; }?>><?= $value['lic_no'] ?></option>
                    <?php } } ?>
                </select>
                <input type="hidden" name="db_epcg_lic" value="<?= $invoice_data['epcg_lic_no']?>">
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

        <input type="hidden" name="qty_used" value="<?= $invoice_data['license_qty_used'] ?>">

         <input type="hidden" name="invoice_no" value="<?= $invoice_data['id'] ?>">
         <input type="hidden" name="invoice_id" value="<?= $invoice_data['invoice_id'] ?>">
        <input type="hidden" name="currency_name" value="<?= $invoice_data['currency_name'] ?>">

     </div>
  </div>

  <div class="card mb-3">
     <div class="card-header" style="background: aquamarine;">
        <i class="fa fa-table" style="color: green;"></i> <b>Invoice Format Adjustment</b>
     </div>
     <div class="card-block">

      <div class="row">
           <div class="form-group col-md-6">
             <label>Manage Custom Invoice Height:
             <input type="number" name="custom_blank_counter" min="0" step="1" value="<?= $invoice_data['custom_blank_counter'] ?>" class="form-control">
           </div>
           <div class="form-group col-md-6">
             <label>Manage Customer Invoice Height: 
             </label>
             <input type="number" name="customer_blank_counter" min="0" step="1" value="<?= $invoice_data['customer_blank_counter'] ?>" class="form-control">
           </div>
        </div>

        <div class="row">
           <div class="form-group col-md-3">
             <label>Margin Top:</label>
             <input type="number" name="margin_top" min="5" step="1" value="<?= $invoice_data['margin_top'] ?>" class="form-control">
           </div>
           <div class="form-group col-md-3">
             <label>Margin Bottom:</label>
             <input type="number" name="margin_bottom" min="5" step="1" value="<?= $invoice_data['margin_bottom'] ?>" class="form-control">
           </div>
           <div class="form-group col-md-3">
             <label>Margin Left:</label>
             <input type="number" name="margin_left" min="5" step="1" value="<?= $invoice_data['margin_left'] ?>" class="form-control">
           </div>
           <div class="form-group col-md-3">
             <label>Margin Right:</label>
             <input type="number" name="margin_right" min="5" step="1" value="<?= $invoice_data['margin_right'] ?>" class="form-control">
           </div>
        </div>

     </div>
  </div>

  <div class="card mb-3">
     <div class="card-block">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save Data And Generate Invoice</button>

        <a href="<?= base_url().$this->router->fetch_class()?>" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;Cancel</a>

     </div>
  </div>
</form>

