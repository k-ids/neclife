<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">GSK Packing List - View</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>GSK Packing List - View</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all GSK Packing List.
</div>



<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Financial Year</th>
                  <th>Product</th>
                  <th>DA Qauntity</th>
                  <th>Packing List Date</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Financial Year</th>
                  <th>Product</th>
                  <th>DA Qauntity</th>
                  <th>Packing List Date</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($packing_list)) {
                      $counter = 0;
                      foreach ($packing_list as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["party_name"] ?></td>
                  <td><?= $value["da_name"] ?></td>
                  <td><?= $value["financial_year"] ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value["qauntity"] ?></td>
                  <td><?= nice_date($value['created_at'], 'Y-M-d') ?></td>
                  <td><a class="btn btn-primary" href="<?= base_url(). $this->router->fetch_class(). '/gsk_packing_list_view/'.$value['id'] ?>"><i class="fa fa-check"></i>&nbsp;Select</a></td>
              
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>