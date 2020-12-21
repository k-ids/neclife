<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Customer</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                <div class="card-header">
					<!--<i class="fa fa-table"></i> Add Customer -->
                    <!-- <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> Add Customer </a> -->

                    <?= anchor('masters/customer_add', 'Add Customer', 'class="btn btn-primary"') ?>

					<form method="POST" id="collapseExample" class="collapse" action="<?= base_url()?>masters/customer_add">
						<input type="hidden" name="action" value="add">
						<!--
						 // party 	address1 	address2 	address3 	phone 	fax 	bank details 	ecgc inr
						 -->
						<div class="form-group">
							<label for="email">Party:</label>
							<input type="text" name="party" class="form-control" placeholder="Enter Party Name" id="party"
                            value="<?= set_value('party') ?>">
                             <?= form_error('party') ?>
						</div>
						<div class="form-group">	
							<label for="email">Address 1:</label>
							<input type="text" name="address1" class="form-control" placeholder="Enter Address 1" id="address1"  value="<?= set_value('address1') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">Address 2:</label>
							<input type="text" name="address2" class="form-control" placeholder="Enter Address 2" id="address2"  value="<?= set_value('address2') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">Address 3:</label>
							<input type="text" name="address3" class="form-control" placeholder="Enter Address 3" id="address3"  value="<?= set_value('address3') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">Phone:</label>
							<input type="text" name="phone" class="form-control" placeholder="Enter Phone" id="phone"  value="<?= set_value('phone') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">Fax:</label>
							<input type="text" name="fax" class="form-control" placeholder="Enter Fax" id="fax"  value="<?= set_value('fax') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">Bank Details:</label>
							<input type="text" name="bankdetails" class="form-control" placeholder="Enter Bank Details" id="bankdetails"  value="<?= set_value('bankdetails') ?>">  
						</div>
						<div class="form-group">	
							<label for="email">ECGC INR:</label>
							<input type="text" name="ecgcinr" class="form-control" placeholder="Enter ECGC INR" id="ecgcinr"  value="<?= set_value('ecgcinr') ?>">
						</div>
						
						<button type="submit" class="btn btn-primary">Submit</button>
					</form> 
					
					<!--<i class="fa fa-table"></i> Add DA Type <a href="<?=base_url()?>settings/admins/add"><button class="btn btn-primary">+</button></a>-->
                
				</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            
							<thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Party</th>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>Address 3</th>
                                    <th>Phone</th>
                                    <th>Fax</th>
                                    <th>Bank Deatils</th>
                                    <th>ECGC INR</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>S.No</th>
                                    <th>Party</th>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>Address 3</th>
                                    <th>Phone</th>
                                    <th>Fax</th>
                                    <th>Bank Deatils</th>
                                    <th>ECGC INR</th>
									<th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <td><?=$v["id"]?></td>
                                    <td><?=$v["party"]?></td>
                                    <td><?=$v["address1"]?></td>
                                    <td><?=$v["address2"]?></td>
                                    <td><?=$v["address3"]?></td>
                                    <td><?=$v["phone"]?></td>
                                    <td><?=$v["fax"]?></td>
                                    <td><?=$v["bankdetails"]?></td>
                                    <td><?=$v["ecgcinr"]?></td>
                                    <td>
									<a href="<?=base_url()?>masters/edit-customer/<?=$v["id"]?>"><button class="btn btn-primary">Update</button></a>
									
									</td>
                                </tr>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>

