<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Production</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/add_packing_list/'.$da_header['id'] ?>">Packing List(New) - Plant</a></li>
   <li class="breadcrumb-item">Add</li>

   </li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">
    <div class="card-block">
        <div style="float: right;">
            <a class="btn btn-success" href="<?= base_url(). $this->router->fetch_class(). '/generate_production_excel/'. $da_header['id'] .'/'.$da_items['id'] ?>"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Export Excel</a>
        </div>
    </div>
</div>

<form method="POST" action="<?= base_url().$this->router->fetch_class().'/add_packing_list_form/'.$da_header['id'].'/'.$da_items['id'] ?>" enctype="multipart/form-data">
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table" style="color: green;"></i> <b>DA Header Items</b>
    </div>
    <div class="card-block">
        
        <div class="row">

          <div class="form-group col-md-6">
            <label>DA NO.: </label>
            <input type="text" class="form-control" name="da_no" value="<?= $da_header['da_no'] ?>" required readonly>
            <?= form_error('da_no') ?>
          </div>
          <input type="hidden" name="post_da_no" value="<?= $da_header['id']?>">
          <div class="form-group col-md-6">
            <label>DA Fin Year:</label>
            <input type="text" class="form-control" name="financial_year" value="<?= $da_header['financial_year']  ?>" required readonly>
            <?= form_error('financial_year') ?>
          </div>
        
       </div>
       <div class="row">

          <div class="form-group col-md-6">
            <label>Party:</label>
            <input type="text" class="form-control" name="buyer_name" value="<?= $da_header['buyer_name']  ?>" required readonly>
            <?= form_error('buyer_name') ?>
          </div>
          <input type="hidden" name="post_buyer" value="<?= $da_header['buyer']?>">
          <div class="form-group col-md-6">
            <label>DA Type:</label>
            <input type="text" class="form-control" name="datype_name" value="<?= $da_header['datype_name'] ?>" required readonly>
            <?= form_error('da_no') ?>
          </div>
          <input type="hidden" name="post_da_type" value="<?= $da_header['da_type']?>">
          <input type="hidden" name="post_dept" value="<?= $da_header['department']?>">
       </div>
       <hr>


    <div class="row">
        <div class="form-group col-md-6">
            <label>Product:</label>
            <input type="text" class="form-control" name="product_name" value="<?= $da_items['product_name']  ?>" required readonly>
            <?= form_error('product_name') ?>
          </div>
          <input type="hidden" name="post_product" value="<?= $da_items['product']?>">
          <div class="form-group col-md-6">
            <label>Product From:</label>
            <input type="text" class="form-control" name="productform" value="<?= $da_items['productform'] ?>" required readonly>
            <?= form_error('productform') ?>
        </div>
        <input type="hidden" name="post_product_form" value="<?= $da_items['product_form']?>">
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Grade:</label>
            <input type="text" class="form-control" name="productgrade" value="<?= $da_items['productgrade']  ?>" required readonly>
            <?= form_error('productgrade') ?>
            <input type="hidden" name="post_grade" value="<?= $da_items['grade']?>">

          </div>
          <div class="form-group col-md-6">
            <label>Packing Type:</label>
            <input type="text" class="form-control" name="kindofpackages" value="<?= $da_items['kindofpackages'] ?>" required readonly>
            <?= form_error('kindofpackages') ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>DA Qty:</label>
            <input type="text" class="form-control" name="quantity" value="<?= $total_da_qty ?>" required>
            <?= form_error('quantity') ?>
          </div>
          <div class="form-group col-md-6">
            <label>Total Qty in this List:</label>
            <input type="text" class="form-control" id="qty_in_list" name="qty_in_list" value="<?=  !empty($da_items['quantity'] ) ? $da_items['quantity'] : '' ?>" required>
            <?= form_error('qty_in_list') ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Total Qty Dispatched:</label>
            <input type="text" class="form-control" id="qauntity_dispatched" name="qauntity_dispatched" value="<?= !empty($packing_list) ? $packing_list[0]['total_qty_despatch'] : '' ?>" required >
            <?= form_error('qauntity_dispatched') ?>
          </div>
          <div class="form-group col-md-6">
            <label>Packing List Date:</label>
            <input type="text" class="form-control" name="packing_list_date" id="<?= !empty($packing_list) ? 'packing_list_date_1' : 'packing_list_date' ?>" value="<?= set_value('packing_list_date', nice_date($packing_list[0]['packing_list_date'], 'd-M-Y')) ?>" required readonly>
            <?= form_error('packing_list_date') ?>
        </div>
        <div class="form-group col-md-6">
            <label>Packing List Time:</label>
            <input type="text" class="form-control" name="packing_list_time" id="packing_list_time" value="<?= !empty($packing_list) ? $packing_list[0]['packing_list_time'] : '' ?>" required readonly>
            <?= form_error('packing_list_time') ?>
        </div>
    </div>
    <input type="hidden" name="post_quantity" value="<?= $da_items['quantity'] ?>">

