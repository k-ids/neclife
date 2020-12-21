<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">Packing List - View</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Packing List - View</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all Packing List.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().'logistics/packing_list'?>">

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
      <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Type</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing Type</th>
                  <th>DA Quantity</th>
                  <th>Packing List Date</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Type</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing Type</th>
                  <th>DA Quantity</th>
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
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["daname"] ?></td>
                  <td><?= $value["datype_name"] ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value["productform"] ?></td>
                  <td><?= $value["productgrade"] ?></td>
                  <td><?= $value["kindofpackages"] ?></td>
                  <td><?= $value["qty"] ?></td>
                  <td><?= nice_date($value['packing_list_date'], 'Y-M-d') ?></td>
                  <td><a class="btn btn-primary" href="<?= base_url(). $this->router->fetch_class(). '/packing_list_view/'.$value['da_no'].'/'.$value['product_form'] ?>"><i class="fa fa-check"></i>&nbsp;Select</a></td>
              
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>