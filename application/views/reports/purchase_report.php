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
            // computing column Page of the complete result 
            var amountTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
			var paidTotal = api.column( 5, {page: 'current'} ).data().reduce( function (a, b) {	return intVal(a) + intVal(b);}, 0 );
			var duesTotal = api.column( 6, {page: 'current'} ).data().reduce( function (a, b) {	return intVal(a) + intVal(b);}, 0 );
            // Update footer by showing the total with the reference of the column index 
	    $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(amountTotal.toFixed(2));
            $( api.column( 5 ).footer() ).html(paidTotal.toFixed(2));
            $( api.column( 6 ).footer() ).html(duesTotal.toFixed(2));
        },
    } );
	searchfields();	
  });
 
  function setView(id){
	  $.ajax({
		  type:'POST',
		  url:'<?php echo base_url('reports/view_purchase_product'); ?>',
		  data:{id:id},
		  success:function(data){
			 $(".list").addClass('hidden');
	 		 $(".view").removeClass('hidden');
			 $(".view").html(data);  
		  }
	  });
  }
  /********search***************/	
	function SearchList(){
		var suppliers=$("#suppliers").val();
		var from=$("#from").val();
		var to=$("#to").val();
		$.ajax({
			type:'POST',
			url:url+'reports/search_purchase/',
			data:{suppliers:suppliers,from:from,to:to},
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
						// computing column Page of the complete result 
						var amountTotal = api.column( 4,{page: 'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b);}, 0 );
						var paidTotal = api.column( 5, {page: 'current'} ).data().reduce( function (a, b) {	return intVal(a) + intVal(b);}, 0 );
						var duesTotal = api.column( 6, {page: 'current'} ).data().reduce( function (a, b) {	return intVal(a) + intVal(b);}, 0 );
						// Update footer by showing the total with the reference of the column index 
					$( api.column( 0 ).footer() ).html('Total');
						$( api.column( 4 ).footer() ).html(amountTotal.toFixed(2));
						$( api.column( 5 ).footer() ).html(paidTotal.toFixed(2));
						$( api.column( 6 ).footer() ).html(duesTotal.toFixed(2));
					},
				} );
				searchfields(suppliers,from,to);
			}
		});
	}
	
	function setEvents(){
		$('#suppliers,#from,#to').change(SearchList);
	}
	function searchfields(supplier,from,to){
		
		$('#example1_length').parent().removeAttr("class").addClass("col-md-2 col-sm-4");
		$('#example1_filter').parent().removeAttr("class").addClass("col-md-3 col-sm-6");
		var selectopt="<div class='col-md-2 col-sm-4'>";
		selectopt+="<select name='suppliers' id='suppliers' class='form-control'>";
		selectopt+="<option value=''>--Select Supplier--</option>";
		var allsuppliers='<?php echo json_encode($suppliers); ?>';
		allsuppliers=JSON.parse(allsuppliers);
		$.each(allsuppliers, function(i, supps) {
			//alert(states.id);
			selectopt+='<option value="'+supps.supp_id+'">'+supps.supplier_name+'</option>';
		});
		selectopt+="</select></div>";
		selectopt+="<div class='col-md-2 col-sm-4'><input type='date' name='from' id='from' class='form-control' value='"+from+"'></div>";
		selectopt+="<span class='col-sm-1' id='totext'><b>To</b></span>";
		selectopt+="<div class='col-md-2 col-sm-4'><input type='date' name='to' id='to' class='form-control' value='"+to+"'></div>";
		$(selectopt).insertAfter($('#example1_length').parent());
		$('#suppliers').val(supplier);
		setEvents();
	}
	
/***************end search***********/	
  function closeView(){
	$(".list").removeClass('hidden');
    $(".view").addClass('hidden');  
  }
</script>
