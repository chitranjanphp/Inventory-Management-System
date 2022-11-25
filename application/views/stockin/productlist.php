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
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Product Name</th>
                    <th>HSN Code</th>
                    <th>QTY</th>
                    <th>Pur. Price</th>
                    <th>Sale Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($products)){
						$i=0;
						foreach($products as $rows){
				?>
				<tr>
					<td><?php echo ++$i; ?></td>
                    <td><?php echo $rows['category']; ?></td>
                    <td><?php echo $rows['subcategory']; ?></td>
					<td><?php echo $rows['product_name']; ?></td>
                    <td><?php echo $rows['hsn_code']; ?></td>
					<td><?php echo $rows['qty']." ".$rows['unit_name']; ?></td>
					<td><?php echo number_format($rows['purchase_price'],2); ?></td>
                    <td><?php echo number_format($rows['sale_price'],2); ?></td>
					<td>
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editPrice('<?php echo $rows['id']; ?>');"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                        <!--<button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php //echo $rows['id']; ?>');"><i class="fa fa-eye"></i> View</button>&nbsp;
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return cancelInvoice('<?php //echo $rows['id']; ?>');"> Cancel</a>-->
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
  
 function editPrice(id){
	 $.ajax({
		  type:"POST",
		  url:'<?php echo base_url('stock_in/editprice'); ?>',
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
	$(".list").removeClass('hidden');
    $(".edit").addClass('hidden');  
  }
</script>
