<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>

            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item active">DA Type</li>
            </ol>
 

            <!-- Example Tables Card -->
            <div class="card mb-3">
                <div class="card-header">
					<form method="POST" class="form-inline" action="<?= base_url().'masters/add_da_type' ?>">
						
						<input type="hidden" name="action" value="add">
                        <input type="text" name="datype1" data-toggle="tooltip" class="form-control" placeholder="Add DA Type" title="Add DA Type" id="datype" value="<?= set_value('datype1'); ?>" >  
						<button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Add DA Type">+</button><br>
                        <?php if(form_error('datype1')){  ?>
							<div style="width:100%">
								<?= form_error('datype1') ?>
							</div>
						<?php } ?>
					</form> 
					
					
                
				</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>DA Type</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>S.No</th>
                                    <th>DA Type</th>
                                </tr>
                            </tfoot>
                            <tbody> 
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php echo $v["datype"]; ?> </td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>