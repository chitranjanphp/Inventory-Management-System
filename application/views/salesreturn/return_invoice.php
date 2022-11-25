  <!-- Main content -->
    <section class="content">
      <div class="row">
       	 <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo base_url('salesreturn/add_sales_return'); ?>" method="post">
              <div class="box-body">
              <?php //print_r($shopdetail); ?>
                <div class="row">
                    <div class="col-md-3">
                         <!-- Date -->
              			<div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" name="date" id="date" autocomplete="off">
                              <?php echo form_error("date","<span class='text-danger'>","</span>"); ?>
                            </div>
                            <!-- /.input group -->
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Billing Mode</label>
                            <select class="form-control select2" name="billing_mode" id="billing_mode" style="width: 100%;">
                              <option value="Return" selected="selected">Return Invoice</option>
                            </select>
                            <?php echo form_error("billing_mode","<span class='text-danger'>","</span>"); ?>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                           <label>Customer</label>
                            <input type="text" id="autocust" name="autocust" class="form-control">
                            <input type="hidden" id="custid" value='0' name="custid" >
                            <?php echo form_error("autocust","<span class='text-danger'>","</span>"); ?>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="Invoice No.">Mobile No.</label>
                          <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile No." autocomplete="off">
                          <?php echo form_error("mobile","<span class='text-danger'>","</span>"); ?>
                        </div>
                    </div>
              </div>  
                <div class="row">
                    <div class="col-md-3">
                         <!-- Date -->
              			<div class="form-group">
                            <label>From </label>
                             <?php 
						        $fromdata = $froms['shop_name']."\nMobile: ".$froms['mobile']."\nEmail: ".$froms['email']."\nAddress: ".$froms['address']."\nGSTIN: ".$froms['gstin'];
							  ?>
                              <textarea name="from" id="from" class="form-control" readonly="readonly" style="min-height:110px;"><?php echo $fromdata; ?></textarea>
                             <?php 
								echo form_error('from','<div class="text-danger">','</div>'); 
							  ?>
                        </div>    
                    </div>
                    <div class="col-md-3">
                         <!-- Date -->
              			<div class="form-group">
                            <label>Customer Address </label>
                           <?php 
						        //$fromdata = $froms['shop_name']."\nMobile: ".$froms['mobile']."\nEmail: ".$froms['email']."\nAddress: ".$froms['address']."\nGSTIN: ".$froms['gstin'];
							  ?>
                              <textarea name="to" id="to" class="form-control" style="min-height:110px;" placeholder="Customer Address"></textarea>
                             <?php 
								echo form_error('to','<div class="text-danger">','</div>'); 
							  ?>
                        </div>    
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                          <label for="Invoice No.">Invoice No.</label>
                          <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No." autocomplete="off">
                          <input type="hidden" class="form-control" name="invoice_id" id="invoice_id" value="" />
                          <?php echo form_error("invoice_no","<span class='text-danger'>","</span>"); ?>
                        </div>
                    </div>
              </div>
              </div>
              <!-- /.box-body -->
              <div class="row">
              <div class="col-lg-12 table-responsive">
              <div class="alert alert-danger print-error-msg" style="display:none"></div>
              <div class="alert alert-success print-success-msg" style="display:none"></div>
            	<div id="temp_input_field">
                	<table style="margin-left:20px">
                    	<tbody><tr>
                        	<th width="10%" style="text-align:center">Barcode</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Item</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Purchase(Qty)</th>
                            <th width="1%"></th>
                            <th width="10%" style="text-align:center">Unit</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Price</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Return(QTY)</th>
                            <th width="1%"></th>
                        	<th width="10%"></th>
                        </tr>
                    	<tr>
                        	<td>
                            	<input type="text" name="barcode" id="barcode" class="form-control" autocomplete="off">
                            </td>
                            <td></td>
                        	<td>
                            	<select class="form-control select2" style="width: 100%;" name="items" id="items">
                                <option value="">--Select Item--</option>
                                 <?php 
                                 if(!empty($items))
                                 foreach($items as $item):
                                  ?>
                                  <option value="<?php echo $item['barcode'] ?>"><?php echo $item['product_name'] ?></option>
                                <?php
                                endforeach;
                                ?>  
                               </select>
                                <!--<div id="suggesstion-box"></div>-->
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="pqty" id="pqty" class="form-control" placeholder="Purchase(Qty)" autocomplete="off" readonly="readonly">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="iunit" id="iunit" class="form-control" placeholder="Units" autocomplete="off" readonly="readonly">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="price" id="price" class="form-control" placeholder="Price" autocomplete="off" readonly="readonly">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="rqty" id="rqty" class="form-control" placeholder="Return(QTY)" autocomplete="off">
                            </td>
                            <td></td>
                        	<td>
                                 <!--onclick="return validateAdd();"-->
                            	<input type="button" name="add" id="add" value="Add" class="btn btn-primary" style="width:100px;">&nbsp;&nbsp;
            					<!--<input type="submit" name="save" onclick="return validatePrint()" value="Save &amp; Print" class="btn btn-success">-->
                            </td>
                        </tr>
                    </tbody>
                   </table>
                </div>
               </div> 
              </div>
			  <div class="row">
              <br />
            	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                	<div class="table-responsive item_temp_list">
                    	
                    </div><!-- end of table div-->
                </div><!--end of invoice table  -->
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                	<div class="row">
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 table-responsive cal_amount_detail">
                           
                        </div>
                    </div><!--end of payment table row 1  -->
                    <div class="box-footer text-center">
					<?php 
                        $data = array('name' => 'saveinvoice', 'value'=>'Submit & Print', 'class'=>'btn btn-success');
                        echo form_submit($data); 
                    ?>
                  </div>
                </div><!--end of payment section  -->
                
            </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
