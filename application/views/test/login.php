<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign Up</title>
        <style>
        	ul{
				list-style:none;
			}
			ul li{
				margin:2px;
			}
			ul li label{
				float:left;
				width:150px;
				font-size:16px;
			}
        </style>
    </head>
    
    <body>
    	<?php
        	echo form_open('welcome/validatelogin', 'id="myform"');
		?>
        <ul>
        	<li>
            	<label for="">Username or Mobile : </label>
            	<?php 
					$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username or Mobile');
					echo form_input($data); 
				?>
            </li>
        	<li>
            	<label for="">Password : </label>
            	<?php 
					$data = array('type'=>'password', 'name' => 'password', 'id'=> 'password');
					echo form_input($data); 
				?>
            </li>
            <li>
            	<?php echo form_submit('login', 'Login!'); ?>
            </li>
        </ul>
        <?php
        	echo form_close();
		?>
    </body>
</html>