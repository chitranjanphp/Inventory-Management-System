 <!-- Main content -->
    
            <div class="box-header">
              <h3 class="box-title">Supplier Detail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>Added Date :</th><td><?php echo date("d-m-Y h:i A",strtotime($detail['created_on'])); ?></td>
                    <th>Last Modified :</th><td><?php echo date("d-m-Y h:i A",strtotime($detail['updated_on'])); ?></td>
                </tr>
                <tr>
                    <th>Name :</th><td><?php echo $detail['name']; ?></td>
                    <th>Mobile :</th><td><?php echo $detail['mobile']; ?></td>
                </tr>
                <tr>
                    <th>Role :</th><td><?php echo $detail['role']; ?></td>
                    <th>Username :</th><td><?php echo $detail['username']; ?></td>
                </tr>
                <tr>
                    <th>Status :</th><td colspan="3"><?php if($detail['status']==1){echo "<span class='text-success'>Active</span>";}else{echo "<span class='text-danger'>DeActive</span>";} ?></td>
                </tr>
                </tbody>
              </table>
              <div class="text-right"><a href="#" class="btn btn-danger" onclick="closeView();">Close</a></div>
            </div>
            <!-- /.box-body -->
         