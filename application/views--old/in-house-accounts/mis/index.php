<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">logistics</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'logistics/da_register' ?>">DA Register</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <b>DA Register</b>
   </div>
    <div class="card-block">
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>" method="POST">
      <div class="row">
        
         <div class="col-md-4 form-group">
          <label>DA type:</label>
          <select class="form-control" name="da_type" id="da_type" required>
             <option value="">Select DA type</option>
             <?php if(!empty($da_type)) {
               foreach($da_type as $value) { ?>
                  <option value="<?= $value['id'] ?>"><?= $value['datype'] ?></option> 
             <?php   }
             } ?>            
          </select>
          <?= form_error('da_type') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>From Date:</label>
          <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From date" value="<?= set_value('from_date') ?>" required>
          <?= form_error('from_date') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>Upto Date:</label>
          <input type="text" name="upto_date" id="upto_date" class="form-control" placeholder="Upto date" value="<?= set_value('upto_date') ?>" required>
          <?= form_error('upto_date') ?>
        </div>

      </div>

      <div class="row">
        <div class="col-md-5">
         <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
         <button type="button" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Refresh</button>
       </div>
      </div>
  
    </form>

   </div>
</div>

<?php if(!empty($result)) { ?>
<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Register Data</b>
   </div>
   <div class="card-block">
    
   
        <p>
          <b>Search Criteria:</b> 
          From:&nbsp;<?= $search['from'] ?> To:&nbsp;<?= $search['upto'] ?> 
        </p>
     

      <div class="table-responsive">
         <table class="table table-bordered" width="550%" id="dataTable1" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Financial Year</th>
                  <th>LC No</th>
                  <th>LC Date</th>
                  <th>DA No</th>
                  <th>DA Date</th>
                  <th>PO No</th>
                  <th>PO Date</th>
                  <th>Buyer</th>
                  <th>Consignee</th>
                  <th>Notify1</th>
                  <th>Notify2</th>
                  <th>Country</th>
                  <th>Territory</th>
                  <th>Terms Of Delivery</th>
                  <th>Payemnts Terms</th>
                  <th>Month Of Sale</th>
                  <th>Mode Of Shipment</th>
                  <th>Agent</th>
                  <th>Ordered By</th>
                  <th>Currency</th>
                  <th>Exchange Rate</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Product Grade</th>
                  <th>Packing Type</th>
                  <th>Quantity</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Freight</th>
                  <th>Logistic</th>
                  <th>FOB Rate</th>
                  <th>Quantity Discount</th>
                  <th>Comm %</th>
                  <th>Comm Amount</th>
                  <th>Net Price</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Financial Year</th>
                  <th>LC No</th>
                  <th>LC Date</th>
                  <th>DA No</th>
                  <th>DA Date</th>
                  <th>PO No</th>
                  <th>PO Date</th>
                  <th>Buyer</th>
                  <th>Consignee</th>
                  <th>Notify1</th>
                  <th>Notify2</th>
                  <th>Country</th>
                  <th>Territory</th>
                  <th>Terms Of Delivery</th>
                  <th>Payemnts Terms</th>
                  <th>Month Of Sale</th>
                  <th>Mode Of Shipment</th>
                  <th>Agent</th>
                  <th>Ordered By</th>
                  <th>Currency</th>
                  <th>Exchange Rate</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Product Grade</th>
                  <th>Packing Type</th>
                  <th>Quantity</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Freight</th>
                  <th>Logistic</th>
                  <th>FOB Rate</th>
                  <th>Quantity Discount</th>
                  <th>Comm %</th>
                  <th>Comm Amount</th>
                  <th>Net Price</th>
                  
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($result)) {
                      $counter = 0;
                      foreach ($result as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["financial_year"] ?></td>
                  <td><?= $value["lc_no"] ?></td>
                  <td><?= nice_date( $value["lc_date"], 'd-M-Y' ) ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= nice_date( $value["da_date"], 'd-M-Y' ) ?></td>
                  <td><?= $value["po_no"] ?></td>
                  <td><?= nice_date( $value["po_date"], 'd-M-Y' ) ?></td>
                  <td>
                     <?php 
                         $buyer =  getName( $value['buyer'] );
                         echo $buyer['party'];
                     ?>
                  </td>
                  <td>
                     <?php 
                         $consignee =  getName( $value['consignee'] );
                         echo  $consignee['party'];
                     ?>
                  </td>
                  <td>
                     <?php 
                         $notify =  getName( $value['notify'] );
                         echo $notify['party'];
                     ?>
                  </td>
                  <td>
                     <?php 
                         $notify_1 =  getName( $value['notify_1'] );
                         echo $notify_1['party'];
                     ?>
                  </td>
                  <td><?= $value["county_name"] ?></td>
                  <td><?= $value['territory'] ?></td>
                  <td><?= $value["deliveryterm"] ?></td>
                  <td><?= $value["paymentterms"] ?></td>
                  <td><?= $value["month_of_sale"] ?></td>
                  <td><?= $value["shippingmode"] ?></td>
                  <td><?= $value["agent_name"] ?></td>
                  <td><?= $value["order_by"] ?></td>
                  <td><?= $value["currency_name"] ?></td>
                  <td><?= $value["exchange_rate"] ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value["productform"] ?></td>
                  <td><?= $value["productgrade"] ?></td>
                  <td><?= $value["kindofpackages"] ?></td>
                  <td><?= $value["quantity"] ?></td>
                  <td><?= $value["rate"] ?></td>
                  <td><?= $value["amount"] ?></td>
                  <td><?= $value["freight"] ?></td>
                  <td><?= $value["logistic"] ?></td>
                  <td><?= $value["fob_rate"] ?></td>
                  <td><?= $value["quantity_discount"] ?></td>
                  <td><?= $value["commission_per"] ?></td>
                  <td><?= $value["commission_amount"] ?></td>
                  <td><?= $value["net_price"] ?></td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>

 <?php } ?>