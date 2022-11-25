 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
              <span class="pull-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add_page_form">
                    Add Category
                  </button>
              </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Product Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($categories)){
						$i=0;
						foreach($categories as $category){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
					<td><?php echo $category['category']; ?></td>
					<td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editcategory('<?php echo $category['id']; ?>')"><i class="fa fa-pencil"></i> Edit</button>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('category/deletecategory/'.$category['id']); ?>" onclick="return delconfirm();"><i class="fa fa-trash"></i> Delete</a>
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
          <div class="box view hidden">
            
          </div>    
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  <!-- /.content -->
   <!-- /.AddCategory modal -->

        <div class="modal modal-info fade" id="add_page_form">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Category</h4>
              </div>
              <?php echo form_open('category/addcategory',array('class'=>'form-horizontal')); ?>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="Category Name" class="col-sm-3 control-label">Category Name</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'category', 'id'=> 'category', 'placeholder'=>'Category Name', 'class'=>'form-control','value'=>set_value('category'),'required'=>'required');
                                    echo form_input($data);
                                    echo form_error('category','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline" name="addcategory">Save</button>
              </div>
             <?php echo form_close(); ?> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
   <!-- /.End AddCategory modal -->
   <div class="modal modal-warning fade" id="edit_page_form">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Category</h4>
              </div>
              <?php echo form_open('category/updatecategory',array('class'=>'form-horizontal')); ?>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="Category Name" class="col-sm-3 control-label">Category Name</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'editcategory', 'id'=> 'editcategory', 'placeholder'=>'Category Name', 'class'=>'form-control','required'=>'required');
                                    echo form_input($data);
                                    echo form_error('editcategory','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <input type="hidden" name="id" id="id" />
                <button type="submit" class="btn btn-outline" name="updatecategory">Update</button>
              </div>
             <?php echo form_close(); ?> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script>
  $(document).ready(function () {
		$('#example1').DataTable()
		$('#example2').DataTable({
		  'paging'      : true,
		  'lengthChange': false,
		  'searching'   : false,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : false
		})
  });
  function editcategory(id){
	 $.ajax({
		  type:"POST",
		  url:'<?php echo base_url('category/getsinglecategory'); ?>',
		  data:{id:id},
		  dataType:'json',
		  success:function(data){
			 $("#edit_page_form").modal('show');
			 $("#id").val(id);
			 $("#editcategory").val(data['category']);
		  }
	  });
  }
  function delconfirm(){
	if(confirm('Are you sure want to delete?')){
		return true;
	}else{
	   return false;	
	}
  }
</script>
<?php if(validation_errors() != false){?>
<script type="text/javascript"> 
	$('#add_page_form').modal('show');
</script>
<?php } ?>
