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
					if(is_array($shopsale)){
						foreach($shopsale as $row){
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
  function setView(id){
	  $.ajax({
		  //type:'POST',
		  url: url+'reports/view_sale_product/'+id,
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
		var shops=$("#shops").val();
		var from=$("#from").val();
		var to=$("#to").val();
		$.ajax({
			type:'POST',
			url:url+'reports/search_sale/',
			data:{shops:shops,from:from,to:to},
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
				searchfields(shops,from,to);
			}
		});
	}
	
	function setEvents(){
		$('#shops,#from,#to').change(SearchList);
	}
	function searchfields(shop,from,to){
		
		$('#example1_length').parent().removeAttr("class").addClass("col-md-2 col-sm-4");
		$('#example1_filter').parent().removeAttr("class").addClass("col-md-3 col-sm-6");
		var selectopt="<div class='col-md-2 col-sm-4'>";
		selectopt+="<select name='shops' id='shops' class='form-control'>";
		selectopt+="<option value=''>--Select Shop--</option>";
		var allshops='<?php echo json_encode($shops); ?>';
		allshops=JSON.parse(allshops);
		$.each(allshops, function(i, shopss) {
			//alert(states.id);
			selectopt+='<option value="'+shopss.id+'">'+shopss.shop_name+'</option>';
		});
		selectopt+="</select></div>";
		selectopt+="<div class='col-md-2 col-sm-4'><input type='date' name='from' id='from' class='form-control' value='"+from+"'></div>";
		selectopt+="<span class='col-sm-1' id='totext'><b>To</b></span>";
		selectopt+="<div class='col-md-2 col-sm-4'><input type='date' name='to' id='to' class='form-control' value='"+to+"'></div>";
		$(selectopt).insertAfter($('#example1_length').parent());
		$('#shops').val(shop);
		setEvents();
	}
	
/***************end search***********/	
  
  function closeView(){
	$(".list").removeClass('hidden');
    $(".view").addClass('hidden');  
  }
</script>
