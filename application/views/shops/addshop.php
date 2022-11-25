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
            <?php echo form_open('shops/addshop',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="Shop Name" class="col-sm-2 control-label">Shop Name</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'shop_name', 'id'=> 'shop_name', 'placeholder'=>'Shop Name', 'class'=>'form-control','value'=>set_value('shop_name'));
						echo form_input($data);
						echo form_error('shop_name','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Mobile" class="col-sm-2 control-label">Mobile</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'mobile', 'id'=> 'mobile', 'placeholder'=>'Mobile', 'class'=>'form-control','value'=>set_value('mobile'));
						echo form_input($data);
						echo form_error('mobile','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('type'=>'email', 'name' => 'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control','value'=>set_value('email'));
						echo form_input($data);
						echo form_error('email','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Address" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'address', 'id'=> 'address', 'placeholder'=>'Address', 'class'=>'form-control','value'=>set_value('address'));
						echo form_textarea($data);
						echo form_error('address','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="GSTIN" class="col-sm-2 control-label">GSTIN</label>
                  <div class="col-sm-6">
                   <?php 
						$data = array('name' => 'gstin', 'id'=> 'gstin', 'placeholder'=>'GSTIN', 'class'=>'form-control','value'=>set_value('gstin'));
						echo form_input($data);
						echo form_error('gstin','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <?php 
					$data = array('name' => 'addshop', 'value'=>'Submit', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
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
