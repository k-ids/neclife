<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>

 

            <!-- Example Tables Card -->
            <div class="card mb-3">
                    <div class="card-header">
                      <i class="fa fa-table" style="color: green;"></i> <b>DA type listing</b>
                    </div>
                  <div class="card-block">
                      <label>Add DA type:</label>
    					<form method="POST" class="form-inline" action="<?= base_url().'masters/add_da_type' ?>">
        						<input type="hidden" name="action" value="add">
                                <input type="text" name="datype1"  class="form-control" placeholder="Enter DA type"  id="datype" value="<?= set_value('datype1'); ?>" >  
        						<button type="submit" class="btn btn-primary">Add</button><br>
                                <?php if(form_error('datype1')){  ?>
        							<div style="width:100%">
        								<?= form_error('datype1') ?>
        							</div>
        						<?php } ?>
                        
    					</form> 


                    </div>
                
				</div>
        
                <div class="card mb-3"> 
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>DA type</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>S.No</th>
                                    <th>DA type</th>
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