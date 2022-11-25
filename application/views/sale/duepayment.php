 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
         <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- form start -->
            <?php echo form_open('sale/paydues',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="Customer Name" class="col-sm-2 control-label">Customer Name</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'cust_name', 'id'=> 'cust_name', 'placeholder'=>'Customer Name', 'class'=>'form-control','value'=>$selinvoice['customer_name'],'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('cust_name','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Mobile" class="col-sm-2 control-label">Mobile</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'mobile', 'id'=> 'mobile', 'placeholder'=>'Mobile', 'class'=>'form-control','value'=>$selinvoice['mobile'],'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('mobile','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Invoice No." class="col-sm-2 control-label">Invoice No.</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'invoice_no', 'id'=> 'invoice_no', 'placeholder'=>'Invoice No.', 'class'=>'form-control','value'=>$selinvoice['prefix'].$selinvoice['invoice_no'],'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('invoice_no','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Total" class="col-sm-2 control-label">Total</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('name' => 'total', 'id'=> 'total', 'placeholder'=>'Total', 'class'=>'form-control','value'=>$selinvoice['total'],'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('total','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="Paid" class="col-sm-2 control-label">Paid</label>
                  <div class="col-sm-6">
                   <?php 
				        $paid=$selinvoice['paid']+$selinvoice['adj_amount'];
						$data = array('name' => 'paid', 'id'=> 'paid', 'placeholder'=>'Paid', 'class'=>'form-control','value'=>$paid,'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('paid','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Dues" class="col-sm-2 control-label">Dues</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('name' => 'dues', 'id'=> 'dues', 'placeholder'=>'Paid', 'class'=>'form-control','value'=>$selinvoice['total']-$paid,'readonly'=>'readonly');
						echo form_input($data);
						echo form_error('dues','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="Date of Payment" class="col-sm-2 control-label">Date of Payment</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('name' => 'dop', 'id'=> 'dop', 'placeholder'=>'Date of payment', 'class'=>'form-control','value'=>set_value('dop'),'autocomplete'=>'off');
						echo form_input($data);
						echo form_error('dop','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Payable Amount" class="col-sm-2 control-label">Payable Amount</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('name' => 'payable', 'id'=> 'payable', 'placeholder'=>'Payable Amount', 'class'=>'form-control','value'=>set_value('payable'));
						echo form_input($data);
						echo form_error('payable','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Payment Mode" class="col-sm-2 control-label">Payment Mode</label>
                  <div class="col-sm-6">
                  <select name="paymode" id="paymode" class="form-control">
                      <option value="">--Select Payment Mode---</option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Online">Online</option>
                    </select>
                   <?php echo form_error('paymode','<div class="text-danger">','</div>'); ?>
                  </div>
                </div>
                <div class="form-group hidden" id="modedisp">
                  <label for="Ref./Cheque No." class="col-sm-2 control-label">Ref./Cheque No.</label>
                  <div class="col-sm-6">
                    <input type="text" name="refno" id="refno" class="form-control">
                   <?php echo form_error('refno','<div class="text-danger">','</div>'); ?>
                  </div>
                </div>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <input type="hidden" name="cust_id" value="<?php echo $selinvoice['cust_id'] ?>" />
                <input type="hidden" name="invoice_id" value="<?php echo $selinvoice['invoice_id'] ?>" />
                <?php 
					$data = array('name' => 'paydues', 'value'=>'Pay Dues', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
                &nbsp;&nbsp;<a href="<?php echo base_url('sale/invoicelist'); ?>" class="btn btn-danger">Close</a>
              </div>
              </div>
              <!-- /.box-body -->
            <?php echo form_close(); ?>
          </div>
        
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
 <!-- /.content -->
<script>
$(document).ready(function(e) {
	 $('#dop').datepicker({
	  format:'dd-mm-yyyy',
      autoclose: true
    })
	$("#paymode").change(function(){
		var paymode=$(this).val();
		//alert(paymode);
		if(paymode=='Online' || paymode=='Cheque'){
		    $("#modedisp").removeClass('hidden');	
		}else{
			$("#modedisp").addClass('hidden');
		}
	});
	$("#payable").keyup(function(){
		var payable=$(this).val();
		if(isNaN(payable)){
		  $("#payable").val('');	
		}
		var total=$("#total").val();
		var paid=$("#paid").val();
		if((parseFloat(payable)+parseFloat(paid))>parseFloat(total))
		{
			$("#payable").val('');
		}
	});
});
</script>