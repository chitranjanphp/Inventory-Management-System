 <!-- Main content -->
    
            <div class="box-header">
              <h3 class="box-title">Shop Detail</h3>
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
                    <th>Shop Name :</th><td><?php echo $detail['shop_name']; ?></td>
                    <th>Mobile :</th><td><?php echo $detail['mobile']; ?></td>
                </tr>
                 <tr>
                    <th>GST IN :</th><td><?php echo $detail['gstin']; ?></td>
                    <th>Email :</th><td><?php echo $detail['email']; ?></td>
                </tr>
                <tr>
                    <th>Address :</th><td colspan="3"><?php echo $detail['address']; ?></td>
                </tr>
                <tr>
                    <th>Status :</th><td colspan="3"><?php if($detail['status']==1){echo "<span class='text-success'>Active</span>";}else{echo "<span class='text-danger'>DeActive</span>";} ?></td>
                </tr>
                </tbody>
              </table>
              <div class="text-right"><a href="#" class="btn btn-danger" onclick="closeView();">Close</a></div>
            </div>
            <!-- /.box-body -->
         