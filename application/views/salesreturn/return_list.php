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
            var amountTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
            // Update footer by showing the total with the reference of the column index 
	    $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(amountTotal.toFixed(2));
        },
    } );
	searchfields();	
  });
 
  function setView(id){
	  $.ajax({
		  //type:'POST',
		  url: url+'salesreturn/productdetail/'+id,
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
			url:url+'salesreturn/search_return/',
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
						var amountTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
						// Update footer by showing the total with the reference of the column index 
					$( api.column( 0 ).footer() ).html('Total');
						$( api.column( 4 ).footer() ).html(amountTotal.toFixed(2));
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
