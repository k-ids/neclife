<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>


            <!-- Example Tables Card -->
            <div class="card mb-3">
				
                 <div class="card-header">
                      <i class="fa fa-table" style="color: green;"></i> <b>Lable listing</b>
                    </div>
                 <div class="card-block">
                     <label>Add lable:</label>
					<form method="POST" class="form-inline" action="<?=base_url()?>masters/label_add">
						<input type="hidden" name="action" value="add">
						<input type="text" name="label" class="form-control" placeholder="Enter label" id="label" value="<?= set_value('label') ?>">  
						<button type="submit" class="btn btn-primary">Add</button>
                         <?php if(form_error('label')){  ?>
                            <div style="width:100%">
                                <?= form_error('label') ?>
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
                                    <th>Label</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                     <th>S.No</th>
                                    <th>Label</th>
                                </tr>
                            </tfoot>
                            <tbody>
							<?php $i = 1; ?>
                            <?php foreach ($admins as $v) { ?>
                                <tr>
                                    <!--<td><?=$v["id"]?></td>-->
                                    <td><?=$i?></td>
                                    <td><?=$v["label"]?></td>
                                </tr>
								<?php $i++; ?>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>