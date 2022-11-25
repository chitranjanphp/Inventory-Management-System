 
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    <div class="row profile">
        <div class="col-md-12">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" alt="User profile picture" src="<?php if($this->session->userdata('login_img')!=''){ echo base_url('assets/users/'.$this->session->userdata('login_img'));}else{echo base_url('assets/users/defaultphoto.jpg');} ?>">

              <h3 class="profile-username text-center"><?php echo $this->session->userdata('login_name'); ?></h3>

              <p class="text-muted text-center"><?php echo $this->session->userdata('role'); ?></p>
			  <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Name</b> <a class="pull-right"><?php echo $profile['name']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="pull-right"><?php echo $profile['mobile']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo $profile['email']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?php echo $profile['username']; ?></a>
                </li>
              </ul>
              <a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="setView('<?php echo $profile['id']; ?>');"><b>Update Profile</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row update hidden">
        <div class="col-md-12">
          <!-- Horizontal Form -->
         <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- form start -->
            <?php echo form_open_multipart('profile/updateprofile',array('class'=>'form-horizontal')); ?>
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
                  <label for="Photo" class="col-sm-2 control-label">Photo</label>
                  <div class="col-sm-6">
                    <input class="form-control-file" id="photo" type="file" name="photo" aria-describedby="fileHelp" onChange="readsnap(this,'photopreview')">
                    <small class="form-text text-muted" id="fileHelp">Upload Photo</small>
                  </div>
                </div>
                <div class="form-group">
                <label for="Photo Preview" class="col-sm-2 control-label">Photo Preview</label>
                  <div class="col-md-6">
                  		<img alt="" id="photopreview">
                  </div>
                </div>
                <div class="form-group">
                  <label for="Password" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'password', 'type'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control','value'=>set_value('password'),'autocomplete'=>'off');
						echo form_input($data);
						echo form_error('password','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="box-footer">
                <div class="col-md-2"></div>
                <?php 
					$data = array('name' => 'updateprofile', 'value'=>'Update', 'class'=>'btn btn-info pull-left');
					echo form_submit($data); 
				?>
                &nbsp;&nbsp;<a href="#" class="btn btn-danger" onclick="closeView();">Close</a>
              </div>
              </div>
              <!-- /.box-body -->
            <?php echo form_close(); ?>
          </div>
        
        </div>
        <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
  <script>
  $(document).ready(function () {
		
  });
  function setView(id){
	  $.ajax({
		  //type:'POST',
		  url: url+'/profile/userdetail/'+id,
		  //data:{id:id},
		  dataType:'json',
		  success:function(data){
			 $(".profile").toggleClass('hidden');
	 		 $(".update").toggleClass('hidden');
			 $("#name").val(data['name']); 
			 $("#mobile").val(data['mobile']); 
			 $("#email").val(data['email']);  
			 $("#password").val(data['password']);
		  }
	  });
  }
  function readsnap(input,id) {
			var id="#"+id;
			if (input.files && input.files[0]) {
				var reader = new FileReader();
	
				reader.onload = function (e) {
					$(id)
						.attr('src', e.target.result)
						.width(200).height(200)
				};
	
				reader.readAsDataURL(input.files[0]);
			}
		}
  function closeView(){
	$(".profile").toggleClass('hidden');
    $(".update").toggleClass('hidden');  
  }
</script>