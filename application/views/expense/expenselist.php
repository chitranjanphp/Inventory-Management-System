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
                    <th>Bill No.</th>
                    <th>Amount</th>
                    <th>Particular</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($expenses)){
						foreach($expenses as $row){
				?>
				<tr>
					<td><?php echo date("d-m-Y",strtotime($row['date'])); ?></td>
					<td><?php echo $row['billno']; ?></td>
					<td><?php echo number_format($row['amount'],2); ?></td>
					<td><?php echo $row['particular']; ?></td>
					<td>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('expense/editexpense/'.$row['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url('expense/deleteexpense/'.$row['id']); ?>" onclick="return delConfirm();"><i class="fa fa-trash"></i> Delete</a>
					</td>
				</tr>
				<?php
						}
					}
				?>
                </tbody>
               <tfoot align="right">
                    <tr><th colspan="2" class="text-center"></th><th></th><th></th></tr>
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
            var Total = api.column( 2,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
	    $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 2 ).footer() ).html(Total.toFixed(2));
           
        },
    } );
	searchfields();	
  });
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
		  url:'<?php echo base_url('shops/shopdetail'); ?>',
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
		var from=$("#from").val();
		var to=$("#to").val();
		$.ajax({
			type:'POST',
			url:url+'expense/search_expense/',
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
						var Total = api.column( 2,{page: 'current'} ).data().reduce( function (a, b) {  return intVal(a) + intVal(b); }, 0 );
					$( api.column( 0 ).footer() ).html('Total');
						$( api.column( 2 ).footer() ).html(Total.toFixed(2));
					   
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
