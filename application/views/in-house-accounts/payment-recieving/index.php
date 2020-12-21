<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">In House Account</li>
   <li class="breadcrumb-item">DA Payment Received
</li>

   </li>
</ol>
<!-- Example Tables Card -->


<div class="alert alert-info">
  <strong>Info!</strong> Listing of all DA for payment receiving.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>">

         <div class="form-group">
            <label>Buyer:</label>
            <select name="buyer" class="form-control" id="buyer">
               <option value="">Select Buyer to show listing</option>
               <?php if(!empty($buyers)) {
                  foreach($buyers as $buyer) { ?>
                     <option value="<?= $buyer['id']?>"><?= $buyer['party'] ?></option>
                  <?php } } ?>
            </select>
         </div>
           
         <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
         <a href="" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>

      </form>
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">
      <p><b>Note:</b></p>
      <p>1) Search the specific word "Paid" or "Outstanding" in the table and generate the relevent excel report. </p>
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Invoice No.</th>
                  <th>Total Amount</th>
                  <th>Paid Amount</th>
                  <th>Balance Amount</th>
                  <th>Air Billed Date</th>
                  <th>Due Date</th>
                  <th>Payment Status</th>
                  <th>Expiry Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Invoice No.</th>
                  <th>Total Amount</th>
                  <th>Paid Amount</th>
                  <th>Balance Amount</th>
                  <th>Air Billed Date</th>
                  <th>Due Date</th>
                  <th>Payment Status</th>
                  <th>Expiry Status</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_entry)) {
                      $counter = 0;
                      foreach ($da_entry as $value) { 
                       
                      $date1 = date_create(date('Y-m-d'));
                      $date2 = date_create($value['due_date']);
                      $diff = date_diff($date1,$date2);
                      $days = $diff->format("%R%a.");
                      
                      if($days <= 0 && !empty($value['air_billed_date'])) {
                          $_class = 'text-danger';
                          $expiry_status = 'Expired';
                      } else {
                          $_class = 'text-success';
                          $expiry_status = 'Open';
                      }

                        if($value['status'] == '1') {
                            $class = 'text-danger';
                            $p_status = 'Outstanding';
                        } elseif($value['status'] == '2') {
                             $class = 'text-success';
                             $p_status = 'Paid';
                             $_class = 'text-info';
                             $expiry_status = 'Closed';
                        } else {
                           $class = '';
                           $p_status = '';
                        }
                        
                    ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["party"] ?></td>
                  <td style="min-width: 170px;"><?= $value["da_name"] ?></td>
                  <td><?= $value["invoice_no"] ?></td>
                  <td style="min-width: 170px;"><?= $value['currency_name'].' '.$value["total_amount"] ?></td>
                  <td style="min-width: 170px;"><?= $value['currency_name'] ?>&nbsp;<?= !empty($value['total_paid_amount']) ? $value['total_paid_amount'] : '0.00' ?></td>
                  <td style="min-width: 170px;"><?= $value['currency_name'].' '.$value["balance"] ?></td>
                  <td style="min-width: 120px;"><?= !empty($value["air_bill_date"]) ? nice_date($value["air_bill_date"], 'd-M-Y') : ''?></td>
                  <td style="min-width: 120px;"><?= !empty($value["due_date"]) ? nice_date($value["due_date"], 'd-M-Y') : '' ?></td>

                  <td class="<?= $class ?>"><?= $p_status  ?></td>

                  <td class="<?= $_class ?>"><?= $expiry_status ?></td>
                  <td>
                      <a class="btn btn-info" href="<?= base_url(). $this->router->fetch_class(). '/history/'.$value['id'].'/'.$value['invoice_id']?>"><i data-toggle="tooltip" data-placement="top" title="DA information" class="fa fa-recycle" aria-hidden="true"></i>&nbsp;Select</a>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>