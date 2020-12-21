<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/gsk_packing_list' ?>">Manager QA</a></li>
   <li class="breadcrumb-item">GSK Packing List</li>
</ol>
<!-- Example Tables Card -->


<div class="alert alert-info">
  <strong>Info!</strong> GSK Packing List.
</div>

<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered packing-list-table" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Financial Year</th>
                  <th>Status</th>
                  <th>Dated</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Financial Year</th>
                  <th>Status</th>
                  <th>Dated</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($packing_list)) {
                      $counter = 0;
                      foreach ($packing_list as $value) { 

                            if(!empty($value['manager_qa'])) {
                               $status = 'Approved';
                               $class = 'text-success';
                            } else {
                               $status = '--N/A--';
                               $class = '';
                            }
                        ?>
                        <tr>
                           <td><?= ++$counter; ?></td>
                           <td><?= $value['party_name']?></td>
                           <td><?= $value['da_name']?></td>
                           <td><?= $value["financial_year"] ?></td>
                           <td class="<?= $class ?>"><?= $status ?></td>
                           <td><?= nice_date($value["created_at"], 'd-M-Y' )?></td>
                           <td>
                           <?php if(!empty($value['checked_by']) && !empty($value['approved_by'])) { ?>
                               <a class="btn btn-primary" href="<?= base_url().$this->router->fetch_class().'/gsk_packing_approval/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Click to provide approval to GSK packing list"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Select</a>
                           <?php } else {?>
                               <a style="text-decoration: none;" href="javascript:void(0)">GSK Not checked and approved yet from QA.</a>
                           <?php } ?>

                           </td>
                        </tr> 
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
