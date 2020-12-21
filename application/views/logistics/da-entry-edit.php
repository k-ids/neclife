<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item active">Logistics</li>
   <li class="breadcrumb-item"><a href="<?= base_url().'logistics'?>">DA Entry</a></li>
</ol>
<!-- Example Tables Card -->



<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-dashcube" style="color: green;"></i>&nbsp;<b>DA Preparation</b>
   </div>
     <div class="card-block">
          <a href="<?= base_url().'logistics/da_entry'?>" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;New</a>
          <a href="<?= base_url().'logistics'?>" class="btn btn-warning"><i class="fa fa-search"></i>&nbsp;Find</a>
      </div>
</div>


<form method="POST"  action="<?=base_url().'logistics/edit_da_entry/'.$da_header['id']?>">

<div class="card mb-3">

  <div class="row">

    <div class="col-md-8">
         
          <div class="card-block">
               
               <div class="row">
                 
                  <div class="col-md-6 form-group">
                    <label>Financial Year:</label>
                    <input type="text" name="financial_year" id="financial_year" class="form-control" placeholder="Enter Financial year" value="<?= set_value('financial_year' , isset($da_header['financial_year']) ? $da_header['financial_year'] : $this->session->userdata('financial_year') ) ?>" readonly required>
                    <?= form_error('financial_year') ?>
                  </div>

                  <div class="col-md-6 form-group">
                    <label>DA Type:</label>
                    <select class="form-control" name="datype" id="datype" required readonly>
                       <option value="">Select DA Type</option> 
                       <?php if(!empty($da_type)) {
                        foreach ($da_type as $key => $value) { ?>
                              <option value="<?= $value['id'] ?>" <?php if($da_header['da_type'] == $value['id']) { echo "selected"; }?>><?= $value['datype'] ?></option>
                          <?php 
                           }
                        }
                        ?>
                    </select>
                    <?= form_error('datype') ?>
                  </div>

                </div>

                  <div class="row">
                 
                    <div class="col-md-6 form-group">
                       <label>LC No:</label>
                       <input type="text" name="lc_no" id="lc_no" class="form-control" placeholder="Enter LC No" value="<?= set_value('lc_no',  $da_header['lc_no']) ?>">
                       <?//= form_error('lc_no') ?>
                     </div>

                     <div class="col-md-6 form-group">
                       <label>LC Date:</label>
                       <input type="text" name="lc_date_1" id="lc_date_1" class="form-control" placeholder="Enter LC Date" value="<?= set_value('lc_date', nice_date($da_header['lc_date'], 'd-M-Y')) ?>" required>
                       <?= form_error('lc_date') ?>
                     </div>

                </div>

                <div class="row">
                 
                     <div class="col-md-6 form-group">
                       <label>DA No:</label>
                       <input type="text" name="da_no" id="da_no" class="form-control" placeholder="Enter DA No" value="<?= set_value('da_no', $da_header['da_no']) ?>" readonly>
                       <?= form_error('da_no') ?>
                     </div>

                     <div class="col-md-6 form-group">
                       <label>DA Date:</label>
                       <input type="text" name="da_date_1" id="da_date_1" class="form-control" placeholder="Enter DA Date" value="<?= set_value('da_date', nice_date($da_header['da_date'], 'd-M-Y')) ?>" required>
                       <?= form_error('da_date') ?>
                     </div>

                </div>

                <div class="row">
                 
                     <div class="col-md-6 form-group">
                       <label>PO No:</label>
                       <input type="text" name="po_no" id="po_no" class="form-control" placeholder="Enter PO No" value="<?= set_value('po_no', $da_header['po_no']) ?>">
                       <?//= form_error('po_no') ?>
                     </div>

                     <div class="col-md-6 form-group">
                       <label>PO Date:</label>
                       <input type="text" name="po_date_1" id="po_date_1" class="form-control" placeholder="Enter PO Date" value="<?= set_value('po_date', nice_date($da_header['po_date'], 'd-M-Y')) ?>">
                       <?//= form_error('po_date') ?>
                     </div>

                </div>
                <hr>
                <div class="row">
                 
                     <div class="col-md-12 form-group">
                       <label>Buyer:</label>
                       <select onchange="getBuyerInfo(this, 1)" name="buyer" id="buyer" class="form-control" required>
                         <option value="">Select Buyer</option>
                         <?php if(!empty($buyer)) {
                                  foreach ($buyer as $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?php if($da_header['buyer'] == $value['id']) { echo "selected"; }?>><?= $value['party'] ?></option>
                            <?php }
                              } 
                          ?>
                       </select>
                       <?= form_error('buyer') ?>
                         <?php $party =  getName( $da_header['buyer'] ) ?>
                         <div id="party-1" style="display:block; border: 1px solid black;border-style: dashed; padding: 10px;background: yellow;">
                           <span id="address1-1"><?= $party['address1']?></span><br>
                           <span id="address2-1"><?= $party['address2']?></span><br>
                           <span id="address3-1"><?= $party['address3']?></span><br>
                           <span id="fax-tel-1"><?= $party['fax'].' '.$party['phone']?></span>

                        </div>
                     </div>
                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Consignee:</label>
                          <select onchange="getBuyerInfo(this, 2)" name="consignee" id="consignee" class="form-control" required>
                           <option value="">Select Consignee</option>
                           <?php if(!empty($buyer)) {
                                    foreach ($buyer as $value) { ?>
                                      <option value="<?= $value['id'] ?>" <?php if($da_header['consignee'] == $value['id']) { echo "selected"; }?> ><?= $value['party'] ?></option>
                              <?php }
                                } 
                            ?>
                         </select>
                       <?= form_error('consignee') ?>

                        <?php $party =  getName( $da_header['consignee'] ) ?>
                         <div id="party-2" style="display:block; border: 1px solid black;border-style: dashed; padding: 10px;background: yellow;">
                           <span id="address1-2"><?= $party['address1']?></span><br>
                           <span id="address2-2"><?= $party['address2']?></span><br>
                           <span id="address3-2"><?= $party['address3']?></span><br>
                           <span id="fax-tel-2"><?= $party['fax'].' '.$party['phone']?></span>

                        </div>
                     </div>

                </div>
                
                <hr>

                <div class="row">
                 
                     <div class="col-md-12 form-group">
                       <label>Notify 1:</label>
                       <select onchange="getBuyerInfo(this, 3)" name="notify_1" id="notify_1" class="form-control">
                         <option value="">Select Notify 1</option>
                         <?php if(!empty($buyer)) {
                                  foreach ($buyer as $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?php if($da_header['notify'] == $value['id']) { echo "selected"; }?>><?= $value['party'] ?></option>
                            <?php }
                              } 
                          ?>
                       </select>
                     
                        <?php $party =  getName( $da_header['notify'] ) ?>
                         <div id="party-3" style="display:block; border: 1px solid black;border-style: dashed; padding: 10px;background: yellow;">
                           <span id="address1-3"><?= $party['address1']?></span><br>
                           <span id="address2-3"><?= $party['address2']?></span><br>
                           <span id="address3-3"><?= $party['address3']?></span><br>
                           <span id="fax-tel-3"><?= $party['fax'].' '.$party['phone']?></span>

                        </div>
                     </div>
                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Notify 2:</label>
                       <select onchange="getBuyerInfo(this, 4)"  name="notify_2" id="notify_2" class="form-control">
                         <option value="">Select Notify 2</option>
                         <?php if(!empty($buyer)) {
                                  foreach ($buyer as $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?php if($da_header['notify_1'] == $value['id']) { echo "selected"; }?> ><?= $value['party'] ?></option>
                            <?php }
                              } 
                          ?>
                       </select>
                       
                        <?php $party =  getName( $da_header['notify_1'] ) ?>
                         <div id="party-4" style="display:block; border: 1px solid black;border-style: dashed; padding: 10px;background: yellow;">
                           <span id="address1-4"><?= $party['address1']?></span><br>
                           <span id="address2-4"><?= $party['address2']?></span><br>
                           <span id="address3-4"><?= $party['address3']?></span><br>
                           <span id="fax-tel-4"><?= $party['fax'].' '.$party['phone']?></span>

                        </div>
                     </div>

                </div>

                <hr>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Instructions:</label>
                       <textarea placeholder="Enter Instructions" class="form-control" name="instructions" rows="4" cols="4"><?= set_value('instructions', $da_header['instructions']) ?></textarea>
                      
                     </div>

                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Despatch Instruction:</label>
                        <textarea placeholder="Enter Despatch Instruction" class="form-control" name="despatch_instructions" rows="4" cols="4" ><?= set_value('despatch_instructions', $da_header['despatching_instructions']) ?></textarea>
                       
                     </div>

                </div>

                <hr>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Bank Details:</label>
                       <input type="text" name="bank_details" id="bank_details" class="form-control" placeholder="Enter Bank Details" value="<?= set_value('bank_details', $da_header['bank_details']) ?>">
                       <?//= form_error('bank_details') ?>
                     </div>

                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Specification (if any):</label>
                        <textarea placeholder="Enter Specification (if any)" class="form-control" name="specification" rows="4" cols="4"><?= set_value('specification', $da_header['specifications']) ?></textarea>
                       <?= form_error('specification') ?>
                     </div>

                </div>

                <hr>

                <div class="row">
                 
                    <div class="col-md-6 form-group">
                       <label>Special Instructions:</label>
                       <textarea placeholder="Enter Special Instructions" class="form-control" name="special_instructions" rows="4" cols="4"><?= set_value('special_instructions', $da_header['special_instructions']) ?></textarea>
                       
                     </div>

                     <div class="col-md-6 form-group">
                       <label>Shipping Marks:</label>
                       <textarea placeholder="Enter Shipping Marks" class="form-control" name="shipping_marks" rows="4" cols="4"><?= set_value('shipping_marks', $da_header['shipping_marks']) ?></textarea>
                       
                     </div>

                </div>
                <hr>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Declaration:</label>
                       <select class="form-control" id="declaration" name="declaration">
                         <option value="">Select one</option>
                         <?php if(!empty($declaration)) {
                                  foreach ($declaration as $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?php if($da_header['declaration'] == $value['id']) { echo "selected"; }?> ><?= $value['declaration'] ?></option>
                            <?php }
                              } 
                          ?>
                       </select>
                       <?//= form_error('declaration') ?>
                     </div>

                </div>

             
          </div>
       </div>
   

     <div class="col-md-4 right-block">
       
        <div class="card-block">
             
             <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Country:</label>
                  <select name="country" id="country" class="form-control" required>
                     <option value="">Select Country</option>
                    <?php if(!empty($country)) {
                           foreach($country as $value) { ?>
                             <option value="<?= $value['id'] ?>" <?php if($da_header['country'] == $value['id']) { echo "selected"; }?> ><?= $value['country']?></option>
                           <?php } 
                          } ?>
                  </select>
                  <?= form_error('country') ?>
                </div>

             </div>

              <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Terms of delivery:</label>
                  <select name="delivery_terms" class="form-control" required>
                    <option value="">Select Terms of delivery</option>
                    <?php if(!empty($delivery_term)) {
                      foreach($delivery_term as $value) { ?>
                          <option value="<?= $value['id'] ?>" <?php if($da_header['term_of_delivery'] == $value['id']) { echo "selected"; }?> ><?= $value['deliveryterm'] ?></option>
                        <?php 
                      }
                    } ?>
                  </select>
                  <?= form_error('delivery_terms') ?>
                </div>

             </div>


              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Payment Terms:</label>
                  <select name="payment_terms" id="payment_terms" class="form-control" required>
                     <option value="">Select Payment Terms</option>
                    <?php if(!empty($payment_terms)) {
                           foreach($payment_terms as $value) { ?>
                             <option value="<?= $value['id']?>" <?php if($da_header['payment_terms'] == $value['id']) { echo "selected"; }?> ><?= $value['paymentterms']?></option>
                    <?php } 
                       }
                    ?>
                  </select>
                  <?= form_error('payment_terms') ?>
                </div>

             </div>
             <hr>
              <div class="row">
                 <div class="col-md-12 form-group">
                    <label>Approved Preshipment Sample:</label>
                 </div>
              </div>

              <div class="row">
               
                <div class="col-md-6 form-group">
                  <label>Required</label>
                  <input class="form-control" id="required" type="checkbox" name="approve_preshipment" <?php if($da_header['pre_shipment_sample'] == '1') { echo "checked"; } ?> >

                </div>
                <div class="col-md-6 form-group">
                  <label>Quantity:</label>
                  <input class="form-control" type="text" id="quantity_1" name="quantity_1" value="<?= set_value('quantity_1', isset($da_header['sample_quantity']) ? $da_header['sample_quantity']: '') ?>">
                   <?= form_error('quantity_1')?>
                </div>

             </div>
             <hr>

              <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Month of Sale:</label>
                  <input type="text" name="month_of_sale" id="month_of_sale" class="form-control" placeholder="Enter Month of Sale" value="<?= set_value('month_of_sale', $da_header['month_of_sale']) ?>" required>
                  <?= form_error('month_of_sale') ?>
                </div>

             </div>

              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Mode of Shipment:</label>
                  <select name="shipment_mode" id="shipment_mode" class="form-control" required>
                     <option value="">Select Shipment Mode</option>
                    <?php if(!empty($shipment_mode)) {
                      foreach($shipment_mode as $value) { ?>
                         
                          <option value="<?= $value['id'] ?>" <?php if($da_header['shipping_mode'] == $value['id']) { echo "selected"; }?> ><?= $value['shippingmode'] ?></option>
                     
                      <?php } 
                        }
                      ?>
                  </select>
                  <?= form_error('shipment_mode') ?>
                </div>

             </div>

              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Despatch To:</label>
                  <select name="despatch_to" id="despatch_to" class="form-control">
                    <option value="">Select Despatch To</option>
                  <?php if(!empty($despatch_to) ) {
                    foreach ($despatch_to as $value) { ?>
                      <option value="<?= $value['id'] ?>" <?php if($da_header['despatch_to'] == $value['id']) { echo "selected"; }?> ><?= $value['despatchto'] ?></option>
                     <?php
                      }
                    } ?>
                  </select>
                  <?//= form_error('despatch_to') ?>
                </div>

             </div>

             <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Transport Mode to CHA:</label>
                  <select name="transport_mode_to_cha" id="transport_mode_to_cha" class="form-control" required>
                    <option value="">Select Transport Mode to CHA</option>
                  <?php if(!empty($transport_mode_to_cha) ) {
                    foreach ($transport_mode_to_cha as $value) { ?>
                      <option value="<?= $value['id'] ?>" <?php if($da_header['transport_mode_to_cha'] == $value['id']) { echo "selected"; }?> ><?= $value['transportmodetocha'] ?></option>
                     <?php
                      }
                    } ?>
                  </select>
                  <?= form_error('transport_mode_to_cha') ?>
                </div>

             </div>

             <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Agent:</label>
                  <select name="agent" id="agent" class="form-control" >
                    <option value="">Select Agent</option>
                  <?php if(!empty($agent) ) {
                    foreach ($agent as $value) { ?>
                      <option value="<?= $value['id'] ?>" <?php if($da_header['agent'] == $value['id']) { echo "selected"; }?> ><?= $value['agent'] ?></option>
                     <?php
                      }
                    } ?>
                  </select>
                
                </div>

             </div>

           <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Ordered By:</label>
                  <select name="ordered_by" id="ordered_by" class="form-control">
                     <option value="">Select option</option>
                     <?php if(!empty($users)) {
                      foreach($users as $value) { ?>
                         <option value="<?= $value['id'] ?>" <?php if($da_header['ordered_by'] == $value['id']) { echo "selected"; }?> > <?= $value['username'] ?></option>
                      <?php }
                     }
                      ?>
                  </select>
                  <?//= form_error('ordered_by') ?>
                </div>

           </div>

          <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Label:</label>
                  <select name="label" id="label" class="form-control" required>
                    <option value="">Select Label</option>
                    <?php if(!empty($label)) {
                      foreach($label as $value) { ?>
                         <option value="<?= $value['id'] ?>" <?php if($da_header['label'] == $value['id']) { echo "selected"; }?> ><?= $value['label'] ?></option>
                  <?php  }
                    } ?>
                  </select>
                  <?= form_error('label') ?>
                </div>

           </div>

           <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>DA Prepared By:</label>
                  <input type="text" name="prepared_by1" id="prepared_by" class="form-control" placeholder="DA Prepared By" value="<?= set_value('prepared_by', getUserName($da_header['prepared_by']) ) ?>" readonly required>
                  <?= form_error('prepared_by') ?>
                </div>

                <input type="hidden" name="prepared_by" value="<?= $da_header['prepared_by'] ?>">

             </div>         
        </div>
     </div>
  </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table" style="color: green;"></i> <b>DA ITEM</b>
    </div>
   <div class="card-block">
       <div class="table-responsive">
        <table class="table table-bordered da-table" width="100%" id="myTable" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>HS Code</th>
                <th>Product Form</th>
                <th>Grade</th>
                <th>Packing Type</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>Freight</th>
                <th>Logistic</th>
                <th>FOB Rate</th>
                <th>Qty Discount</th>
                <th>Comm %</th>
                <th>Comm Amt.</th>
                <th>Net Price</th>
                <th>Actions</th>
            </tr>
        </thead>
           <tbody id="row">
            <span id="length" style="display: none;"><?= count($da_items) ?></span>
            <span id="last_count" style="display: none;"></span>

            <?php $start = !empty($da_items) ? count($da_items) : 0; ?>
            <?php if(!empty($da_items)) {

                  foreach($da_items as $key => $value) {
                    $a = array();
                    $array = array_push($a, $value['product']); 
                ?>
              <tr>
                 <td>
                   <select style="width:10pc !important;" class="form-control" name="product[]" onchange="getval(this, <?= $key ?>);" >
                    <option value="">Select Product</option>
                    <?php if(!empty($product)) { 
                          foreach ($product as  $innerValue) {
                           
                    ?>
                    <option value="<?= $innerValue['id']?>" <?php if($innerValue['id'] == $value['product']) { echo "selected"; } ?> ><?= $innerValue['product']?> </option>
                  <?php } } ?>
                   </select>
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="hs_code[]"  id="hscode-<?= $key ?>" class="form-control hscode" value="<?= $value['hscode'] ?>" readonly >
                 </td>
                 <td>
                    <select style="width:10pc !important;"  name="product_form[]" class="form-control" >
          
                        <?php  if(!empty($product_form)) {
                          foreach($product_form as $innerValue1) { ?>
                            <option value="<?= $innerValue1['id'] ?>" <?php if($value['product_form'] ==$innerValue1['id'] ) { echo "selected"; }?> ><?=  $innerValue1['productform'] ?></option>
                            <?php
                          }
                        }
                        ?>
                    </select>
                 </td>
                 <td>
                    <select style="width:10pc !important;"  name="product_grade[]" class="form-control" >
                      
                        <?php  if(!empty($product_grade)) {
                          foreach($product_grade as $innerValue2) { ?>
                            <option value="<?= $innerValue2['id'] ?>" <?php if($value['grade'] ==$innerValue2['id'] ) { echo "selected"; }?>><?=  $innerValue2['productgrade'] ?></option>
                            <?php
                          }
                        }
                        ?>
                    </select>
                 </td>
                 <td>
                   <select style="width:10pc !important;"  name="packing_type[]" class="form-control" >
                       <?php  if(!empty($packing_type)) {
                          foreach($packing_type as $innerValue3) { ?>
                            <option value="<?= $innerValue3['id'] ?>" <?php if($value['packing_type'] ==$innerValue3['kindofpackages'] ) { echo "selected"; }?>><?=  $innerValue3['kindofpackages'] ?></option>
                            <?php
                          }
                        }
                        ?>
                   
                   </select>
                 </td>
                 <td>
                     <input style="width:10pc !important;"  type="text" name="qty[]" id="qty-<?= $key ?>" onchange="calculation(<?= $key ?>)" class="form-control" placeholder="Enter Qty" value="<?= $value['quantity']?>" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="rate[]"  id="rate-<?= $key ?>" onchange="calculation(<?= $key ?>)" class="form-control" placeholder="Rate" value="<?= $value['rate']?>" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" class="form-control" id="amount-<?= $key ?>" name="amount[]"  class="form-control"  value="<?= $value['amount']?>" readonly >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="freight[]" id="freight-<?= $key ?>" onchange="calculation(<?= $key ?>)" class="form-control" placeholder="Enter Freight" value="<?= $value['freight']?>" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="logistics[]" id="logistics-<?= $key ?>" onchange="calculation(<?= $key ?>)" class="form-control" placeholder="Enter Logistic" value="<?= $value['logistic']?>" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="fob_rate[]"  id="fobrate-0" class="form-control"  value="<?= $value['fob_rate']?>" readonly required>
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="qty_discount[]" class="form-control" onchange="calculation(<?= $key ?>)" id="qty_discount-<?= $key ?>" placeholder="Enter Qty Discount" value="<?= $value['quantity_discount']?>" >
                 </td>
                 <td>
                    <input style="width:10pc !important;"  type="text" name="comm_per[]"  id="comm_per-<?= $key ?>"  class="form-control" onchange="calculation(<?= $key ?>)" placeholder="Enter Comm %" value="<?= $value['commission_per']?>" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="comm_amount[]" id="comm_amount-<?= $key ?>"  class="form-control" value="<?= $value['commission_amount']?>"  onchange="calculation(<?= $key ?>)">
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="net_price[]"  id="net_price-<?= $key ?>"  class="form-control"  value="<?= $value['net_price']?>" readonly >
                 </td>
                 <td>
                   <input type="button" value="Delete" class="btn btn-danger" />
                 </td>
              </tr>  

              <?php } } ?>
              <tr >
                 <td>
                   <select style="width:10pc !important;" class="form-control product" name="product[]" onchange="getval(this, <?= $start ?>);" >
                   </select>
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="hs_code[]"  id="hscode-<?= $start ?>" class="form-control hscode" value="" readonly >
                 </td>
                 <td>
                    <select style="width:10pc !important;"  name="product_form[]" class="form-control" required>
          
                        <?php  if(!empty($product_form)) {
                          foreach($product_form as $value) { ?>
                            <option value="<?= $value['id'] ?>"><?=  $value['productform'] ?></option>
                            <?php
                          }
                        }
                        ?>
                    </select>
                 </td>
                 <td>
                    <select style="width:10pc !important;"  name="product_grade[]" class="form-control" >
                      
                        <?php  if(!empty($product_grade)) {
                          foreach($product_grade as $value) { ?>
                            <option value="<?= $value['id'] ?>"><?=  $value['productgrade'] ?></option>
                            <?php
                          }
                        }
                        ?>
                    </select>
                 </td>
                 <td>
                   <select style="width:10pc !important;"  name="packing_type[]" class="form-control packing_type" >
                   
                   </select>
                 </td>
                 <td>
                     <input style="width:10pc !important;"  type="text" name="qty[]" id="qty-<?= $start ?>" onchange="calculation(<?= $start ?>)" class="form-control" placeholder="Enter Qty" value="" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="rate[]"  id="rate-<?= $start ?>" onchange="calculation(<?= $start ?>)" class="form-control" placeholder="Rate" value="" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" class="form-control" id="amount-<?= $start ?>" name="amount[]"  class="form-control"  value="" readonly >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="freight[]" id="freight-<?= $start ?>" onchange="calculation(<?= $start ?>)" class="form-control" placeholder="Enter Freight" value="" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="logistics[]" id="logistics-<?= $start ?>" onchange="calculation(<?= $start ?>)" class="form-control" placeholder="Enter Logistic" value="" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="fob_rate[]"  id="fobrate-<?= $start ?>" class="form-control"  value="" readonly >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="qty_discount[]" class="form-control" onchange="calculation(<?= $start ?>)" id="qty_discount-<?= $start ?>" placeholder="Enter Qty Discount" value="" >
                 </td>
                 <td>
                    <input style="width:10pc !important;"  type="text" name="comm_per[]"  id="comm_per-<?= $start ?>"  class="form-control" onchange="calculation(<?= $start ?>)" placeholder="Enter Comm %" value="" >
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="comm_amount[]" id="comm_amount-<?= $start ?>"  class="form-control"  value=""  onchange="calculation(<?= $start ?>)">
                 </td>
                 <td>
                   <input style="width:10pc !important;"  type="text" name="net_price[]"  id="net_price-<?= $start ?>"  class="form-control"  value="" readonly >
                 </td>
                 <td>
                 </td>
              </tr>                
           </tbody>
          
        </table>
        <button type="button"  id="add_more" class="btn btn-success"  title="Please select da type above to proceed." ><i class="fa fa-plus"></i>&nbsp;Add Row</button>
    </div>

  </div>
