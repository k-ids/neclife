<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">DA Check</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Check</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all DA ready to check and send for the approval.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().'logistics/da_check'?>">

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
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Created At</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Created At</th>
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
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= nice_date($value['created_at'], 'Y-M-d') ?></td>
                  <td>
                      <?php if($value['cancelled_by'] == '') { ?>
                      <a href="<?= base_url().'logistics/da_check_form/'.$value['id'] ?>" class="btn btn-info"><i class="fa fa-recycle"></i>&nbsp;Select</a>
                       <?php } else { ?>
                         <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal-<?= $value['id']?>"><i data-toggle="tooltip" data-placement="top" title="DA information" class="fa fa-times text-danger" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                         <div id="myModal-<?= $value['id']?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                
                                <h4 class="modal-title" style="width:100%">DA Information</h4>

                              </div>
                              <div class="modal-body">
                                <ul>
                                  <li>The DA No. <b><?= $value['da_no'] ?></b> has been Cancelled.</li>
                                  <li>Cancelled By: <b><?= $value['cancelled_by']?></b> </li>
                                  <li>Cancellation Date: <b><?= nice_date($value['cancel_date'], 'Y-M-d' )?></b></li>
                                  <li>Remarks: <?= $value['cancel_remarks']?></li>
                                  <li class="text-info">You can only view the DA. No Further changes possible now.</li>
                                </ul>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>

                          </div>
                        </div>
                       <?php   } ?>
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>