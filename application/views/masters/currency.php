<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
           <!-- Example Tables Card -->
            <div class="card mb-3">
				
                    <div class="card-header">
                      <i class="fa fa-table" style="color: green;"></i> <b>Currency listing</b>
                    </div>
                 <div class="card-block">
                     <label>Add currency:</label>
					<form method="POST" class="form-inline" action="<?=base_url()?>masters/currency_add">
						<input type="hidden" name="action" value="add">
                        <input type="text" name="currency" class="form-control" placeholder="Enter currency" id="currency">  
						<button type="submit" class="btn btn-primary" value="<?= set_value('currency')?>">Add</button>
                        <?php if(form_error('currency')){  ?>
                            <div style="width:100%">
                                <?= form_error('currency') ?>
                            </div>
                        <?php } ?>
					</form> 
					
					<!--<i class="fa fa-table"></i> Add DA Type <a href="<?=base_url()?>settings/admins/add"><button class="btn btn-primary">+</button></a>-->
                
				    </div>
                </div>
                 <div class="card mb-3">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            
							<thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Currency</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                     <th>S.No</th>
                                    <th>Currency</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i=1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$v["currency"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>