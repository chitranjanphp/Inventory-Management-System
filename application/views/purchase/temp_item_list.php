
   <table id="example1" class="table table-bordered table-striped">
        <thead class="bg-primary">
        <tr>
            <th>S.No.</th>
            <th>Product Name</th>
            <th>HSN</th>
            <th>QTY</th>
            <th>P.Price</th>
            <th>S.Price</th>
            <th>GST(%)</th>
            <th>Total</th>
            <th>Taxable</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
				<?php
                    if(is_array($ptempdata)){
						$i=0;
                        foreach($ptempdata as $ptemp){
                ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $ptemp['product_name']; ?></td>
                    <td><?php echo $ptemp['hsn_code']; ?></td>
                    <td><?php echo $ptemp['qty']." ".$ptemp['units']; ?></td>
                    <td><?php echo $ptemp['purchase_price']; ?></td>
                    <td><?php echo $ptemp['sale_price']; ?></td>
                    <td><?php echo "CGST: ".$ptemp['cgst_per']."%, SGST: ".$ptemp['sgst_per']."%"; ?></td>
                    <td><?php echo number_format($ptemp['total'],2); ?></td>
                    <td><?php echo number_format($ptemp['taxable'],2); ?></td>
                    <td>
                        <!--<a class="btn btn-warning btn-sm" href=""><i class="fa fa-pencil"></i> Edit</a>&nbsp;-->
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteTemp('<?php echo $ptemp['id']; ?>')"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
        </tbody>
        
  </table>
            