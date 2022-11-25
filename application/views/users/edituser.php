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
            <?php echo form_open('user/updateuser',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="Name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'name', 'id'=> 'name', 'placeholder'=>'Name', 'class'=>'form-control','value'=>$edituser['name']);
						echo form_input($data); 
						echo form_error('name','<div class="text-danger">','</div>');
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Mobile" class="col-sm-2 control-label">Mobile</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'mobile', 'id'=> 'mobile', 'placeholder'=>'Mobile', 'class'=>'form-control','value'=>$edituser['mobile']);
						echo form_input($data); 
						echo form_error('mobile','<div class="text-danger">','</div>');
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('type'=>'email', 'name' => 'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control','value'=>$edituser['email']);
						echo form_input($data);
						echo form_error('email','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Username" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username', 'class'=>'form-control','value'=>$edituser['username'],'readonly'=>'readonly');
						echo form_input($data); 
						echo form_error('username','<div class="text-danger">','</div>');
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Password" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'password', 'type'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control','value'=>$edituser['password']);
						echo form_input($data);
						echo form_error('password','<div class="text-danger">','</div>'); 
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
						$selected = $shop['id']==$edituser['shop']?'selected':'';
					?>
                     <option value="<?php echo $shop['id']; ?>" <?php echo $selected; ?>><?php echo $shop['shop_name']; ?></option>
                    <?php endforeach; } ?>
                  </select>
                  <?php	echo form_error('shop','<div class="text-danger">','</div>'); ?>
                  </div>
                </div>
                <?php if($edituser['role']!='Admin'){ ?>
                 <div class="form-group">
                    <label for="Status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-6" style="margin-top:5px;">
                      <input type="radio" name="status" id="status" class="flat-red" value="1" <?php if($edituser['status']==1){ echo "checked"; }?>> Active
                      <input type="radio" name="status" id="status" class="flat-red" value="0" <?php if($edituser['status']==0){ echo "checked"; }?>> DeActive
                    </div>
                </div>
                <?php } ?>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <?php 
					$data = array('name' => 'updateuser', 'value'=>'Update', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
                &nbsp;<a href="<?php echo base_url('user/userlist'); ?>" class="btn btn-danger">Close</a>
              </div>
              </div>
              <!-- /.box-body -->
              <?php echo form_hidden("id",$edituser['id']);echo form_close(); ?>
          </div>
        
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
 <!-- /.content -->

