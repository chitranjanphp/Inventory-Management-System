	
   <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard/'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo $this->session->userdata('acronym'); ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $this->session->userdata('shop_name'); ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php if($this->session->userdata('login_img')!=''){ echo base_url('assets/users/'.$this->session->userdata('login_img'));}else{echo base_url('assets/users/defaultphoto.jpg');} ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('login_name'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php if($this->session->userdata('login_img')!=''){ echo base_url('assets/users/'.$this->session->userdata('login_img'));}else{echo base_url('assets/users/defaultphoto.jpg');} ?>" class="img-circle" alt="User Image">

                <p>
                 <?php echo $this->session->userdata('login_name'); ?>
                  <small>Member since April. 2019</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('home/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <?php
	  $msg="";
	  if($this->session->flashdata("msg")!==NULL){
		  $msg=$this->session->flashdata("msg");
		  $atype="alert-success";
		  $checktype="fa-check";
	  }
	  if($this->session->flashdata("err_msg")!==NULL){
		  $msg=$this->session->flashdata("err_msg");
		  $atype="alert-danger";
		  $checktype="fa-exclamation";
	  }
	  if($msg!=''){
  ?>	
<div class="alert alert-dismissible msg-popup <?php echo $atype; ?>">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<i class="icon fa <?php echo $checktype; ?>"> <?php echo $msg; ?></i>
</div>
<?php } ?>
 