</div>
</div>
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table" style="color: green;"></i> <b>DA Item - Packing List</b>
    </div>
    <div class="card-block">

      <div class="row">
          <div class="form-group col-md-12">
            <input type="checkbox" name="show_seal_no" value="1">
             <b class="text-danger">Please mark box checked if you want to show the seal number in API invoce.</b>
          </div>
      </div>
        
      <?php if($da_header['da_type'] =='1' || $da_header['da_type'] =='3' || $da_header['da_type'] =='5' ) { ?>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" id="table-packing-list" cellspacing="0">
            <thead>
               <tr>
                  <th>Packing Type</th>
                  <th>Prefix</th>
                  <th>Excise Sr No</th>
                  <th>Batch No</th>
                  <th>Container No</th>
                  <th>Seal No</th>
                  <th>Inner Tare Weight</th>
                  <th>Outer Tare Weight </th>
                  <th>Net Weight</th>
                  <th>Inner Gross Weight</th>
                  <th>Outer Gross Weight </th>
                  <th>Mfg Date</th>
                  <th>Exp Date  </th>
                  <th>ReTest Date </th>
                  <th>Dimensions</th>
                  <th>Pallet Dimensions</th>
                  <th>Pallet Gross Weight</th>
                  <th>Pallet No </th>
                  <th>Box No <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Boxes <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Total Nos. of Packs<i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="For Capsule and formulation use only."></i></th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody id="table-packing-list-row">
             <?php if(!empty($packing_list)) {
              foreach($packing_list as $key => $value) { ?>
              <tr class="db-data" style="background: aliceblue;">
                <td>
                  <div class="form-group">
                    <select name="packing_type[]" class="form-control" id="packing_type-<?= $key + 1000 ?>">
                      <option value="">Please select one</option>
                      <?php if(!empty($packing_type)) {
                        foreach ($packing_type as $innerValue) { ?>
                            <option value="<?= $innerValue['kindofpackages'] ?>" <?php if($value['packing_type'] == $innerValue['kindofpackages']) { echo 'selected'; } ?> ><?= $innerValue['kindofpackages'] ?></option>
                       <?php  }
                        } ?>
                    </select>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="perfix[]" class="form-control" value="<?= $value['prefix']?>" id="perfix-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="excise_sr_no[]"  value="<?= $value['excise_sr_no']?>" class="form-control" id="excise_sr_no-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="batch_no[]" value="<?= $value['batch_no']?>" class="form-control" id="batch_no-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="container[]" value="<?= $value['container_no']?>" class="form-control" id="container-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="seal_no[]" value="<?= $value['seal_no']?>" class="form-control" id="seal_no-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="inner_tare_weight[]" value="<?= $value['inner_tare_weight']?>" class="form-control" onchange="tareNetCalculation(<?= $key + 1000 ?>)" id="inner_tare-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="outer_tare_weight[]" value="<?= $value['outer_tare_weight']?>" class="form-control" onchange="tareNetCalculation(<?= $key + 1000 ?>)" id="outer_tare-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="net_weight[]" value="<?= $value['net_weight']?>" class="form-control" onchange="tareNetCalculation1(<?= $key + 1000 ?>)" id="net_weight-<?= $key + 1000 ?>">
                  </div>
                </td>

                <td>
                   <div class="form-group">
                    <input type="text" name="inner_gross_weight[]" value="<?= $value['inner_gross_weight']?>" class="form-control" id="inner_gross_weight-<?= $key + 1000 ?>" readonly>
                  </div>
                </td>

                <td>
                   <div class="form-group">
                    <input type="text" name="outer_gross_weight[]" value="<?= $value['outer_gross_weight']?>" class="form-control" id="outer_gross_weight-<?= $key + 1000 ?>" readonly>
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="mgf_date[]" value="<?= $value['mfg_date']?>" class="form-control mfg_date" id="mgf_date-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="exp_date[]" value="<?= $value['exp_date']?>" class="form-control exp_date" id="exp_date-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="retest_date[]" value="<?= $value['rate_st_date']?>" class="form-control retest_date" id="retest_date-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="dimensions[]" value="<?= $value['dimensions'] ?>" class="form-control"  id="dimensions-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="pallet_dimensions[]" value="<?= $value['pallet_dimensions']?>" class="form-control" id="pallet_dimensions-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="pallet_gross_weight[]" value="<?= $value['pallet_gross_weight']?>" class="form-control" id="pallet_gross_weight-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="pallet_no[]" value="<?= $value['pallet_no']?>" class="form-control" id="pallet_no-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="box_no[]" value="<?= $value['box_no']?>" class="form-control" id="box_no-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="total_no_boxes[]" value="<?= $value['total_no_boxes']?>" class="form-control" id="total_no_packs-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="total_no_packs[]" value="<?= $value['total_no_packs']?>" class="form-control" id="total_no_packs-<?= $key + 1000 ?>">
                  </div>
                </td>
                <td>
                    <input type="button" value="Delete" id="delete-<?= $value['id'] ?>" class="btn btn-danger" data-id="<?= $value['id'] ?>"  data-url="<?= base_url().$this->router->fetch_class().'/delete_packing_list/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Delete record permanetly"/>
                </td>
              </tr>
            <?php } } ?>
            <?php if(empty($packing_list)) { ?>
             <tr>
                <td id="0">
                  <div class="form-group">
                    <select name="packing_type[]" class="form-control" id="packing_type-0">
                      <option value="">Please select one</option>
                      <?php if(!empty($packing_type)) {
                        foreach ($packing_type as $value) { ?>
                            <option value="<?= $value['kindofpackages'] ?>"><?= $value['kindofpackages'] ?></option>
                       <?php  }
                        } ?>
                    </select>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="perfix[]" id="perfix-0" value="" class="form-control">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="excise_sr_no[]" id="excise_sr_no-0" value="" class="form-control" onkeyup="checkDigitOrNot(0)">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="batch_no[]" id="batch_no-0" value="" class="form-control">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="container[]" id="container-0" value="" class="form-control">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="seal_no[]" id="seal_no-0" value="" class="form-control">
                  </div>
                </td>

                <td>
                   <div class="form-group">
                    <input type="text"  name="inner_tare_weight[]" value="" class="form-control inner-tare" onchange="tareNetCalculation(0)" id="inner_tare-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="outer_tare_weight[]" value="" class="form-control outer-tare" onchange="tareNetCalculation(0)" id="outer_tare-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="net_weight[]" value="" class="form-control"  id="net_weight-0" onchange="tareNetCalculation1(0)">
                  </div>
                </td>

                <td>
                   <div class="form-group">
                    <input type="text" name="inner_gross_weight[]" value="" class="form-control" readonly id="inner_gross_weight-0">
                  </div>
                </td>

                   <td>
                   <div class="form-group">
                    <input type="text" name="outer_gross_weight[]" value="" class="form-control" readonly id="outer_gross_weight-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="mgf_date[]" value="" class="form-control mfg_date" id="mgf_date-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="exp_date[]" value="" class="form-control exp_date" id="exp_date-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="retest_date[]" value="" class="form-control retest_date" id="retest_date-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="dimensions[]" value="" class="form-control" id="dimensions-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="pallet_dimensions[]" value="" class="form-control" id="pallet_dimensions-0">
                  </div>
                </td>
                <td>
                   <div class="form-group">
                    <input type="text" name="pallet_gross_weight[]" value="" class="form-control" id="pallet_gross_weight-0">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="pallet_no[]" value="" class="form-control" id="pallet_no-0">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="box_no[]" value="" class="form-control" id="box_no-0">
                  </div>
                </td>

                <td>
                  <div class="form-group">
                    <input type="text" name="total_no_boxes[]" value="" class="form-control" id="total_no_boxes-0">
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <input type="text" name="total_no_packs[]" value="" class="form-control" id="total_no_packs-0">
                  </div>
                </td>

                <td>
                  
                </td>
              </tr>
            <?php } ?>
            </tbody>

               </table>
               <button type="button"  id="add_more-packing-list" class="btn btn-success" title="Please select da type above to proceed."><i class="fa fa-plus"></i>&nbsp;Add Row</button>
            </div>

            <?php }  else { ?>
               <!-- Drop Zone -->
              <h5 class="text-danger">Browse the defined format file from the sytem to upload. </h5>
              <small style="font-size: 90%;" class="text-danger">*Please choose an Excel file(.xls or .xlxs) as Input</small> <br>
            
              <div class="upload-drop-zone text-danger" id="drop-zone">
                   Click to upload the file.
              </div>

              <?php if(!empty($db_file_path)) { ?>
                 
                 <a href="<?= base_url().'resources/packing-list-import/'.$db_file_path ?>" data-toggle="tooltip" data-placement="top" title="Click me to preview the packing list.">  
                   <img src="<?= base_url().'resources/packing-list-import/excel-2016-mac-icon-100610905-gallery.png'?>" alt="excel-icon" height="100px" width="100px">
                 </a>
                
                 <a style="text-decoration: none;" href="javascript:void(0);" class="text-danger" data-url="<?= base_url().$this->router->fetch_class().'/delete_packing_list/'.$packing_list[0]['id']?>" id="delete-<?= $packing_list[0]['id'] ?>" class="btn btn-danger" data-id="<?= $packing_list[0]['id'] ?>" >Remove Packing List </a><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="The packing list will be deleted for the DA Item by clicking remove packing list. Or this file will be replaced by re-uploading the new one to this particular DA Item."></i>
                 

              <?php } ?>
              <input id="upload_excel" name="packing_excel" type="file"/ style="display: none;">
              <input type="hidden" name="db-file-name" value="<?= $db_file_path ?>">

      <?php } ?>
  </div>
</div>

<div class="card mb-3">
    <div class="col-md-12">
        <div class="card-block">
              <div class="form-group">
                <label>Production Remarks:</label>
                <textarea class="form-control" name="production_remarks" cols="5" rows="5" required><?= $production_remarks ?></textarea>
              </div>
              <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
              <a href="<?= base_url().$this->router->fetch_class().'/add_packing_list/'.$da_header['id'] ?>" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancel</a>

        </div>
    </div>
  </div>
</form>
