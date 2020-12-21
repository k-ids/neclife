<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">PPIC</li>
   <li class="breadcrumb-item">DA Assign Production Block
</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Assign Production Block
</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all DA to assign production block.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().$this->router->fetch_class()?>">
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
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th style="width:100px !important; min-width: 100px !important;">DA Type</th>
                  <th style="width:100px !important; min-width: 100px !important;">DA Date</th>
                  <th>DA No.</th>
                  <th>Buyer</th>
                  <th>Product</th>
                  <th style="width:100px !important; min-width: 100px !important;">Production Block</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th style="width:100px !important; min-width: 100px !important;">DA Type</th>
                  <th style="width:100px !important; min-width: 100px !important;">DA Date</th>
                  <th>DA No.</th>
                  <th>Buyer</th>
                  <th>Product</th>
                  <th style="width:100px !important; min-width: 100px !important;">Production Block</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_entry)) {
                      $counter = 0;
                      foreach ($da_entry as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["datype_name"] ?></td>
                  <td><?= nice_date($value["da_date"], 'Y-M-d' )?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value['department_name'] ?></td>
                  <td>
                      <a class="btn btn-info" href="javascript:void(0);" id="myModal-production-<?= $value['id'] ?>" data-dept="<?= $value['department_name'] ?>" data-dano="<?= $value['da_no'] ?>" data-type="<?= $value['datype_name'] ?>" data-id="<?= $value['id'] ?>" data-da="<?= $value['da_type'] ?>"><i data-toggle="tooltip" data-placement="top" title="DA information" class="fa fa-recycle" aria-hidden="true"></i>&nbsp;Select</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>

<div id="myModal-1" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="width:100%">Update Production Block</h4>
      </div>
      <div class="modal-body">
       <ul>
        <li id="first">DA No: <b class="text-info"></b></li>
        <li id="second">DA Type: <b class="text-info"></b></li>
        <li id="third">Production Block: <b class="text-info"></b></li>
       </ul>

       <form>
        <div class="form-group">   
            <label for="email">Production Block:</label>
            <select class="form-control" name="department" id="department" required>
               <option value="">Select one</option>
            </select>  
         </div>
       
      </div>
      <div class="modal-footer">
        <button type="button"  id="production-save" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>