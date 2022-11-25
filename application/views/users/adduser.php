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
            <?php echo form_open('user/adduser',array('class'=>'form-horizontal')); ?>
              <div class="box-body">  
                <div class="form-group">
                  <label for="Name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'name', 'id'=> 'name', 'placeholder'=>'Name', 'class'=>'form-control','value'=>set_value('name'));
						echo form_input($data); 
						echo form_error('name','<div class="text-danger">','</div>');
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
                  <label for="Username" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username', 'class'=>'form-control','value'=>set_value('username'));
						echo form_input($data); 
						echo form_error('username','<div class="text-danger">','</div>');
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Password" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'password', 'type'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control','value'=>set_value('password'));
						echo form_input($data);
						echo form_error('password','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Confirmed Password" class="col-sm-2 control-label">Confirmed Password</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'cpassword', 'type'=>'password', 'id'=> 'cpassword', 'placeholder'=>'Confirmed Password', 'class'=>'form-control','value'=>set_value('cpassword'));
						echo form_input($data);
						echo form_error('cpassword','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Shop" class="col-sm-2 control-label">Shop</label>
                  <div class="col-sm-6">
                  <select name="shop" id="shop" class="form-control">
                    <option value="">--Select Shop--</option>
                    <?php 
					if(!empty($shops)){
						foreach($shops as $shop):
						$selected = $shop['id']==set_value('shop')?'selected':'';
					?>
                     <option value="<?php echo $shop['id']; ?>" <?php echo $selected; ?>><?php echo $shop['shop_name']; ?></option>
                    <?php endforeach; } ?>
                  </select>
                  <?php	echo form_error('shop','<div class="text-danger">','</div>'); ?>
                  </div>
                </div>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <?php 
					$data = array('name' => 'adduser', 'value'=>'Submit', 'class'=>'btn btn-info pull-left');
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
