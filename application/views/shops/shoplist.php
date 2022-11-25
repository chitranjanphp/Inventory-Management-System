 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Added Date</th>
                    <th>Shop Name</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Last Modified</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($shops)){
						foreach($shops as $shop){
				?>
				<tr>
					<td><?php echo date("d-m-Y h:i A",strtotime($shop['created_on'])); ?></td>
					<td><?php echo $shop['shop_name']; ?></td>
					<td><?php echo $shop['mobile']; ?></td>
					<td>
					<?php 
					if($shop['status']==0){
					   echo "<span class='text-danger'>Deactive</span>";	
					}else{
						echo "<span class='text-success'>Active</span>";
					}
					 ?>
					</td>
					<td><?php echo date("d-m-Y h:i A",strtotime($shop['updated_on'])); ?></td>
					<td>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('shops/editshop/'.$shop['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                        <a class="btn btn-primary btn-sm" href="#" onclick="setView('<?php echo $shop['id']; ?>');"><i class="fa fa-eye"></i> View</a>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('shops/deleteshop/'.$shop['id']); ?>" onclick="return delConfirm();"><i class="fa fa-trash"></i> Delete</a>
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Added Date</th>
                    <th>Shop Name</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Last Modified</th>
                    <th>Action</th>
                </tr>
                </tfoot>
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
  function delConfirm(){
	  if(confirm('Are you sure want to delete?')){
		 return true;
	  }else{
		return false;  
	  }
  }
  function setView(id){
	  $.ajax({
		  type:'POST',
		  url:'<?php echo base_url('shops/shopdetail'); ?>',
		  data:{id:id},
		  success:function(data){
			 $(".list").addClass('hidden');
	 		 $(".view").removeClass('hidden');
			 $(".view").html(data);  
		  }
	  });
  }
  function closeView(){
	$(".list").removeClass('hidden');
    $(".view").addClass('hidden');  
  }
</script>
