  <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Supplier Name</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Dues</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($purchase)){
						foreach($purchase as $row){
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($row['date'])); ?></td>
					<td><?php echo $row['invoice_no']; ?></td>
                    <td><?php echo $row['supplier_name']; ?></td>
					<td><?php echo $row['mobile']; ?></td>
					<td><?php echo number_format($row['total'],2); ?></td>
                    <td><?php echo number_format($row['paid'],2); ?></td>
                    <td><?php echo number_format($row['total']-$row['paid'],2); ?></td>
					<td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $row['invoice_id']; ?>');"><i class="fa fa-eye"></i> View</button>&nbsp;
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
               <tfoot align="right">
                    <tr><th colspan="4" class="text-center"></th><th></th><th></th><th></th><th></th></tr>
               </tfoot> 
</table>