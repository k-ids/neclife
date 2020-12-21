<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class() ?>">QA</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/packing_list_plant_check' ?>">Plant Packing List Check/Uncheck</a> </li>
   <li class="breadcrumb-item">Form</li>
   </li>
</ol>


<div class="card mb-3">
    <div class="card-block">
        <div style="float: right;">
            <a class="btn btn-success" href="<?= base_url(). $this->router->fetch_class(). '/generate_production_excel/'. $da_header['id'] .'/'.$da_items['id'] ?>"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Export Excel</a>
        </div>
    </div>
</div>

<div class="card mb-3">
  
      <div class="card-block">
       <p><strong>Note:</strong></p>
         <ul>
           <li class="text-success">This packing list is created by: <b><?= !empty($packing_list[0]['created_by']) ? $packing_list[0]['created_by'] :'NIL'; ?></b>
           </li>
           <li class="text-danger">If you find out any mistake or problem in packing list. Please contact administartor or plant production manager regarding this.</li>
        </ul>
      </div>

</div>
<div class="card mb-3">
   <div class="card-block">
       <form method="POST" action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)?>">
          <?php if(!empty($packing_list[0]['checked_by'])) {
                          $check = 'checked';
                        } else {
                          $check = '';
                        } ?>
         <div class="row">
              <div class="col-md-6 form-group">
                  <label>Check/Uncheck Plant List:</label>
                  <input type="checkbox" id="checkbox-1" name="check_uncheck" value="1" <?= $check ?> >
                  <input type="hidden" name="hidden" value="1" >
              </div>
          </div>
          
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
         <?= anchor($this->router->fetch_class().'/'.$this->router->fetch_method(), '<i class="fa fa-times"></i>&nbsp;Cancel', 'class="btn btn-warning"')?>
       </form>
    </div>
</div>
<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Items</b>
   </div>
   <div class="card-block">
      <div class="row">
         <div class="form-group col-md-6">
            <label>DA NO.: </label>
            <input type="text" class="form-control" name="da_no" value="<?= $da_header['da_no'] ?>" required readonly>
         </div>
         <input type="hidden" name="post_da_no" value="<?= $da_header['id']?>">
         <div class="form-group col-md-6">
            <label>DA Fin Year:</label>
            <input type="text" class="form-control" name="financial_year" value="<?= $da_header['financial_year']  ?>" required readonly>
         </div>
      </div>
      <div class="row">
         <div class="form-group col-md-6">
            <label>Party:</label>
            <input type="text" class="form-control" name="buyer_name" value="<?= $da_header['buyer_name']  ?>" required readonly>
         </div>
         <input type="hidden" name="post_buyer" value="<?= $da_header['buyer']?>">
         <div class="form-group col-md-6">
            <label>DA Type:</label>
            <input type="text" class="form-control" name="datype_name" value="<?= $da_header['datype_name'] ?>" required readonly>
         </div>
         <input type="hidden" name="post_da_type" value="<?= $da_header['da_type']?>">
         <input type="hidden" name="post_dept" value="<?= $da_header['department']?>">
      </div>
      <hr>
      <div class="row">
         <div class="form-group col-md-6">
            <label>Product:</label>
            <input type="text" class="form-control" name="product_name" value="<?= $da_items['product_name']  ?>" required readonly>
         </div>
         <input type="hidden" name="post_product" value="<?= $da_items['product']?>">
         <div class="form-group col-md-6">
            <label>Product From:</label>
            <input type="text" class="form-control" name="productform" value="<?= $da_items['productform'] ?>" required readonly>
         </div>
      </div>
      <div class="row">
         <div class="form-group col-md-6">
            <label>Grade:</label>
            <input type="text" class="form-control" name="productgrade" value="<?= $da_items['productgrade']  ?>" required readonly>
         </div>
         <div class="form-group col-md-6">
            <label>Packing Type:</label>
            <input type="text" class="form-control" name="kindofpackages" value="<?= $da_items['kindofpackages'] ?>" required readonly>
         </div>
      </div>
      <div class="row">
         <div class="form-group col-md-6">
            <label>DA Qty:</label>
            <input type="text" class="form-control" name="quantity" value="<?= $packing_list[0]['qty']  ?>" required readonly>
            <?= form_error('quantity') ?>
         </div>
         <div class="form-group col-md-6">
            <label>Total Qty in this List:</label>
            <input type="text" class="form-control" name="qty_in_list" value="<?= $packing_list[0]['total_qty_in_list']  ?>" required readonly>
         </div>
      </div>
      <div class="row">
         <div class="form-group col-md-6">
            <label>Total Qty Dispatched:</label>
            <input type="text" class="form-control" name="qauntity_dispatched" value="<?= $packing_list[0]['total_qty_despatch']  ?>" required readonly>
         </div>
         <div class="form-group col-md-6">
            <label>Packing List Date:</label>
            <input type="text" class="form-control" name="packing_list_date" value="<?= nice_date($packing_list[0]['packing_list_date'], 'd-M-Y') ?>" required readonly>
         </div>
         <div class="form-group col-md-6">
            <label>Packing List Time:</label>
            <input type="text" class="form-control" name="packing_list_time" id="packing_list_time" value="<?= $packing_list[0]['packing_list_time'] ?>" required readonly>
         </div>
         <div class="form-group col-md-6">
            <label>Created By:</label>
            <input type="text" class="form-control" name="production_remarks" id="production_remarks" value="<?= $packing_list[0]['created_by'] ?>" required readonly>
         </div>
         <div class="form-group col-md-12">
            <label>Production Remarks:</label>
            <textarea class="form-control" readonly><?= $packing_list[0]['production_remarks'] ?></textarea>
         </div>
      </div>
      <input type="hidden" name="post_quantity" value="<?= $da_items['quantity'] ?>">
   </div>
