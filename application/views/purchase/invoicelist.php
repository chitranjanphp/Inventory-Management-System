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
					if(is_array($invoices)){
						foreach($invoices as $invoice){
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($invoice['date'])); ?></td>
					<td><?php echo $invoice['invoice_no']; ?></td>
                    <td><?php echo $invoice['supplier_name']; ?></td>
					<td><?php echo $invoice['mobile']; ?></td>
					<td><?php echo number_format($invoice['total'],2); ?></td>
                    <td><?php echo number_format($invoice['paid'],2); ?></td>
                    <td><?php echo number_format($invoice['total']-$invoice['paid'],2); ?></td>
					<td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="setView('<?php echo $invoice['invoice_id']; ?>');"><i class="fa fa-eye"></i> View</button>&nbsp;
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('purchase/duepayment/'.$invoice['invoice_id']); ?>"> Pay Dues</a>&nbsp;
                        <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="return cancelInvoice('<?php echo $invoice['invoice_id']; ?>');"><i class="fa fa-times"></i> Invoice</a>
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
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div class="box view hidden">
            
          </div>    
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  <!-- /.content -->
<script>
  $(document).ready(function () {
		$('#example1').DataTable({
    	"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var amountTotal = api
                .column( 4,{page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
			var paidTotal = api
				.column( 5, {page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
			var duesTotal = api
				.column( 6, {page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
				
            // Update footer by showing the total with the reference of the column index 
	    $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(amountTotal.toFixed(2));
            $( api.column( 5 ).footer() ).html(paidTotal.toFixed(2));
            $( api.column( 6 ).footer() ).html(duesTotal.toFixed(2));
        },
        //"processing": true,
       // "serverSide": true,
       // "ajax": "server.php"
    } );
  });
  function cancelInvoice(id){
	  if(confirm('Are you sure want to cancel this invoice?')){
		  $.ajax({
		  //type:'POST',
		  url:'<?php echo base_url('purchase/cancel_invoice/'); ?>'+id,
		 // data:{id:id},
		  success:function(data){
			 location.reload();
		  }
	  });
	  }else{
		return false;  
	  }
  }
  function delConfirm(){
	  if(confirm('Are you sure want to delete?')){
		 return true;
	  }else{
		return false;  
	  }
  }
  function setView(id){
	  $.ajax({
		  type:'POST',
		  url:'<?php echo base_url('purchase/productdetail'); ?>',
		  data:{id:id},
		  success:function(data){
			 $(".list").addClass('hidden');
	 		 $(".view").removeClass('hidden');
			 $(".view").html(data);  
		  }
	  });
  }
  function closeView(){
	$(".list").removeClass('hidden');
    $(".view").addClass('hidden');  
  }
</script>
