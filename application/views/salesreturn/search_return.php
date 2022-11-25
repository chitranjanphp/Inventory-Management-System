<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($invoices)){
						foreach($invoices as $invoice){
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($invoice['date'])); ?></td>
					<td><?php echo $invoice['invoice_no']; ?></td>
                    <td><?php echo $invoice['customer_name']; ?></td>
					<td><?php echo $invoice['mobile']; ?></td>
					<td><?php echo number_format($invoice['total'],2); ?></td>
					<td>
                        <!--<a class="btn btn-warning btn-sm" href="<?php //echo base_url('purchase/editinvoice/'.$invoice['invoice_id']); ?>"><i class="fa fa-pencil"></i> Edit</a>&nbsp;-->
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $invoice['return_id']; ?>');"><i class="fa fa-eye"></i> View</button>&nbsp;
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
                 <tfoot align="right">
                    <tr><th colspan="4" class="text-center"></th><th></th><th></th></tr>
                </tfoot>
   </table>