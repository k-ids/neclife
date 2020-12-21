<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>



            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">Despatch To</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                <div class="card-header">
					<form method="POST" class="form-inline" action="<?=base_url()?>masters/despatchto_add">
						<input type="hidden" name="action" value="add">
						<input type="text" name="despatchto" class="form-control" placeholder="Add Despatch To" data-toggle="tooltip" title="Add Despatch To" id="despatchto" value="<?= set_value('despatchto') ?>">  
						<button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Add Despatch To">+</button>
                         <?php if(form_error('despatchto')){  ?>
                            <div style="width:100%">
                                <?= form_error('despatchto') ?>
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
                                    <th>Despatch To</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                     <th>S.No</th>
                                    <th>Despatch To</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <!--<td><?=$v["id"]?></td>-->
                                    <td><?=$i?></td>
                                    <td><?=$v["despatchto"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>