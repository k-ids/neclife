<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">DA Entry Listing</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Entry Listing</b>
   </div>
       <div class="card-block">
            <a href="<?= base_url().'logistics/da_entry'?>" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;New</a>
            <a href="<?= base_url().'logistics'?>" class="btn btn-warning"><i class="fa fa-search"></i>&nbsp;Find</a>
            
      </div>
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().'logistics'?>">

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
           
         <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;Search</button>
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
                        <a href="<?= base_url().'logistics/edit_da_entry/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Edit DA"><i class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
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
                                  <li>Cancelled By: <b><?= getUserName($value['cancelled_by']) ?></b> </li>
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
                     <a href="<?= base_url().'logistics/view_da/'.$value['id']?>" data-toggle="tooltip" data-placement="top" title="View DA"><i class="fa fa-eye text-success" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                     
                      <?php if($value['cancelled_by'] == '') { ?>
                       
                       <a href="<?= base_url().'logistics/da_attachment/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="DA attachment"><i class="fa fa-paperclip"></i> <sup class="text-danger">(<?= $value['daattachment_num'] ?>)</sup></a>
                      <?php } ?>
                 
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>