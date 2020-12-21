<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Advance License Consumption
</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <b>Advance License Consumption</b>
   </div>
    <div class="card-block">
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>" method="POST">
      <div class="row">
        
         <div class="col-md-4 form-group">
          <label>Advance License No:</label>
          <select class="form-control" name="license_no" id="license_no" required>
             <option value="">Select advance license no.</option>
             <?php if(!empty($advance_license)) {
               foreach($advance_license as $value) { ?>
                  <option value="<?= $value['id'] ?>"><?= $value['lic_no'] ?></option> 
             <?php   }
             } ?>            
          </select>
          <?= form_error('license_no') ?>
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
          Advance License Number:&nbsp;<?= $search['license_no'] ?> 
        </p>
     

      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable-license" cellspacing="0"  style="table-layout: fixed;">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Advance License No</th>
                  <th  style="width:100px !important; min-width: 100px !important;">License Date</th>
                  <th>Quantity</th>
                  <th  style="width:100px !important; min-width: 100px !important;">Expiry Date</th>
                  <th>DA Type</th>
                  <th>DA No</th>
                  <th  style="width:100px !important; min-width: 100px !important;">DA Date</th>
                  <th>Buyer</th>
                  <th>Country</th>
                  <th>Product</th>
                  <th>Quantity</th>               
               </tr>
            </thead>
          
            <tbody>
               <?php 
                  if(!empty($result)) {
                      $counter = 0;
                      foreach ($result as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["lic_no"] ?></td>
                  <td><?= nice_date( $value["lic_date"], 'd-M-Y' ) ?></td>
                  <td><?= $value["qty"] ?></td>
                  <td><?= nice_date( $value["expiry_date"], 'd-M-Y' ) ?></td>
                  <td><?= $value["datype"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= nice_date( $value["da_date"], 'd-M-Y' )  ?></td>
                  <td><?= $value['buyer'] ?></td>
                  <td><?= $value["country"] ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value["quantity"] ?></td>
               </tr>
                 <?php }  ?>

               <?php } ?> 

            </tbody>
         </table>
      </div>


   </div>
</div>

 <?php } ?>