</div>


<div class="card mb-3">
    <div class="col-md-12">
        <div class="card-block">
   
          <div class="row">
              <div class="col-md-4 form-group">
                  <label>Currency:</label>
                  <select id="currency" name="currency" class="form-control" required>
                  <option value="">Select Currency</option>
                  <?php if(!empty($currency)) {
                    foreach ($currency as $key => $value) { ?>
                      <option value="<?= $value['id'] ?>" <?php if($da_header['currency'] == $value['id']) { echo "selected"; }?> ><?= $value['currency'] ?></option>
                     <?php
                    }
                  }
                  ?>
                  </select>
                  <?= form_error('currency'); ?>
              </div>

              <div class="col-md-4 form-group">
                  <label>Exchange Rate:</label>
                  <input type="text" name="exchange_rate" id="exchange_rate" class="form-control" required  value ="<?= set_value('exchange_rate', $da_header['exchange_rate'])?>">
                   <?= form_error('exchange_rate'); ?>
              </div>

                <div class="col-md-4 form-group">
                  <label>GST Rate:</label>
                  <input type="text" name="gst_rate" id="gst_rate" class="form-control" value ="<?= set_value('gst_rate', $da_header['gst_per'])?>" onchange ="gstCalculation()">
                  <?//= form_error('gst_rate'); ?>
              </div>
              <input type="hidden" name="pathname" id="pathname" value="edit_da">

          </div>

          <div class="row">
            
              <div class="col-md-4 form-group">
                  <label>GST Amount:</label>
                  <input type="text" name="gst_amount" id="gst_amount" class="form-control" value ="<?= set_value('gst_amount', $da_header['gst_amt'])?>"/>
                  <?//= form_error('gst_amount'); ?>
              </div>

              <div class="col-md-4 form-group">
                  <label>Commission  Amount For Capsule:<small class="text-success">( Total commission )</small></label>
                  <input type="text" name="comm_amount_for_capsule" id="comm_amount_for_capsule" class="form-control" value ="<?= set_value('comm_amount_for_capsule', $da_header['total_commission'])?>"/>
                   <?//= form_error('comm_amount_for_capsule'); ?>
              </div>

          </div>
          
          <div class="row">
              <div class="col-md-6 form-group">
                  <label>Documents Required :-</label>
              </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
          
                  <?php if(!empty($documents_required)) {
                    foreach ($documents_required as $key => $value) {
                        
                        $checked = checked($da_header['id'], $value['documentsrequired']);
                        if(!empty($checked)) {
                          $check = 'checked';
                        } else {
                          $check = '';
                        }

                      ?>
                      <input type="checkbox" id="checkbox-<?= $key ?>" name="document[]" value="<?= $value['documentsrequired'] ?>" <?= $check ?> >
                         <label for="ooa"> <?= $value['documentsrequired'] ?> </label><br>
                    <?php } } ?>
                    <?= form_error('document[]'); ?>

              </div>
          </div>
        </div>
       </div>
      </div>
     <div class="card mb-3">
        <div class="col-md-12">
            <div class="card-block">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
                  <a href="<?= base_url().'logistics'?>" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancel</a>

            </div>
        </div>
      </div>
   </div>
</div>

</form>







