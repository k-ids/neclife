<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item active">Corporate Account</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/da_account_approve'?>">DA Account Approve</a></li>
</ol>
<!-- Example Tables Card -->

<form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$da_header['id']?>" method="POST">
<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-dashcube" style="color: green;"></i>&nbsp;<b>DA Account Approve</b>
   </div>
      <div class="card-block">
        
            <a href="<?= base_url().$this->router->fetch_class().'/da_account_approve'?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Go Back"><i class="fa fa-search"></i>&nbsp;Find</a>

               <input type="hidden" name="check" value="true">
               <button type="Submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Click me to provide the approval to DA"><i class="fa fa-floppy-o"></i>&nbsp;Account Approval</button>
           
      </div>
</div>
<div class="card mb-3">
  
      <div class="card-block">
       <p><strong>Note:</strong></p>
         <ul>
          <li class="text-success"> This DA has been successfully prepared by <b><?= getUserName($findOne['prepared_by'])?></b>
            <br>
            DA Checked By: <b><?= getUserName($findOne['checked_by'])?></b>
            <br>
            DA Bussiness Manager Checked By: <b><?= getUserName($findOne['bussiness_manager_check_by'])?></b>
            <br>
            DA Approved By: <b><?= getUserName($findOne['approved_by'])?></b>
            <br>
            DA Outstanding Checked By:&nbsp;<b><?= getUserName($findOne['outstanding_check_by'])?></b>
           </li>
          <li class="text-info">Please review the DA provide the approval.</li>
          <li class="text-danger">If you find out any mistake or problem in DA. Please contact administartor regarding this.</li>
        </ul>
      </div>

</div>

   <div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table" style="color: green;"></i><b> OUTSTANDING ITEM</b>
    </div>
   <div class="card-block">
       <div class="table-responsive">
        <table class="table table-bordered da-table" width="100%" id="myTable" cellspacing="0">
        <thead>
            <tr>
                <th>Outstanding</th>
                <th>Ageing</th>
                <th>0-30 Days:</th>
                <th>31-60 Days</th>
                <th>61-95 Days</th>
                <th>96-120 Days</th>
                <th>121-180 Days</th>
                <th>181-365 Days</th>
                <th>>365 Days</th>
               
            </tr>
        </thead>
           <tbody id="row"> 
            <?php for($i = 0; $i <= 2; $i++) { ?>
              
              <tr>
                <td>
                   <input style="width:10pc" type="text" name="outstanding[]" class="form-control" placeholder="Enter Total Outstanding" value="<?= !empty($da_outstanding[$i]['out_standing']) ? $da_outstanding[$i]['out_standing'] : '' ?>" >
                </td>
                <td>
                  <input style="width:10pc" type="text" name="ageing[]"  class="form-control" placeholder="Enter Ageing" value="<?= !empty($da_outstanding[$i]['ageing']) ? $da_outstanding[$i]['ageing'] : '' ?>" >
                </td>
                <td>
                  <input style="width:10pc" type="text" name="0_30_days[]" class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['0_30_days']) ? $da_outstanding[$i]['0_30_days'] : '' ?>" >
                </td>
                <td>
                  <input style="width:10pc" type="text" name="31_60_days[]"  class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['31_60_days']) ? $da_outstanding[$i]['31_60_days'] : '' ?>" >
                </td>
                <td>
                   <input style="width:10pc" type="text" name="61_95_days[]" class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['61_95_days']) ? $da_outstanding[$i]['61_95_days'] : '' ?>">
                </td>
                <td>
                  <input style="width:10pc" type="text" name="96_120_days[]"  class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['96_120_days']) ? $da_outstanding[$i]['96_120_days'] : '' ?>">
                </td>
                <td>
                  <input style="width:10pc" type="text" name="121_180_days[]"  class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['121_180_days']) ? $da_outstanding[$i]['121_180_days'] : '' ?>">
                </td>
                <td>
                  <input style="width:10pc" type="text" name="181_365_days[]" id="181_365_days" class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['181_365_days']) ? $da_outstanding[$i]['181_365_days'] : '' ?>" >
                </td>
                <td>
                  <input style="width:10pc" type="text" name="more_than_365_days[]" class="form-control" placeholder="" value="<?= !empty($da_outstanding[$i]['GT365_days']) ? $da_outstanding[$i]['GT365_days'] : '' ?>">
                </td>
              </tr>  
             
            <?php } ?>              
                
           </tbody>
            <input type="hidden" name="financial_year" value="<?= $da_header['financial_year'] ?>">
        </table>
        
    </div>

  </div>
