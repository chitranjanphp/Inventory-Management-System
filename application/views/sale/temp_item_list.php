
   <table id="example1" class="table table-bordered table-striped">
        <thead class="bg-primary">
        <tr>
            <th>S.No.</th>
            <th>Product Name</th>
            <th>HSN</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Total</th>
            <th>GST(%)</th>
            <th>Taxable</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
				<?php
                    if(is_array($stempdata)){
						$i=0;
                        foreach($stempdata as $stemp){
                ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $stemp['product_name']; ?></td>
                    <td><?php echo $stemp['hsn_code']; ?></td>
                    <td><?php echo $stemp['qty']." ".$stemp['units']; ?></td>
                    <td><?php echo $stemp['price']; ?></td>
                    <td><?php echo number_format($stemp['total'],2); ?></td>
                    <td><?php echo "CGST: ".$stemp['cgst_per']."%, SGST: ".$stemp['sgst_per']."%"; ?></td>
                    <td><?php echo number_format($stemp['taxable'],2); ?></td>
                    <td>
                        <!--<a class="btn btn-warning btn-sm" href=""><i class="fa fa-pencil"></i> Edit</a>&nbsp;-->
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteTemp('<?php echo $stemp['id']; ?>','<?php echo $stemp['product_id']; ?>','<?php echo $stemp['qty']; ?>')"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
        </tbody>
        
  </table>
            