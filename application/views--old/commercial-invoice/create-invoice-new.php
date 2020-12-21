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

<form method="POST" action="<?= base_url().$this->router->fetch_class().'/generate_invoice/'.$da_header['id']?>">
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

           <div class="col-md-4 form-group">
              <label>Buyer Order Number:</label>
              <input type="text" name="buyer_order_number" id="buyer_order_number" class="form-control" value="<?= set_value('buyer_order_number', !empty($packing_invoice['buyer_order_number']) ? $packing_invoice['buyer_order_number'] : (
                  !empty($da_header['po_no']) ? $da_header['po_no']: '') ) ?>" placeholder="Enter buyer order number" required>
              <?= form_error('buyer_order_number') ?>
           </div>
        </div>

        <div class="row">
           <div class="col-md-4 form-group">
              <label>Buyer Order Date:</label>
              <input type="text" name="buyer_order_date" id="buyer_order_date" class="form-control" value="<?= set_value('buyer_order_date', !empty($packing_invoice['buyer_order_date']) ? $packing_invoice['buyer_order_date'] : (
                  !empty($da_header['po_date']) ? $da_header['po_date']: '') ) ?>" placeholder="Enter buyer order date" required>
              <?= form_error('buyer_order_date') ?>
           </div>

           <div class="col-md-4 form-group">
              <label>Contract Number:</label>
              <input type="text" name="contract_number" id="contract_number" class="form-control" value="<?= set_value('contract_number', !empty($packing_invoice['contract_number']) ? $packing_invoice['contract_number'] : '') ?>" placeholder="Enter contract number">
              <?= form_error('contract_number') ?>
           </div>

           <div class="col-md-4 form-group">
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

        <hr>

        <div class="row">
           <div class="col-md-6 form-group">
              <label>L/C Number:</label>
              <input class="form-control" type="text" name="lic_no" placeholder="LIC Number" value="<?= set_value('lic_no', !empty($packing_invoice['lic_no']) ? $packing_invoice['lic_no'] : (
                  !empty($da_header['lic_no']) ? $da_header['lic_no']: '') ) ?>" >
           </div> 
           <div class="col-md-6 form-group">
              <label>L/C Date:</label>
              <input class="form-control" type="text" name="lic_date" id="liiic_date"  placeholder="LIC date" value="<?= set_value('lic_date', !empty($packing_invoice['lic_date']) ? $packing_invoice['lic_date']  : ( !empty($da_header['lic_date']) ? nice_date($da_header['lic_date'], 'd-M-Y') : '') ) ?>" >
           </div>
        </div>  
        <hr>

        <div class="row">
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
              <input type="text" name="batch_no" id="payment" class="form-control" value="<?= set_value('batch_no', !empty($packing_invoice['batch_no']) ? $packing_invoice['batch_no'] : ( !empty($batch_no) ? $batch_no : '') )?>">
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
              <textarea class="form-control" name="shipping_marks_inv" rows="3" cols="5"><?= $da_header['shipping_marks']?><?= set_value('shipping_marks_inv', !empty($packing_invoice['shipping_marks']) ? $packing_invoice['shipping_marks']: ( !empty($da_header['shipping_marks']) ? $da_header['shipping_marks'] : '')) ?></textarea>
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
                  <th>Rate(<?= $da_header['currency_name'] ?>/KGS)</th>
                  <th>Amount (<?= $da_header['currency_name'] ?>)</th>
              </tr>
          </thead>
             <tbody>
              <?php if(!empty($da_items) ) {
                   $counter = 0;
                   $sum = 0;
                   foreach($da_items as $key => $daitems) {
                   $sum+= $daitems['amount'];
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
                       <input type="text" class="form-control" name="description_of_goods[]" value="<?= $daitems['product_name'].' HS CODE: '.$daitems['hscode'] ?>">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="quantity[]" value="<?= $daitems['quantity'] ?>" id="re-quantity-<?= $key ?>" onchange="reCalculation(<?= $key ?>)">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="rate[]" value="<?= $daitems['rate'] ?>" id="re-rate-<?= $key ?>" onchange="reCalculation(<?= $key ?>)">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="amount[]" value="<?= $daitems['amount'] ?>" id="re-amount-<?= $key ?>" >
                    </td>
                </tr>   
              <?php } } ?>             
             </tbody>
          </table>
      </div>
      <hr>
      <div class="row">
        <div class="form-group col-md-4">
           <label>Total:</label>
           <input type="text" name="total" class="form-control" value="<?=  !empty($da_items) ? number_format((float) $sum , 2, '.', '') : '' ?>" id="re-total" readonly>
        </div>
        <div class="form-group col-md-8">
           <label>Amount Chargeable (in words) <?= $da_header['currency_name'] ?>:</label>
           <input type="text" name="total_words" class="form-control" value="<?= !empty($da_items) ?convert_number(number_format((float) $sum , 2, '.', '')) : '' ?> Only" id="re-amount-words" readonly>
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
            <input class="check-box-invoice" type="checkbox" id="gst" name="type[]" value="1">
            <label for="vehicle2">GST</label>
          </div>
          <div class="form-group col-md-6" >
            <input class="check-box-invoice" type="checkbox" id="lut" name="type[]" value="2">
            <label for="vehicle2">EUNDER LUT Number</label>
          </div>
         </div>
       <div class="row">
          <div class="form-group col-md-4">
             <label>Exchange Rate (<?= $da_header['currency_name'] ?>):</label>
             <input type="text" name="exchange_rate" class="form-control" value=" <?= $da_header['exchange_rate']?>" id="exchange_rate" onchange="exchangeRate()">
          </div>

          <div class="form-group col-md-4">
             <label>IGST Rate:</label>
             <input type="text" name="gst_rate_hidden" class="form-control" value="12.00" id="gst_rate_hidden" onchange="igstCalculation()">
          </div>

          <div class="form-group col-md-4">
             <label>IGST Amount:</label>
             <input type="text" name="gst_amount_hidden" class="form-control" value=" <?= $da_header['gst_amt']?>" id="gst_amount_hidden" readonly>
          </div>
        
        </div>

        <div class="row">
          <div class="form-group col-md-6">
             <label>Taxable Value (INR):</label>
             <input type="text" name="taxable" class="form-control" value="0.00" id="taxable_amount_inr" >
          </div>
          <div class="form-group col-md-6">
             <label>Total Amount (INR)</label>
             <input type="text" name="total_amount" id="total_amount_inr" class="form-control" value="0.00" >
          </div>
      </div>

      <div class="row">
          <div class="form-group col-md-6">
             <label>EUNDER LUT:</label>
             <input type="text" name="eunder_lut" id="eunder_lut" class="form-control" value="0.00" >
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

      <p class="text-danger"><b>NOTE:</b> Please make the license or under dbk selection wisely as per your needs.</p>

        <div class="row">
          <div class="col-md-12">
               <label>UNDER DBK:</label>

               <input type="text" name="under_dbk" class="form-control" placeholder="ENTER UNDER DBK">

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
                      <input type="checkbox" name="ad_lic_no_array[]" class="form-control" value="<?= $value['id'] ?>" id="check-id-<?= $licenseKey ?>" data-id="<?= $licenseKey?>">
                    </td>
                    <td>
                      <input type="text" name="license_number[]" class="form-control my-class" value="<?= $value['lic_no'] ?>" disabled>
                    </td>
                    <td>
                      <input type="text" name="product[]" class="form-control my-class" value="<?= $value['product_name'] ?>" disabled>
                      <input class="my-class" type="hidden" name="product_id[]" value="<?= $value['product'] ?>" disabled>
                    </td>
                    <td>
                      <input type="text" name="lic_quantity[]" class="form-control my-class" value="0"  onclick="calculateLicnese(<?= $licenseKey ?>)" id="lic-quantity-<?= $licenseKey ?>" disabled>
                    </td>
                    <td>
                      <input type="text" name="total_quantity[]" class="form-control my-class" value="<?= $value['qty'] ?>" disabled>
                    </td>
                    <td>
                      <input type="text" name="eo_fulfilled[]" class="form-control my-class" value=" <?= $value['eo_fulfilled'] ?>" id="eo-fulfilled-<?= $licenseKey ?>" disabled>
                    </td>
                    <td>
                      <input type="text" name="eo_remaining[]" class="form-control my-class" value=" <?= $value['qty'] - $value['eo_fulfilled'] ?>" id="eo-remaining-<?= $licenseKey ?>" disabled>
                    </td>
                    <input class="my-class" type="hidden" name="lic_id[]" value="<?= $value['id']?>" disabled>
          
                  </tr>  
                 <?php }  ?>                 
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
                        <option value="<?= $value['id'] ?>"><?= $value['lic_no'] ?></option>
                    <?php } } ?>
                </select>
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
              <input type="text" name="pan_number" class="form-control" value="<?= set_value('pan_number', !empty($packing_invoice['pan_no']) ? $packing_invoice['pan_no'] : (
                  !empty($da_header['pan_no']) ? $da_header['pan_no']: '') ) ?>">
            </div>   
          
            <div class="form-group col-md-6"> 
              <label>I.E. CODE NO.:</label>
              <input type="text" name="ie_code_no" class="form-control" value="<?= set_value('ie_code_no', !empty($packing_invoice['ie_code_no']) ? $packing_invoice['ie_code_no'] : (
                  !empty($da_header['ie_code_no']) ? $da_header['ie_code_no']: '') )?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
              <label>CIN Number:</label>
              <input type="text" name="cin_no" class="form-control" value="<?= set_value('cin_no', !empty($packing_invoice['cin_no']) ? $packing_invoice['cin_no'] : (
                  !empty($da_header['cin_no']) ? $da_header['cin_no']: '')) ?>">
            </div>
            <div class="form-group col-md-6">
              <label>TIN Number:</label>
              <input type="text" name="tin_number" class="form-control" value="<?= set_value('tin_number', !empty($packing_invoice['tin_number']) ? $packing_invoice['tin_number'] : (
                  !empty($da_header['ie_code_no']) ? $da_header['ie_code_no']: ''))?>">
            </div>
        </div>
       

        <div class="row">
            <div class="form-group col-md-6">
              <label>GSTIN:</label>
              <input type="text" name="gstin" class="form-control" value="<?= set_value('gstin' , !empty($packing_invoice['gstin']) ? $packing_invoice['gstin'] : (
                  !empty($da_header['gstin']) ? $da_header['gstin']: '')) ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-5">
              <label>STATE:</label>
              <input type="text" name="state" class="form-control" value="<?= set_value('state' , !empty($packing_invoice['state']) ? $packing_invoice['state'] : (
                  !empty($da_header['state']) ? $da_header['state']: '')) ?>" required>
            </div>
            <div class="form-group col-md-2">
              <label>State CODE:</label>
              <input type="text" name="state_code" class="form-control" value="<?= set_value('state_code' , !empty($packing_invoice['state_code']) ? $packing_invoice['state_code'] : (
                  !empty($da_header['state_code']) ? $da_header['state_code']: ''))?>" required>
            </div>
            <div class="form-group col-md-5">
              <label>State of Origin:</label>
              <input type="text" name="state_of_origin" class="form-control" value="<?= set_value('state_of_origin' , !empty($packing_invoice['state_of_origin']) ? $packing_invoice['state_of_origin'] : (
                  !empty($da_header['state_of_origin']) ? $da_header['state_of_origin']: ''))?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
              <label>District Code:</label>
              <input type="text" name="district_code" class="form-control" value="<?= set_value('district_code' , !empty($packing_invoice['district_code']) ? $packing_invoice['district_code'] : (
                  !empty($da_header['district_code']) ? $da_header['district_code']: '')) ?>" required>
            </div>
        
            <div class="form-group col-md-6">
              <label>District of origin:</label>
              <input type="text" name="district_of_origin" class="form-control" value="<?= set_value('district_of_origin' , !empty($packing_invoice['district_of_origin']) ? $packing_invoice['district_of_origin'] : (
                  !empty($da_header['district_of_origin']) ? $da_header['district_of_origin']: ''))?>" required>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="form-group col-md-12">
              <label>Declaration:</label>
              <input type="text" name="declaration" class="form-control" value="<?= $da_header['declaration1']?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
              <label>NET WEIGHT:</label>
              <input type="text" name="net_weight" class="form-control" value="<?= number_format((float) $net_weight , 2, '.', '') ?> KGS" required>
            </div>
            <div class="form-group col-md-4">
              <label>TARE WEIGHT:</label>
              <input type="text" name="tare_weight" class="form-control" value="<?= number_format((float) $tare_weight , 2, '.', '') ?> KGS" required>
            </div>
           <div class="form-group col-md-4">
              <label>GROSS WEIGHT:</label>
              <input type="text" name="gross_weight" class="form-control" value="<?= number_format((float) $gross_weight , 2, '.', '') ?> KGS" required>
            </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12">
             <label>Declaration:</label>
             <textarea class="form-control" rows="10" cols="5" name="declaration_final"> <ol>
           <li>We declare that this Invoice shows actual price of the goods described &amp; that all the particulars are true and correct.</li>
           <li>Cetified that the Country of Origin of these goods is India.</li>
           <li>In case of any Quality issue please intimate in writing along with the Test Report within 21 days for Oral products and 30 days for Sterile products from the date of shipment. Any claims received after the above mentioned period shall not be entertained and the buyer will be liable to pay the Full Invoice on due date.</li>
           <li>For any delay in receipt after due date, a penal interest @ 21 % for the delayed period will be payable by the buyer to the seller.</li>
          
         </ol></textarea>
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

        <a href="<?= base_url().$this->router->fetch_class()?>" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;Cancel</a>

     </div>
  </div>
</form>

