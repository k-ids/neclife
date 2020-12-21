<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Administrator</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator/department' ?>">Department</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
 
      <?= anchor('administrator/create_department', '<i class="fa fa-plus"></i> Add Department', 'class="btn btn-success"') ?>

   </div>


</div>

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Department Listing </b>
   </div>
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Department</th>
                  <th>DA Type</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                   <th>S.No</th>
                   <th>Department</th>
                   <th>DA Type</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($departments)) {
                      $counter = 0;
                      foreach ($departments as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["department"] ?></td>
                  <td><?= $value["datype"] ?></td>
                  <td>
                     <a href="<?= base_url().'administrator/edit_department/'.$value["id"] ?>" data-toggle="tooltip" data-placement="top" title="Edit department">
                        <i class="fa fa-pencil text-warning"></i>
                        </button>
                     </a>&nbsp;|&nbsp; 
                     <a href="javascript:void(0)" id="delete-<?= $value["id"]?>" data-url="<?=base_url().'administrator/delete_department/'.$value["id"] ?>"  data-toggle="tooltip" data-placement="top" title="Delete department">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>