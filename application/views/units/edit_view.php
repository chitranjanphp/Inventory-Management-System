 
            <div class="box-header with-border">
              <h3 class="box-title">Update Unit</h3>
            </div>
           <?php  //print_r($products); ?>
             <?php echo form_open('units/updateUnit',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                  <div class="form-group">
                      <label for="Enter Unit" class="col-sm-3 control-label">Update Unit </label>
                      <div class="col-sm-3">
                        <?php 
                            $data = array('name' => 'edit_unit_name', 'id'=> 'edit_unit_name', 'placeholder'=>'Update Unit', 'class'=>'form-control','value'=>$units['unit_name'],'required'=>'required');
                            echo form_input($data);
                        ?>
                      </div>
                  </div> 
                 <div class="box-footer">
                 <div class="col-md-3"></div>
                <?php 
					$data = array('name' => 'update_unit', 'value'=>'Update', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
                 &nbsp;&nbsp;<a href="javascript:void(0);" onclick="closeView();" class="btn btn-danger">Close</a>
                </div>
            </div>
            <!-- /.box-body -->
           <?php echo form_hidden('edit_unit_id',$units['unit_id']); echo form_close(); ?> 
		
        
       
