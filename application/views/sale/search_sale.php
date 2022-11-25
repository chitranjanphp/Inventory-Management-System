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
					if(is_array($invoices)){
						foreach($invoices as $invoice){
						$paid=$invoice['paid']+$invoice['adj_amount'];
						$dues=$invoice['total']-($invoice['paid']+$invoice['adj_amount']);
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($invoice['date'])); ?></td>
					<td><?php echo $invoice['prefix'].$invoice['invoice_no']; ?></td>
                    <td><?php echo $invoice['customer_name']; ?></td>
					<td><?php echo $invoice['mobile']; ?></td>
					<td><?php echo number_format($invoice['total'],2); ?></td>
                    <td><?php echo number_format($invoice['adj_amount'],2)."<br>";if($invoice['adj_amount']!=0){ echo "(".strtoupper($invoice['adj_invoice']).")";} ?></td>
                    <td><?php echo number_format($paid,2); ?></td>
                    <td><?php echo number_format($dues,2); ?></td>
					<td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $invoice['invoice_id']; ?>');"><i class="fa fa-eye"></i></button>&nbsp;
                        <a class="btn btn-success btn-sm" href="<?php echo base_url('sale/print_invoice/'.$invoice['invoice_id']); ?>" target="_blank"><i class="fa fa-print"></i></a>&nbsp;
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('sale/duepayment/'.$invoice['invoice_id']); ?>"> PayDues</a>&nbsp;
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return cancelInvoice('<?php echo $invoice['invoice_id']; ?>');"><i class="fa fa-times"></i> Invoice</a>
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