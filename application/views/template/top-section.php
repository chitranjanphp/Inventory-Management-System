<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inventory || <?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- date picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>">
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/dist/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery/jquery-ui.css'); ?>">
  <?php
		if(!empty($styles)){
			foreach($styles as $key=>$style){
				if($key=="link"){
					if(is_array($style)){
						foreach($style as $single_style){
							echo "<link rel='stylesheet' href='$single_style'>";
						}
					}
					else{
						echo "<link rel='stylesheet' href='$style'>";
					}
				}
				elseif($key=="file"){
					if(is_array($style)){
						foreach($style as $single_style){
							echo "<link rel='stylesheet' href='".base_url("$single_style")."'>";
						}
					}
					else{
						echo "<link rel='stylesheet' href='".base_url("$style")."'>";
					}
				}
			}
		}
	?>

  <!-- Google Font -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/custom.css'); ?>">
    <!-- Javascript -->
    <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/dist/js/custom.js'); ?>"></script>
   <?php
		if(!empty($top_script)){
			foreach($top_script as $key=>$script){
				if($key=="link"){
					if(is_array($script)){
						foreach($script as $single_script){
							echo "<script src='$single_script'></script>";
						}
					}
					else{
						echo "<script src='$script'></script>";
					}
				}
				elseif($key=="file"){
					if(is_array($script)){
						foreach($script as $single_script){
							echo "<script src='".base_url("$single_script")."'></script>";
						}
					}
					else{
						echo "<script src='".base_url("$script")."'></script>";
					}
				}
			}
		}
	?>
    <script>
	  var url='<?php echo base_url(); ?>';
	</script>
</head>
<body class="sidebar-mini wysihtml5-supported skin-blue">
<div class="wrapper">
