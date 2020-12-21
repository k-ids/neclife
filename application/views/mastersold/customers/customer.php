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
                                    <th>Bank Details</th>
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
                                    <th>Bank Details</th>
                                    <th>ECGC INR</th>
									<th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php 
							$i=1;
                                if(!empty($customers)) {
                                    foreach ($customers as $v) { ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$v["party"]?></td>
                                        <td><?=$v["address1"]?></td>
                                        <td><?=$v["address2"]?></td>
                                        <td><?=$v["address3"]?></td>
                                        <td><?=$v["phone"]?></td>
                                        <td><?=$v["fax"]?></td>
                                        <td><?=$v["bankdetails"]?></td>
                                        <td><?=$v["ecgcinr"]?></td>
                                        <td>
    									<a href="<?=base_url()?>masters/customer_edit/<?=$v["id"]?>"><button class="btn btn-primary">Update</button></a>
    									
    									</td>
                                    </tr>
									<?php $i++; ?>
                            <?php }  } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>

