<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Manage ECGC Options</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>ECGC Form</b>
   </div>
    <div class="card-block">
      <?php $id = !empty($findOne) ? '/'.$findOne['id'] : ''?>
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().$id ?>" method="POST">

      <div class="row">

        <div class="col-md-6 form-group">
          <label>ECGC:</label>
          <input type="text" name="ecgc" id="ecgc" class="form-control" placeholder="Enter ecgc option" value="<?= set_value('ecgc', !empty($findOne['ecgc']) ? $findOne['ecgc']: '' ) ?>" >
           <?= form_error('ecgc') ?>
        </div>

      </div>



      <div class="row">
        <div class="col-md-5">
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;<?= !empty($findOne) ? 'Update' : 'Submit' ?></button>
          <?php if(!empty($findOne)) { 
             echo anchor($this->router->fetch_class().'/'.$this->router->fetch_method(), '<i class="fa fa-refresh"></i>&nbsp;Refresh', 'class="btn btn-warning"');
           } ?>
        </div>
      </div>
  
    </form>

   </div>
</div>

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>ECGC options listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>ECGC</th>
                  <th>Action</th>
                
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>ECGC</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($ecgc)) {
                      $counter = 0;
                      foreach ($ecgc as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["ecgc"] ?></td>
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Edit EPGC License" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    
                  </td> 
               
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>