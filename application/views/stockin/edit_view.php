
            <div class="box-header with-border">
              <h3 class="box-title">Edit Price</h3>
            </div>
           <?php  //print_r($products); ?>
             <?php echo form_open('stock_in/updateprice',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
              <div class="form-group">
                  <label for="HSN Code" class="col-sm-3 control-label">Sale Price</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'sale_price', 'id'=> 'sale_price', 'placeholder'=>'Sale Price', 'class'=>'form-control','value'=>$products['sale_price'],'required'=>'required');
                        echo form_input($data);
                    ?>
                    
                  </div>
              </div>
                 <div class="box-footer">
                 <div class="col-md-3"></div>
                <?php 
					$data = array('name' => 'updateproduct', 'value'=>'Update', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
                 &nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-danger" onclick="closeView();">Close</a>
                </div>
            </div>
            <!-- /.box-body -->
           <?php echo form_hidden('id',$products['id']); echo form_close(); ?> 
		
