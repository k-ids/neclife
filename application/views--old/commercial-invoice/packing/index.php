<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Packing list Invoice</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Packing List Invoice</b>
      (<small> Listing of all for DA for Packing list Invoice generation..</small>)
   </div>
</div>

<?php if($this->session->flashdata('restriction')) { ?>
         <div class="alert alert-danger alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Restriction!</strong> The Commercail Invoice has been generated for this DA "<?= $this->session->flashdata('restriction') ?>" already. If you want to make the changes then regenerate the Commercail Invoice again or directly add the changes to Commercail Invoice to relevant DA.
            </div>
<?php } ?>

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

    <?php if($this->session->flashdata('file_error')) { ?>
      <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Sorry!</strong>&nbsp;<?= $this->session->flashdata('file_error') ?>
      </div>
    <?php } ?>


      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA Financial year</th>
                  <th>DA No.</th>
                  <th>DA Type</th>
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
                  <th>Action </th>
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
                  <td><?= $value["financial_year"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= $value['datype_name'] . $value['invoice_type']?></td>
                  <td>
                    <?php if(empty($value['packing_invoice_id'])) {
                        $url = base_url().$this->router->fetch_class().'/generate_packing_invoice/'.$value['id'] ;
                      } else {
                          $url = base_url().$this->router->fetch_class().'/update_packinglist_invoice/'.$value['packing_invoice_id'] ;
                      }
                     ?>
                      <a href="<?= $url ?>" data-toggle="tooltip" data-placement="top" title="<?= !empty($value['packing_invoice_id']) ? 'Edit Packing list Invoice': 'Generate Packing list Invoice' ?>"><i class="fa fa-files-o text-success"></i>&nbsp;</a>
                      &nbsp;&nbsp;&nbsp;
                     <?php  if(!empty($value['packing_invoice_id'])) {?>
                      
                      <a href="javascript:void(0);"  data-toggle="modal" data-target="#invoice-download-<?= $value['packing_invoice_id'] ?>" data-toggle="tooltip" data-placement="top" title="Download Invoice"> <i class="fa fa-download text-warning"></i> &nbsp;</a>&nbsp;&nbsp;&nbsp;
                        
                          <div class="modal fade" id="invoice-download-<?= $value['packing_invoice_id'] ?>" role="dialog" data-backdrop="static" data-keyboard="false" style="top:6pc;">
                            <div class="modal-dialog" >
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Download Packing List Invoice <?= $value["da_no"].' ('.$value['datype_name'] .')'?></h5>
                              
                                </div>
                                <div class="modal-body" style="height: 150px;">
                                  <div class="row">
                                      <div class="col-md-6" style="padding-left: 28px; padding-top: 30px;">
                                         <a target="_blank" class="btn btn-warning" href="<?= base_url().$this->router->fetch_class().'/download_packing_invoice/customs/'.$value['packing_invoice_id'] ?>"><i class="fa fa-file-pdf-o"></i>&nbsp;CUSTOMS INVOICE</a>
                                      </div>

                                      <div class="col-md-6" style="padding-left: 20px; padding-top: 30px;">
                                        <a target="_blank" class="btn btn-success" href="<?= base_url().$this->router->fetch_class().'/download_packing_invoice/customer/'.$value['packing_invoice_id'] ?>"><i class="fa fa-file-pdf-o"></i>&nbsp;CUSTOMER INVOICE</a>
                                      </div>
                                  </div>
                                </div>

                                  <div class="modal-footer">
                
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                                
                              </div>
                            </div>
                          </div>

                          <a href="javascript:void(0)" id="regenerate-invoice-<?= $value['packing_invoice_id'] ?>" data-toggle="tooltip" data-placement="top" title="Regenerate Invoice again" data-url="<?= base_url().'commercial_invoice/delete_packing_invoice/'.$value['packing_invoice_id'] ?>">
                          <i class="fa fa-registered text-danger"></i>&nbsp;
                        </a>
                      <?php } ?>
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>