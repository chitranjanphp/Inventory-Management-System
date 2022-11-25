 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
              <span class="pull-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add_product_form">Add Product</button>
              </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>HSN Code</th>
                    <th>Barcode</th>
                    <th>Unit</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($products)){
						$i=0;
						foreach($products as $product){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['category']; ?></td>
					<td><?php echo $product['subcategory']; ?></td>
                    <td><?php echo $product['hsn_code']; ?></td>
                    <td><?php echo $product['barcode']; ?></td>
                    <td><?php echo $product['unit_name']; ?></td>
                    <td><?php echo $product['cgst']." %"; ?></td>
                    <td><?php echo $product['sgst']." %"; ?></td>
					<td>
                        <!--<a href="<?php //echo base_url('products/editproduct/'.$product['id']); ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>&nbsp;-->
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editProduct('<?php echo $product['id']; ?>');"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('products/deleteproduct/'.$product['id']); ?>" onclick="return delconfirm();"><i class="fa fa-trash"></i> Delete</a>
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="box edit hidden">
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  <!-- /.content -->
   <!-- /.AddCategory modal -->

       <div class="modal modal-info fade" id="add_product_form">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Add Product</h4>
              </div>
              <form id="add-product-form" method="post" class="form-horizontal">
              <div class="modal-body">
                   <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="Category" class="col-sm-3 control-label">Category</label>
                              <div class="col-sm-6">
                                 <select name="category_id" id="category_id" class="form-control">
                                  <option value="">--Select Category--</option>
                                  <?php
                                  if(!empty($categories)){
								  foreach($categories as $cats):
								  ?>
                                   <option value="<?php echo $cats['id']; ?>"><?php echo $cats['category']; ?></option>
								  <?php endforeach; } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="Sub-Category" class="col-sm-3 control-label">Sub-Category</label>
                              <div class="col-sm-6">
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                  <option value="">--Select Sub-Category--</option>
                                </select>
                              </div>
                            </div>
                           <div class="form-group">
                              <label for="Product Name" class="col-sm-3 control-label">Product Name</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'product_name', 'id'=> 'product_name', 'placeholder'=>'Product Name', 'class'=>'form-control','value'=>set_value('product_name'),'required'=>'required','autocomplete'=>'off');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div> 
                          <div class="form-group">
                              <label for="Unit" class="col-sm-3 control-label">Unit</label>
                              <div class="col-sm-6">
                                  <select class="form-control select2" name="unit_id" id="unit_id" data-placeholder="Select a Unit" style="width: 100%;">
                                  <option value="">--Select Unit--</option>
                                  <?php
                                  if(!empty($units)){
								  foreach($units as $unit):
								  ?>
                                   <option value="<?php echo $unit['unit_id']; ?>"><?php echo $unit['unit_name']; ?></option>
								  <?php endforeach; } ?>
                                </select>
                              </div>
                           </div>
                          <div class="form-group">
                              <label for="HSN Code" class="col-sm-3 control-label">HSN Code</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'hsn_code', 'id'=> 'hsn_code', 'placeholder'=>'HSN Code', 'class'=>'form-control','value'=>set_value('hsn_code'),'required'=>'required','autocomplete'=>'off');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div> 
                          <div class="form-group">
                              <label for="Barcode" class="col-sm-3 control-label">Barcode</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'barcode', 'id'=> 'barcode', 'placeholder'=>'Barcode', 'class'=>'form-control','value'=>set_value('barcode'),'autocomplete'=>'off');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div> 
                          <div class="form-group">
                              <label for="CGST(%)" class="col-sm-3 control-label">CGST(%)</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'cgst', 'id'=> 'cgst', 'placeholder'=>'CGST(%)', 'class'=>'form-control','value'=>set_value('cgst'),'required'=>'required','autocomplete'=>'off');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div>
                         <div class="form-group">
                              <label for="SGST(%)" class="col-sm-3 control-label">SGST(%)</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'sgst', 'id'=> 'sgst', 'placeholder'=>'SGST(%)', 'class'=>'form-control','value'=>set_value('sgst'),'required'=>'required','autocomplete'=>'off');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div> 
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline btn-add-product" name="addproduct">Submit</button>
              </div>
             </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
       </div>
   <!-- /.End AddProduct modal -->
   
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
	  
		$('#example1').DataTable()
		$('#example2').DataTable({
		  'paging'      : true,
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : false
		})
	$("#category_id").change(function(){
		var category_id=$(this).val();
		//alert(category_id);
		$.ajax({
		  type:"POST",
		  url:'<?php echo base_url('subcategory/subcatbycategory'); ?>',
		  data:{category_id:category_id},
		  //dataType:'json',
		  success:function(data){
			 //alert(data);
			$("#subcategory_id").html(data);
		  }
	  });
	});	
	 $(".btn-add-product").click(function(e){
		    e.preventDefault();
	        $.ajax({
	            url: "<?php echo base_url('products/addproduct'); ?>",
	            type:'POST',
	            dataType: "json",
	            data: $("#add-product-form").serialize(),
	            success: function(data) {
	                if($.isEmptyObject(data.error)){
	                	$(".print-error-msg").css('display','none');
						location.reload();
	                    //alert(data.success);
	                }else{
						$(".print-error-msg").css('display','block');
	                	$(".print-error-msg").html(data.error);
	                }
	            }
	        });
	    });
		 
  });
  
  function editProduct(id){
	 $.ajax({
		  type:"POST",
		  url:'<?php echo base_url('products/editproduct'); ?>',
		  data:{id:id},
		  //dataType:'json',
		  success:function(data){
			 $(".list").toggleClass('hidden');
			 $(".edit").toggleClass('hidden');
			 $(".edit").html(data);
		  }
	  });
	  
  }
  function subcatChange(id){
		var category_id=id;
		//alert(category_id);
		$.ajax({
		  type:"POST",
		  url:'<?php echo base_url('subcategory/subcatbycategory'); ?>',
		  data:{category_id:category_id},
		  //dataType:'json',
		  success:function(data){
			 //alert(data);
			$("#editsubcategory_id").html(data);
		  }
	  });
  }
 function closeView(){
	$(".list").toggleClass('hidden');
	$(".edit").toggleClass('hidden'); 
 }
  function delconfirm(){
	if(confirm('Are you sure to delete this record?')){
		return true;
	}else{
	   return false;	
	}
  }
</script>

