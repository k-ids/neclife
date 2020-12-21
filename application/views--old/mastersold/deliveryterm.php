<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Delivery Term</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-6">
				
                <div class="card-header">
					<form method="POST" class="form-inline" action="<?=base_url()?>masters/deliveryterm_add">
						<input type="hidden" name="action" value="add">
						<input type="text" name="deliveryterm" class="form-control" placeholder="Add Delivery Term" data-toggle="tooltip" title="Add Delivery Term" id="deliveryterm" value="<?= set_value('deliveryterm') ?>">  
						<button type="submit" class="btn btn-primary"data-toggle="tooltip" title="Add Delivery Term">+</button>
                         <?php if(form_error('deliveryterm')){  ?>
                            <div style="width:100%">
                                <?= form_error('deliveryterm') ?>
                            </div>
                        <?php } ?>
					</form> 
					
					<!--<i class="fa fa-table"></i> Add DA Type <a href="<?=base_url()?>settings/admins/add"><button class="btn btn-primary">+</button></a>-->
                
				</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            
							<thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Delivery Term</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                     <th>S.No</th>
                                    <th>Delivery Term</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <!--<td><?=$v["id"]?></td>-->
                                    <td><?=$i?></td>
                                    <td><?=$v["deliveryterm"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>