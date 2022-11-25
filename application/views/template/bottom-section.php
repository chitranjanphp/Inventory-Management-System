</div>
<!-- ./wrapper -->
<script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/dist/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<?php
	  if(!empty($bottom_script)){
		  foreach($bottom_script as $key=>$script){
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
</body>
</html>

