<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">DA Entry Attachements</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Entry Attachements</b>
   </div>
   <div class="card-block">
          <a class="btn btn-warning" href="<?= base_url().'logistics' ?>"><i class="fa fa-search"></i>&nbsp;Find</a>
   </div>

</div>


<div class="card mb-3">
   <div class="card-block">
    <?php if(isset($findOne['cancelled']) && $findOne['cancelled'] =='0' ) {?>
      <form method="POST" action="<?= base_url().'logistics/da_attachment/'.$findOne['id'] ?>" enctype="multipart/form-data">
          <div class="row">
              <div class="form-group col-md-8">
                <label>Choose File to upload:</label>&nbsp;<small class="text-danger">Allowed file types: jpg | jpeg | png | gif | csv | pdf | doc | docx | xlsx | word</small>
                <input type="file" name="attachement" id="attachement" class="form-control" required>
                 <?php if($this->session->userdata('validation-error')) { ?>
                     <span class="text-danger"><?= $this->session->userdata('validation-error') ?></span>
                 <?php  } ?>
              </div>
          </div>
         <input type="hidden" name="file" value="1">
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Add Attachment</button>

      </form>
    <?php } else {?>
          <ul>
            <li class="text-info">This DA: <b><?= $findOne['da_no'] ?></b> has been cancelled. No further changes possible. you can review the DA only.</li>
          </ul>
    <?php } ?>
    </div>

</div>

<div class="card mb-3">
   <div class="card-block">
    <div class="table-responsive">
       <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
              <thead>
                 <tr>
                    <th>S.No</th>
                    <th>Attachement</th>
                    <th>Action</th>
                 </tr>
              </thead>
              <tfoot>
                 <tr>
                    <th>S.No</th>
                    <th>Attachement</th>
                    <th>Action</th>
                 </tr>
              </tfoot>
              <tbody>
                <?php 
                  if(!empty($attachement)) {
                      $counter = 0;
                      foreach ($attachement as $value) { ?>
                  <tr>
                    <td><?= ++$counter ?></td>
                    <td><a data-toggle="tooltip" data-placement="top" title="Download the file to preview." href="<?= base_url().'resources/da-attachement/'.$value['attachement'] ?>" download=""><?= $value['attachement'] ?></a></td>
                    <td>
                      <?php if(isset($findOne['cancelled']) && $findOne['cancelled'] =='0' ) {?>
                      <a href="javascript:void(0)" id="delete-<?= $value["id"]?>" data-url="<?=base_url().'logistics/delete_attachement/'.$value["id"] ?>" title="DELETE USER">
                        <i class="fa fa-trash text-danger"></i>
                    </a>&nbsp;&nbsp;| <?php } ?>&nbsp;&nbsp;
                      <a data-toggle="tooltip" data-placement="top" title="Download the file to preview." href="<?= base_url().'resources/da-attachement/'.$value['attachement'] ?>" download=""><i class="fa fa-download text-success"></i></a></td>
                  </tr>

              <?php } } ?>
             </tbody>
           </table>
        </div>
   </div>
</div>