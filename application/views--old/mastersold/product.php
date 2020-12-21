<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Product</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                <div class="card-header">
					<!--<i class="fa fa-table"></i> Add Customer -->
					<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> Add Product </a>
					<form method="POST" id="collapseExample" class="collapse <?= !empty($this->session->userdata('error')) ? 'show': '' ?>" action="<?=base_url()?>masters/product_add" aria-exapnaded="<?= !empty($this->session->userdata('error')) ? 'true': 'false' ?>>
						<input type="hidden" name="action" value="add">
						<!--
						 // table col name :- product datype hscode
						 -->
						<div class="form-group">
							<label for="product">Product Name:</label>
							<input type="text" name="product" class="form-control" placeholder="Add Product Name" id="product"  data-toggle="tooltip" title="Add Product Name" value="<?= set_value('product')?>">
							 <?= form_error('product') ?>
						</div>
						<div class="form-group">	
							<label for="datype">DA Type:</label>
							<select name="datype" class="form-control" id="datype"  data-toggle="tooltip" title="Select DA Type">
						    <option value="">Select one</option>									
							<?php
							$CI =& get_instance();
							$all_territory  = $CI->Datype_model->getAdmins();
							// print_r($all_territory);
							foreach ($all_territory as $territory){
								?>
								<option value="<?= $territory['datype'] ?>"><?php echo $territory['datype']; ?></option>
							<?php	
							}
							?>
							</select>
							<?= form_error('datype') ?>
							
						</div>
						<div class="form-group">
							<label for="hscode">HS Code:</label>
							<input type="text" name="hscode" class="form-control" placeholder="Add HS Code" id="hscode"  data-toggle="tooltip" title="Add HS Code" value="<?= set_value('hscode') ?>">
							<?= form_error('hscode') ?>
						</div>
						
						
						<button type="submit" class="btn btn-primary">Submit</button>
						<?= !empty($this->session->userdata('error')) ? anchor('masters/product', 'Cancel' , 'class="btn btn-primary"') : ''; ?>
					</form> 
					
					<!--<i class="fa fa-table"></i> Add DA Type <a href="<?=base_url()?>settings/admins/add"><button class="btn btn-primary">+</button></a>-->
                
				</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            
							<thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>DA Type</th>
                                    <th>HS Code</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>DA Type</th>
                                    <th>HS Code</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <!--td><?=$v["id"]?></td-->
									<td><?=$i?></td>
                                    <td><?=$v["product"]?></td>
                                    <td><?=$v["datype"]?></td>
                                    <td><?=$v["hscode"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>