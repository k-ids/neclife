<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Country</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                <div class="card-header">
					<!--<i class="fa fa-table"></i> Add Customer -->
					<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> Add Country </a>

					<form method="POST" id="collapseExample" class="collapse <?= !empty($this->session->userdata('error')) ? 'show': '' ?>" action="<?=base_url()?>masters/country_add" aria-exapnaded="<?= !empty($this->session->userdata('error')) ? 'true': 'false' ?>">
						<input type="hidden" name="action" value="add">
						<!--
						 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
						 -->
						<div class="form-group">
							<label for="email">Country:</label>
							<input type="text" name="country" class="form-control" placeholder="Add Country" id="country" value="<?= set_value('country') ?>">
							<?=  form_error('country') ?>
						</div>
						<div class="form-group">	
							<label for="email">Territory:</label>
							<select name="territory" class="form-control" id="territory">
						    <option value="">Select territory </option>
							<?php
							$CI =& get_instance();
							$all_territory  = $CI->Datype_model->getTerritory();
							// print_r($all_territory);
							foreach ($all_territory as $territory){
								?>
								<option value="<?= $territory['id'] ?>"><?php echo $territory['territory']; ?></option>
							<?php	
							}
							?>
							</select>
							<?=  form_error('territory') ?>
							
						</div>
						
						
						<button type="submit" class="btn btn-primary">Submit</button>

						<?= !empty($this->session->userdata('error')) ? anchor('masters/country', 'Cancel' , 'class="btn btn-primary"') : ''; ?>
					</form> 
					
					<!--<i class="fa fa-table"></i> Add DA Type <a href="<?=base_url()?>settings/admins/add"><button class="btn btn-primary">+</button></a>-->
                
				</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            
							<thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Country</th>
                                    <th>Territory</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>S.No</th>
                                    <th>Country</th>
                                    <th>Territory</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$v["country"]?></td>
                                    <td><?=$v["territory"]?></td>
                                   
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>