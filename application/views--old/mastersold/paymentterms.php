<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Payment Terms</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                <div class="card-header">
					<form method="POST" class="form-inline" action="<?=base_url()?>masters/paymentterms_add">
						<input type="hidden" name="action" value="add">
						<input type="text" name="paymentterms" class="form-control" placeholder="Add Payment Terms" id="paymentterms" data-toggle="tooltip" title="Add Payment Terms" value="<?= set_value('paymentterms') ?>">  
						<button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Add Payment Terms">+</button>
                         <?php if(form_error('paymentterms')){  ?>
                            <div style="width:100%">
                                <?= form_error('paymentterms') ?>
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
                                    <th>Payment Terms</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                     <th>S.No</th>
                                    <th>Payment Terms</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <!--<td><?=$v["id"]?></td>-->
                                    <td><?=$i?></td>
                                    <td><?=$v["paymentterms"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>