</div>


</form>

<div class="card mb-3">

  <div class="row">

    <div class="col-md-8">
         
          <div class="card-block">
               
               <div class="row">
                 
                  <div class=" col-md-6 form-group">
                  <label>Financial Year:</label>&nbsp; <?= $da_header['financial_year'] ?> 
                </div>

                  <div class="col-md-6 form-group">
                    <label>DA Type:</label>&nbsp; <?= $da_header['datype_name'] ?> 
                  </div>

                </div>

                  <div class="row">
                 
                    <div class="col-md-6 form-group">
                       <label>LC No:</label>&nbsp; <?= $da_header['lc_no'] ?> 
                     </div>

                     <div class="col-md-6 form-group">
                       <label>LC Date:</label>&nbsp; <?= nice_date( $da_header['lc_date'],'Y-M-d' ) ?> 
                     </div>

                </div>

                <div class="row">
                 
                     <div class="col-md-6 form-group">
                       <label>DA No:</label>&nbsp; <?= $da_header['da_no'] ?> 
                     </div>

                     <div class="col-md-6 form-group">
                       <label>DA Date:</label>&nbsp; <?= nice_date( $da_header['da_date'], 'Y-M-d' ) ?> 
                     </div>

                </div>

                <div class="row">
                 
                     <div class="col-md-6 form-group">
                       <label>PO No:</label>&nbsp; <?= $da_header['po_no'] ?> 
                     </div>

                     <div class="col-md-6 form-group">
                       <label>PO Date:</label>&nbsp; <?= nice_date( $da_header['po_date'] , 'Y-M-d' )?> 
                     </div>

                </div>
                <hr>
                <div class="row">
                 
                     <div class="col-md-12 form-group">
                       <?php $party =  getName( $da_header['buyer'] ) ?> 
                       <label>Buyer:</label>&nbsp;  <?= $party['party']?>
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
                      <?php $party =  getName( $da_header['consignee'] ) ?> 
                       <label>Consignee:</label>&nbsp;  <?= $party['party']?>
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
                      <?php $party =  getName( $da_header['notify'] ) ?> 
                       <label>Notify 1:</label>&nbsp; <?= $party['party'] ?>
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
                      <?php $party =  getName( $da_header['notify_1'] ) ?> 
                       <label>Notify 2:</label>&nbsp; <?= $party['party'] ?>
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
                       <label>Instructions:</label>&nbsp; <?= $da_header['instructions'] ?>
                     </div>

                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Despatch Instruction:</label>&nbsp; <?= $da_header['despatching_instructions'] ?>
                     </div>

                </div>

                <hr>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Bank Details:</label>&nbsp; <?= $da_header['bank_details'] ?>
                     </div>

                </div>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Specification (if any):</label>&nbsp; <?= $da_header['specifications'] ?>
                     </div>

                </div>

                <hr>

                <div class="row">
                 
                    <div class="col-md-6 form-group">
                       <label>Special Instructions:</label>&nbsp; <?= $da_header['special_instructions'] ?>
                     </div>

                     <div class="col-md-6 form-group">
                       <label>Shipping Marks:</label>&nbsp; <?= $da_header['shipping_marks'] ?>
                     </div>

                </div>
                <hr>

                <div class="row">
                     <div class="col-md-12 form-group">
                       <label>Declaration:</label>&nbsp; <?= $da_header['declaration1'] ?>
                     </div>

                </div>

             
          </div>
       </div>
   

     <div class="col-md-4 right-block">
       
        <div class="card-block">
             
             <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Country:</label>&nbsp; <?= $da_header['county_name'] ?>
                </div>

             </div>

              <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Terms of delivery:</label>&nbsp; <?= $da_header['deliveryterm'] ?>
                </div>

             </div>


              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Payment Terms:</label>&nbsp; <?= $da_header['paymentterms'] ?>
                 
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
                  <label>Required</label>&nbsp; <?= !empty($da_header['pre_shipment_sample'] =='1') ? 'YES' : 'NO'; ?>
                 

                </div>
                <div class="col-md-6 form-group">
                  <label>Quantity:</label>&nbsp; <?= !empty($da_header['sample_quantity']) ? $da_header['sample_quantity'] : '0'; ?>
                </div>

             </div>
             <hr>

              <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>Month of Sale:</label>&nbsp; <?= $da_header['month_of_sale'] ?>
                </div>

             </div>

              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Mode of Shipment:</label>&nbsp; <?= $da_header['shippingmode'] ?>
                </div>

             </div>

              <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Despatch To:</label>&nbsp; <?= $da_header['despatchto'] ?>
                </div>

             </div>

             <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Transport Mode to CHA:</label>&nbsp; <?= $da_header['transportmodetocha'] ?>
                </div>

             </div>

             <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Agent:</label>&nbsp; <?= $da_header['agent_name'] ?>
                </div>

             </div>

           <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Ordered By:</label>&nbsp; <?=  getUserName($da_header['ordered_by']) ?>
                
                </div>

           </div>

          <div class="row">
               
                 <div class="col-md-12 form-group">
                  <label>Label:</label>&nbsp; <?= $da_header['label_name'] ?>
                </div>

           </div>

           <div class="row">
               
                <div class="col-md-12 form-group">
                  <label>DA Prepared By:</label>&nbsp; <?= getUserName($da_header['prepared_by']) ?>
                </div>

             </div>         
        </div>
     </div>
  </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> <b>DA ITEM</b>
    </div>
   <div class="card-block">
       <div class="table-responsive">
        <table class="table table-bordered" width="250%" id="dataTable" cellspacing="0">
        <thead>
            <tr>
				         <th>S.No</th>
                <th>Product</th>
                <th>HS Code</th>
                <th>Product Form</th>
                <th>Grade</th>
                <th>Packing Type</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>Feright</th>
                <th>Logistic</th>
                <th>FOB Rate</th>
                <th>FOB Plant Rate</th>
                <th>Qty Discount</th>
                <th>Comm %</th>
                <th>Comm Amt.</th>
                <th>Net Price</th>
              
            </tr>

        </thead>
           <tbody id="row">
              <?php if(!empty($da_items)) {
                $counter = 0;
                foreach($da_items as $value) { ?>
                <tr>
                   <td><?= "#".++$counter ?></td>
                   <td><?= $value['product_name'] ?></td>
                   <td><?= $value['hscode'] ?></td>
                   <td><?= $value['productform'] ?></td>
                   <td><?= $value['productgrade'] ?></td>
                   <td><?= $value['kindofpackages'] ?></td>
                   <td><?= $value['quantity'] ?></td>
                   <td><?= $value['rate'] ?></td>
                   <td><?= $value['amount'] ?></td>
                   <td><?= $value['freight'] ?></td>
                   <td><?= $value['logistic'] ?></td>
                   <td><?= $value['fob_rate'] ?></td>
                   <td><?= $value['fob_rate_plant'] ?></td>
                   <td><?= $value['quantity_discount'] ?></td>
                   <td><?= $value['commission_per'] ?></td>
                   <td><?= $value['commission_amount'] ?></td>
                   <td><?= $value['net_price'] ?></td>
                </tr>  
                <?php  } }?> 
           </tbody>
          
        </table>
        
    </div>

  </div>
