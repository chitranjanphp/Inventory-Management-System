
   <table id="example1" class="table table-bordered table-striped">
        <thead class="bg-primary">
        <tr>
            <th>S.No.</th>
            <th>Product Name</th>
            <th>HSN</th>
            <th>P.QTY</th>
            <th>Price</th>
            <th>R.QTY</th>
            <th>Total</th>
            <th>GST(%)</th>
            <th>Return</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
				<?php
                    if(is_array($srtempdata)){
						$i=0;
                        foreach($srtempdata as $stemp){
                ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $stemp['product_name']; ?></td>
                    <td><?php echo $stemp['hsn_code']; ?></td>
                    <td><?php echo $stemp['pqty']." ".$stemp['units']; ?></td>
                    <td><?php echo $stemp['price']; ?></td>
                    <td><?php echo $stemp['rqty']." ".$stemp['units']; ?></td>
                    <td><?php echo number_format($stemp['total'],2); ?></td>
                    <td><?php echo "CGST: ".$stemp['cgst_per']."%, SGST: ".$stemp['sgst_per']."%"; ?></td>
                    <td><?php echo number_format($stemp['taxable'],2); ?></td>
                    <td>
                        <!--<a class="btn btn-warning btn-sm" href=""><i class="fa fa-pencil"></i> Edit</a>&nbsp;-->
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteTemp('<?php echo $stemp['id']; ?>')"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
        </tbody>
        
  </table>
            