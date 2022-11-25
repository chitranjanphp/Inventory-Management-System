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
            <?php echo form_open('expense/updateexpense',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
               <div class="form-group">
                  <label for="Date" class="col-sm-2 control-label">Date</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'date', 'id'=> 'date', 'placeholder'=>'Date', 'class'=>'form-control','autocomplete'=>'off','value'=>date("d-m-Y",strtotime($editexpense['date'])));
						echo form_input($data);
						echo form_error('date','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Bill No." class="col-sm-2 control-label">Bill No.</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'billno', 'id'=> 'billno', 'placeholder'=>'Bill No.', 'class'=>'form-control','autocomplete'=>'off','value'=>$editexpense['billno']);
						echo form_input($data);
						echo form_error('billno','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Amount" class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'amount', 'id'=> 'amount', 'placeholder'=>'Amount', 'class'=>'form-control','autocomplete'=>'off','value'=>$editexpense['amount']);
						echo form_input($data);
						echo form_error('amount','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Particulars" class="col-sm-2 control-label">Particulars</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'particular', 'id'=> 'particular', 'placeholder'=>'Particulars', 'class'=>'form-control','value'=>$editexpense['particular']);
						echo form_textarea($data);
						echo form_error('particular','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <?php 
					$data = array('name' => 'updateexpense', 'value'=>'Submit', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
              </div>
              </div>
              <!-- /.box-body -->
            <?php echo form_hidden("id",$editexpense['id']);echo form_close(); ?>
          </div>
        
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
 <!-- /.content -->
<script>
$(document).ready(function(e) {
    $('#date').datepicker({
	  format:'dd-mm-yyyy',
      autoclose: true
    })
});
</script>
