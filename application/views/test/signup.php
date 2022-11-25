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
        	echo form_open('welcome/register', 'id="myform"');
		?>
        <ul>
        	<li>
            	<label for="">Username : </label>
            	<?php 
					$data = array('name' => 'username', 'id'=> 'username', 'placeholder'=>'Username');
					echo form_input($data); 
				?>
            </li>
        	<li>
            	<label for="">Mobile : </label>
            	<?php 
					$data = array('name' => 'mobile', 'id'=> 'mobile', 'placeholder'=>'Mobile', 'maxlength'=>'10');
					echo form_input($data); 
				?>
            </li>
        	<li>
            	<label for="">Name : </label>
            	<?php 
					$data = array('name' => 'name', 'id'=> 'name', 'placeholder'=>'Name');
					echo form_input($data); 
				?>
            </li>
        	<li>
            	<label for="">Email : </label>
            	<?php 
					$data = array('type'=>'email', 'name' => 'email', 'id'=> 'email', 'placeholder'=>'Email');
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
            	<?php echo form_submit('signup', 'Signup!'); ?>
            </li>
        </ul>
        <?php
        	echo form_close();
		?>
    </body>
</html>