<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Production</li>
   <li class="breadcrumb-item">GSK Packing List</li>

   </li>
</ol>


<div class="alert alert-info">
  <strong>Info!</strong> Listing of all API DA GSK Packing List.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>">

         <div class="form-group">
            <label>Buyer:</label>
            <select name="buyer" class="form-control" id="buyer">
               <option value="">Select buyer to show listing</option>
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
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA Financial year</th>
                  <th>DA No.</th>
                  <th>DA Type</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA Financial year</th>
                  <th>DA No.</th>
                  <th>DA Type</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_entry)) {
                      $counter = 0;
                      foreach ($da_entry as $value) {
                           
                           if(!empty($value['gskDa'])) {

                              $class = 'text-success';
                              $status = 'Generated';

                            } else { 

                              $class = '';
                              $status = '';

                            }
                      ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["financial_year"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= $value['datype_name'] ?></td>
                  <td class="<?= $class ?>"><?= $status ?></td>
                  <td>
                      <a href="<?= base_url().$this->router->fetch_class().'/manage_gsk_packing/'.$value['id'] ?>" class="btn btn-info"><i class="fa fa-recycle"></i>&nbsp;Select</a>
                     
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>