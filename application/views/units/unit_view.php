 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
              <span class="pull-right">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add_unit_modal">Add Unit</button>
              </span>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Product Units</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($units)){
						$i=0;
						foreach($units as $unit){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
                    <td><?php echo $unit['unit_name']; ?></td>
					<td>
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editunit('<?php echo $unit['unit_id']; ?>');">Edit</a>
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('units/deleteUnit/'.$unit['unit_id']); ?>" onclick="return delconfirm();"><i class="fa fa-trash"></i> Delete</a>
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

       <div class="modal modal-info fade" id="add_unit_modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Add Unit</h4>
              </div>
              <form id="add-unit-form" method="post" class="form-horizontal">
              <div class="modal-body">
                   <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="Enter Unit" class="col-sm-3 control-label">Enter Unit</label>
                              <div class="col-sm-6">
                                <?php 
                                    $data = array('name' => 'unit_name', 'id'=> 'unit_name', 'placeholder'=>'Enter Unit', 'class'=>'form-control','value'=>set_value('unit_name'),'required'=>'required');
                                    echo form_input($data);
                                ?>
                              </div>
                          </div> 
                       </div>
                   </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline btn-add-unit" name="addUnit">Submit</button>
              </div>
             </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
       </div>
    
    <!-- /.End UpdateProduct modal -->     
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
	 $(".btn-add-unit").click(function(e){
		    e.preventDefault();
	        $.ajax({
	            url: "<?php echo base_url('units/saveUnit'); ?>",
	            type:'POST',
	            dataType: "json",
	            data: $("#add-unit-form").serialize(),
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
 function editunit(id){
	 $.ajax({
		  type:"POST",
		  url:'<?php echo base_url('units/edit_unit'); ?>',
		  data:{id:id},
		  //dataType:'json',
		  success:function(data){
			 $(".list").toggleClass('hidden');
			 $(".edit").toggleClass('hidden');
			 $(".edit").html(data);
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

