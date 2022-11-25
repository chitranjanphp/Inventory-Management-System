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
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Shop</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($users)){
						$i=0;
						foreach($users as $user){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
					<td><?php echo $user['name']; ?></td>
					<td><?php echo $user['mobile']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['shop_name']; ?></td>
					<td>
					<?php 
					if($user['status']==0){
					   echo "<span class='text-danger'>Deactive</span>";	
					}else{
						echo "<span class='text-success'>Active</span>";
					}
					 ?>
					</td>
					<td>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('user/edituser/'.$user['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $user['id']; ?>');"><i class="fa fa-eye"></i> View</button>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('user/deleteuser/'.$user['id']); ?>" onclick="return delConfirm();"><i class="fa fa-trash"></i> Delete</a>
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
		  //type:'POST',
		  url: url+'/user/userdetail/'+id,
		  //data:{id:id},
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