</div>
<div class="card mb-3">
   <div class="card-block">

      <?php if($da_header['da_type'] =='1' || $da_header['da_type'] =='3' || $da_header['da_type'] =='5' ) { ?>
        <div class="table-responsive">
         <table class="table table-bordered" width="300%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Packing Type</th>
                  <th>Excise Sr No</th>
                  <th>Batch No</th>
                  <th>Container No</th>
                  <th>Seal No</th>
                  <th>Inner Tare Weight</th>
                  <th>Outer Tare Weight</th>
                  <th>Net Weight</th>
                  <th>Inner Gross Weight</th>
                  <th>Outer Gross Weight</th>
                  <th>Mfg Date</th>
                  <th>Exp Date</th>
                  <th>ReTest Date</th>
                  <th>Dimensions</th>
                  <th>Pallet Dimensions</th>
                  <th>Pallet Gross Weight </th>
                  <th>Pallet No</th>
                  <th>Box No <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Boxes <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Packs<i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Packing Type</th>
                  <th>Excise Sr No</th>
                  <th>Batch No</th>
                  <th>Container No</th>
                  <th>Seal No</th>
                  <th>Inner Tare Weight</th>
                  <th>Outer Tare Weight</th>
                  <th>Net Weight</th>
                  <th>Inner Gross Weight</th>
                  <th>Outer Gross Weight</th>
                  <th>Mfg Date</th>
                  <th>Exp Date</th>
                  <th>ReTest Date</th>
                  <th>Dimensions</th>
                  <th>Pallet Dimensions</th>
                  <th>Pallet Gross Weight </th>
                  <th>Pallet No</th>
                  <th>Box No <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Boxes <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Packs<i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($packing_list)) {
                   $counter = 0;
                   foreach ($packing_list as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["kindofpackages"] ?></td>
                  <td><?= $value['excise_sr_no']?></td>
                  <td><?= $value["batch_no"] ?></td>
                  <td><?= $value['container_no'] ?></td>
                  <td><?= $value["seal_no"] ?></td>
                  <td><?= $value["inner_tare_weight"] ?></td>
                  <td><?= $value["outer_tare_weight"] ?></td>
                  <td><?= $value["net_weight"] ?></td>
                  <td><?= $value["inner_gross_weight"] ?></td>
                  <td><?= $value["outer_gross_weight"] ?></td>
                  <td><?= $value["mfg_date"] ?></td>
                  <td><?= $value["exp_date"] ?></td>
                  <td><?= $value["rate_st_date"] ?></td>
                  <td><?= $value["dimensions"] ?></td>
                  <td><?= $value["pallet_dimensions"] ?></td>
                  <td><?= $value["pallet_gross_weight"] ?></td>
                  <td><?= $value["pallet_no"] ?></td>
                  <td><?= $value["box_no"] ?></td>
                  <td><?= $value["box_no"] ?></td>
                  <td><?= $value["box_no"] ?></td>
               </tr>
               <?php }  } ?> 
            </tbody>
         </table>
      </div>
         
         <?php } else { ?>
         <div class="row">
            <div class="col-md-3">
               <a href="<?= base_url().'resources/packing-list-import/'.$packing_list[0]['file_path'] ?>" data-toggle="tooltip" data-placement="top" title="Click me to preview the packing list.">  
               <img src="<?= base_url().'resources/packing-list-import/excel-2016-mac-icon-100610905-gallery.png'?>" alt="excel-icon" height="200px" width="300px">   
               </a>
            </div>
            <div class="col-md-9">
               <p style="padding-top: 45px; font-weight: 500;">
                  ~ File Name:  <b class="text-danger"><?= $packing_list[0]['file_path'] ?></b><br>
                  ~ Download the file to check the packing list associated with this DA Item.
               </p>
            </div>
         </div>
     <?php  } ?>

   </div>
</div>

