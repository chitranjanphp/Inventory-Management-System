 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
              <span class="pull-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add_page_form">
                    Add Sub-Category
                  </button>
              </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Sub-Category</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($subcategories)){
						$i=0;
						foreach($subcategories as $subcatval){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
					<td><?php echo $subcatval['subcategory']; ?></td>
                    <td><?php echo $subcatval['category']; ?></td>
					<td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editSubCategory('<?php echo $subcatval['id']; ?>')"><i class="fa fa-pencil"></i> Edit</button>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('subcategory/deletesubcategory/'.$subcatval['id']); ?>" onclick="return delconfirm();"><i class="fa fa-trash"></i> Delete</a>
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
                <h4 class="modal-title">Add Sub-Category</h4>
              </div>
              <?php echo form_open('subcategory/addsubcategory',array('class'=>'form-horizontal')); ?>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="Category" class="col-sm-3 control-label">Category</label>
                              <div class="col-sm-6">
                                <?php 
									echo form_dropdown('category_id', $categories,set_value('category_id'),array('class'=>'form-control','required'=>'required'));
									echo form_error('category_id','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="Sub-Category Name" class="col-sm-3 control-label">Sub-Category</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'subcategory', 'id'=> 'subcategory', 'placeholder'=>'Sub-Category Name', 'class'=>'form-control','value'=>set_value('subcategory'),'required'=>'required');
                                    echo form_input($data);
                                    echo form_error('subcategory','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline" name="addsubcategory">Save</button>
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
                <h4 class="modal-title">Update Sub-Category</h4>
              </div>
              <?php echo form_open('subcategory/updatesubcategory',array('class'=>'form-horizontal')); ?>
              <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="Category" class="col-sm-3 control-label">Category</label>
                              <div class="col-sm-6">
                                <?php 
									echo form_dropdown('editcategory_id', $categories,set_value('editcategory_id'),array('class'=>'form-control','required'=>'required','id'=>'editcategory_id'));
									echo form_error('editcategory_id','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="Category Name" class="col-sm-3 control-label">Sub-Category</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'editsubcategory', 'id'=> 'editsubcategory', 'placeholder'=>'Sub-Category Name', 'class'=>'form-control','required'=>'required');
                                    echo form_input($data);
                                    echo form_error('editsubcategory','<div class="text-danger">','</div>'); 
                                ?>
                              </div>
                            </div>
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <input type="hidden" name="id" id="id" />
                <button type="submit" class="btn btn-outline" name="updatesubcategory">Update</button>
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
  function editSubCategory(id){
	 $.ajax({
		  type:"POST",
		  url:'<?php echo base_url('subcategory/getsinglesubcategory'); ?>',
		  data:{id:id},
		  dataType:'json',
		  success:function(data){
			 $("#edit_page_form").modal('show');
			 $("#id").val(id);
			 $("#editcategory_id").val(data['category_id']);
			 $("#editsubcategory").val(data['subcategory']);
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