</div>


<div class="card mb-3" >
    <div class="col-md-12">
        <div class="card-block">
   
          <div class="row">
              <div class="col-md-4 form-group">
                  <label>Currency:</label>&nbsp; <?= $da_header['currency_name'] ?>
              </div>

              <div class="col-md-4 form-group">
                  <label>Exchange Rate:</label>&nbsp; <?= $da_header['exchange_rate'] ?>
              </div>

                <div class="col-md-4 form-group">
                  <label>GST Rate:</label>&nbsp; <?= $da_header['gst_per'] ?>
              </div>

          </div>

          <div class="row">
            
              <div class="col-md-4 form-group">
                  <label>GST Amount:</label>&nbsp; <?= $da_header['gst_amt'] ?>
              </div>

              <div class="col-md-8 form-group">
                  <label>Commission Amount For Capsule:</label>&nbsp; <?= $da_header['total_commission'] ?>
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
                      <input type="checkbox" id="checkbox-<?= $key ?>" name="document[]" value="<?= $value['documentsrequired'] ?>" <?= $check ?> disabled>
                         <label for="ooa"> <?= $value['documentsrequired'] ?> </label><br>
                    <?php } } ?>
                    <?= form_error('document[]'); ?>
                 
              </div>
          </div>
        </div>
       </div>
      </div>
   </div>
</div>









