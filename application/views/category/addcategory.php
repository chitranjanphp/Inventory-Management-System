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
            <?php echo form_open('category/addcategory',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="Category Name" class="col-sm-2 control-label">Category Name</label>
                  <div class="col-sm-6">
                    <?php 
						$data = array('name' => 'category', 'id'=> 'category', 'placeholder'=>'Category Name', 'class'=>'form-control','value'=>set_value('category'));
						echo form_input($data);
						echo form_error('category','<div class="text-danger">','</div>'); 
					?>
                  </div>
                </div>
                <div class="box-footer">
                <?php 
					$data = array('name' => 'addcategory', 'value'=>'Submit', 'class'=>'btn btn-info pull-left');
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
