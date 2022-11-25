<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css'); ?>">
  <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js'); ?>"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
 <div class="login-box">
   	<div class="login-logo">
    	<a href="<?php echo base_url('home/'); ?>"><b>Inventory</b></a>
  	</div>
 	 <!-- /.login-logo -->
    <div class="login-box-body">
    <p class="login-box-msg">Username: admin, Password: 12345</p>
    <p class="login-box-msg">Sign in to start your session</p>

	<?php echo form_open('home/validatelogin', 'id="myform"'); ?>
      <div class="form-group has-feedback">
        <?php 
			$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username', 'class'=>'form-control', 'required'=>'true');
			echo form_input($data); 
		?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
       <?php 
			$data = array('type'=>'password', 'name' => 'password', 'id'=> 'password', 'class'=>'form-control', 'placeholder'=>'Password', 'required'=>'true');
			echo form_input($data); 
		?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
           <?php echo form_submit('login', 'Login!', array('class'=>'btn btn-primary btn-block btn-flat')); ?>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-xs-8">
        <?php
			if($this->session->flashdata('msg')!==NULL){
				echo "<div class='text-left text-danger'>".$this->session->flashdata('msg')."</div>";
			}
		 ?>
          </div>
       </div> 
   <?php echo form_close(); ?>
    <a href="#">I forgot my password</a><br>
  </div>
 </div>
<!-- /.login-box --> 
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
<?php /*	<div class="login-wrap customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">
		<div class="login-box bg-white box-shadow pd-30 border-radius-5">
			<img src="<?php echo base_url('assets/images/login-img.png'); ?>" alt="login" class="login-img">
			<h2 class="text-center mb-30">Login</h2>
				<?php
                    echo form_open('home/validatelogin', 'id="myform"');
                ?>
				<div class="input-group custom input-group-lg">
					<?php 
						$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username', 'class'=>'form-control', 'required'=>'true');
						echo form_input($data); 
					?>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="input-group custom input-group-lg">
					<?php 
						$data = array('type'=>'password', 'name' => 'password', 'id'=> 'password', 'class'=>'form-control', 'placeholder'=>'Password', 'required'=>'true');
						echo form_input($data); 
					?>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
					</div>
				</div>
                <?php
					if($this->session->flashdata('msg')!==NULL){
						echo "<div class='text-center text-danger'>".$this->session->flashdata('msg')."</div>";
					}
                ?>
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group">
                            <?php echo form_submit('login', 'Login!', array('class'=>'btn btn-outline-primary btn-lg btn-block')); ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="forgot-password padding-top-10"><a href="forgot-password.php">Forgot Password</a></div>
					</div>
				</div>
			</form>
		</div>
	</div>  */?>
	