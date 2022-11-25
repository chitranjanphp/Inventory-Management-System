   <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                    <th>Adjustment</th>
                    <th>Paid</th>
                    <th>Dues</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($salecancel)){
						foreach($salecancel as $row){
						$paid=$row['paid']+$row['adj_amount'];
						$dues=$row['total']-($row['paid']+$row['adj_amount']);
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($row['date'])); ?></td>
					<td><?php echo $row['prefix'].$row['invoice_no']; ?></td>
                    <td><?php echo $row['customer_name']; ?></td>
					<td><?php echo $row['mobile']; ?></td>
					<td><?php echo number_format($row['total'],2); ?></td>
                    <td><?php echo number_format($row['adj_amount'],2)."<br>";if($row['adj_amount']!=0){ echo "(".strtoupper($row['adj_invoice']).")";} ?></td>
                    <td><?php echo number_format($paid,2); ?></td>
                    <td><?php echo number_format($dues,2); ?></td>
					<td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $row['invoice_id']; ?>');"><i class="fa fa-eye"></i></button>&nbsp;
                        <a class="btn btn-success btn-sm" href="<?php echo base_url('sale/print_invoice/'.$row['invoice_id']); ?>" target="_blank"><i class="fa fa-print"></i></a>&nbsp;
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
                <tfoot align="right">
                    <tr><th colspan="4" class="text-center"></th><th></th><th></th><th></th><th></th><th></th></tr>
                </tfoot>
 </table>