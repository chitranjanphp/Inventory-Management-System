
            <div class="box-header with-border">
              <h3 class="box-title">Edit Product</h3>
            </div>
           <?php  //print_r($products); ?>
             <?php echo form_open('products/updateproduct',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                 <div class="form-group">
                  <label for="Category" class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-6">
                    <?php 
                        $js=array("onClick"=>'subcatChange(this.value);','class'=>'form-control','required'=>'required','id'=>'editcategory_id');
                        echo form_dropdown('editcategory_id', $categories,$products["category_id"],$js);
                        echo form_error('editcategory_id','<div class="text-danger">','</div>'); 
                    ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Sub-Category" class="col-sm-3 control-label">Sub-Category</label>
                  <div class="col-sm-6">
                    <?php 
                        echo form_dropdown('editsubcategory_id', $subcategories, $products["subcategory_id"],array('class'=>'form-control','id'=>'editsubcategory_id','required'=>'required'));
                        echo form_error('editsubcategory_id','<div class="text-danger">','</div>'); 
                    ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Product Name" class="col-sm-3 control-label">Product Name</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'editproduct_name', 'id'=> 'editproduct_name', 'placeholder'=>'Product Name', 'class'=>'form-control','required'=>'required','value'=>$products['product_name']);
                        echo form_input($data);
                        echo form_error('editproduct_name','<div class="text-danger">','</div>'); 
                    ?>
                  </div>
                </div> 
                <div class="form-group">
                  <label for="Unit" class="col-sm-3 control-label">Unit</label>
                  <div class="col-sm-6">
                      <select class="form-control select2" name="unit_id" id="unit_id" data-placeholder="Select a Unit" style="width: 100%;" required>
                      <option value="">--Select Unit--</option>
                      <?php
                      if(!empty($units)){
                      foreach($units as $unit):
					  $selected = $products['unit_id'] == $unit['unit_id']?'selected':'';
                      ?>
                       <option value="<?php echo $unit['unit_id']; ?>" <?php echo $selected; ?>><?php echo $unit['unit_name']; ?></option>
                      <?php endforeach; } ?>
                    </select>
                  </div>
               </div>
              <div class="form-group">
                  <label for="HSN Code" class="col-sm-3 control-label">HSN Code</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'hsn_code', 'id'=> 'hsn_code', 'placeholder'=>'HSN Code', 'class'=>'form-control','value'=>$products['hsn_code'],'required'=>'required');
                        echo form_input($data);
                    ?>
                  </div>
              </div>
              <div class="form-group">
                  <label for="Barcode" class="col-sm-3 control-label">Barcode</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'barcode', 'id'=> 'barcode', 'placeholder'=>'Barcode', 'class'=>'form-control','value'=>$products['barcode'],'required'=>'required','autocomplete'=>'off');
                        echo form_input($data);
                    ?>
                  </div>
              </div>  
              <div class="form-group">
                  <label for="CGST(%)" class="col-sm-3 control-label">CGST(%)</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'cgst', 'id'=> 'cgst', 'placeholder'=>'CGST(%)', 'class'=>'form-control','value'=>$products['cgst'],'required'=>'required');
                        echo form_input($data);
                    ?>
                  </div>
              </div>
             <div class="form-group">
                  <label for="SGST(%)" class="col-sm-3 control-label">SGST(%)</label>
                  <div class="col-sm-6">
                    <?php 
                        $data = array('name' => 'sgst', 'id'=> 'sgst', 'placeholder'=>'SGST(%)', 'class'=>'form-control','value'=>$products['sgst'],'required'=>'required');
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
		
