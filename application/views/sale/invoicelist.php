 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box list">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="result">
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
            // computing column Page Total of the complete result 
            var saleTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
	        var paidTotal = api.column( 6, {page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
		    var duesTotal = api.column( 7, {page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);	}, 0 );
            // Update footer by showing the total with the reference of the column index 
	    $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(saleTotal.toFixed(2));
            $( api.column( 6 ).footer() ).html(paidTotal.toFixed(2));
            $( api.column( 7 ).footer() ).html(duesTotal.toFixed(2));
        },
    } );
	searchfields();
  });
 
  function cancelInvoice(id){
	  if(confirm('Are you sure want to cancel this invoice?')){
		  $.ajax({
		  //type:'POST',
		  url: url+'sale/cancel_invoice/'+id,
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
		  //type:'POST',
		  url: url+'sale/productdetail/'+id,
		  //data:{id:id},
		  success:function(data){
			 $(".list").addClass('hidden');
	 		 $(".view").removeClass('hidden');
			 $(".view").html(data); 
			 $('#example1').DataTable(); 
		  }
	  });
  }
   /********search***************/	
	function SearchList(){
		var from=$("#from").val();
		var to=$("#to").val();
		$.ajax({
			type:'POST',
			url:url+'sale/search_sale/',
			data:{from:from,to:to},
			success: function(data){
				$('#result').html(data);
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
						// computing column Page Total of the complete result 
						var saleTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
						var paidTotal = api.column( 6, {page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
						var duesTotal = api.column( 7, {page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);	}, 0 );
						// Update footer by showing the total with the reference of the column index 
					$( api.column( 0 ).footer() ).html('Total');
						$( api.column( 4 ).footer() ).html(saleTotal.toFixed(2));
						$( api.column( 6 ).footer() ).html(paidTotal.toFixed(2));
						$( api.column( 7 ).footer() ).html(duesTotal.toFixed(2));
					},
				} );
				searchfields(from,to);
			}
		});
	}
	
	function setEvents(){
		$('#from,#to').change(SearchList);
	}
	function searchfields(from,to){
		
		$('#example1_length').parent().removeAttr("class").addClass("col-md-3 col-sm-6");
		$('#example1_filter').parent().removeAttr("class").addClass("col-md-4 col-sm-8");
		var selectopt="<div class='col-md-2 col-sm-4'>";
		selectopt+="<input type='date' name='from' id='from' class='form-control' value='"+from+"'></div>";
		selectopt+="<span class='col-sm-1' id='totext'><b>To</b></span>";
		selectopt+="<div class='col-md-2 col-sm-4'><input type='date' name='to' id='to' class='form-control' value='"+to+"'></div>";
		$(selectopt).insertAfter($('#example1_length').parent());
		setEvents();
	}
	
/***************end search***********/	
  function closeView(){
	$(".list").removeClass('hidden');
    $(".view").addClass('hidden');  
  }
</script>
