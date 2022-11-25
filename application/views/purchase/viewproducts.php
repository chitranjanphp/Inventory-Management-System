 <!-- Main content -->
    
            <div class="box-header">
              <h3 class="box-title">Product details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>Product Name</th>
                    <th>HSN Code</th>
                    <th>Price</th>
                    <th>QTY</th>
                    <th>Total</th>
                    <th>GST Rate</th>
                    <th>GST</th>
                    <th>Taxable</th>
                </tr>
                 <?php
				 if(!empty($prodetail)){
					foreach($prodetail as $rows): 
				  ?>
                  <tr>
                   <td><?php echo $rows['product_name'] ?></td> 
                   <td><?php echo $rows['hsn_code'] ?></td> 
                   <td><?php echo $rows['purchase_price'] ?></td> 
                   <td><?php echo $rows['qty'] ?></td> 
                   <td><?php echo number_format($rows['total'],2); ?></td> 
                   <td><?php echo "CGST: ".$rows['cgst_per']."%, SGST: ".$rows['sgst_per']."%" ?></td>
                   <td><?php echo number_format(($rows['cgst_val']+$rows['sgst_val']),2);; ?></td>
                   <td><?php echo number_format($rows['taxable'],2); ?></td> 
                  </tr> 
                  <?php endforeach;} ?>
                </tbody>
              </table>
              <div class="text-right"><a href="#" class="btn btn-danger" onclick="closeView();">Close</a></div>
            </div>
            <!-- /.box-body -->
         