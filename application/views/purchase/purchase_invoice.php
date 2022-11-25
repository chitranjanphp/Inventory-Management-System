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
            <form action="<?php echo base_url('purchase/add_purchase'); ?>" method="post">
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
                              <option value="Retail">Reatil Invoice</option>
                              <option value="Tax" selected="selected">Tax Invoice</option>
                            </select>
                            <?php echo form_error("billing_mode","<span class='text-danger'>","</span>"); ?>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Supplier</label>
                            <select class="form-control select2" style="width: 100%;" name="supp_id" id="supp_id">
                            <option value="">--Select Supplier--</option>
                             <?php 
							 if(!empty($suppliers))
							 foreach($suppliers as $supp):
							  ?>
                              <option value="<?php echo $supp['supp_id'] ?>"><?php echo $supp['supplier_name'] ?></option>
                            <?php
							endforeach;
							?>  
                            </select>
                            <?php echo form_error("supp_id","<span class='text-danger'>","</span>"); ?>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="Invoice No.">Invoice No.</label>
                          <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No." autocomplete="off">
                          <?php echo form_error("invoice_no","<span class='text-danger'>","</span>"); ?>
                        </div>
                    </div>
              </div>  
                <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="Mobile No.">Mobile No.</label>
                          <input type="text" class="form-control" id="suppmobile" name="suppmobile" placeholder="Mobile No." readonly="readonly">
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label for="Company/Shop Name">Company/Shop Name</label>
                          <input type="text" class="form-control" id="suppcompany" name="suppcompany" placeholder="Company/Shop Name" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-md-3">
                         <!-- Date -->
              			<div class="form-group">
                            <label>Address </label>
                           <?php 
								$data = array('name' => 'suppaddress', 'id'=> 'suppaddress', 'placeholder'=>'Company/Shop Address', 'class'=>'form-control','value'=>set_value('suppaddress'),'readonly'=>'readonly');
								echo form_textarea($data);
								echo form_error('suppaddress','<div class="text-danger">','</div>'); 
							?>
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
                        	<th width="10%" style="text-align:center">Quantity</th>
                            <th width="1%"></th>
                            <th width="10%" style="text-align:center">Unit</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Purchase Price</th>
                            <th width="1%"></th>
                        	<th width="10%" style="text-align:center">Sale Price</th>
                            <th width="1%"></th>
                        	<th width="10%">GST Rate</th>
                            <th width="1%"></th>
                        	<th width="15%"></th>
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
                            	<input type="text" name="quantity" id="quantity" class="form-control" autocomplete="off">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="iunit" id="iunit" class="form-control" autocomplete="off" readonly="readonly">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="pprice" id="pprice" class="form-control" placeholder="Per Product Price" autocomplete="off">
                            </td>
                            <td></td>
                        	<td>
                            	<input type="text" name="sprice" id="sprice" class="form-control" placeholder="Per Product Price" autocomplete="off">
                            </td>
                            <td></td>
                            <td>
                                 <label class="checkbox-inline">
                                  <input type="checkbox"  name="cgst" id="cgst">CGST
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="sgst" id="sgst">SGST
                                </label>
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
                	<div class="row">
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                   <td width="40%"><b>Paid Amount :</b></td>
                                   <td width="60%">
                                    <input type="text" name="paid_amount" onkeyup="caculateDues(this.value);" id="paid_amount" autocomplete="off" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                   <td width="40%"><b>Payment Mode :</b></td>
                                   <td width="60%">
                                    <select name="paymode" id="paymode" class="form-control">
                                      <option value="">--Select Payment Mode---</option>
                                      <option value="Cash">Cash</option>
                                      <option value="Cheque">Cheque</option>
                                      <option value="Online">Online</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr class="hidden" id="modedisp">
                                  <td><b>Ref./Cheque No. :</b></td>
                                  <td>
                                    <input type="text" name="refno" id="refno" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                  <td><b>Dues Amount :</b></td>
                                  <td>
                                    <input type="text" name="dues_amount" id="dues_amount" class="form-control" readonly="readonly">
                                  </td>
                                </tr>
                                <!--<tr>
                                  <td><b>Next Payment :</b></td>
                                  <td>
                                    <input type="date" name="next_payment" id="next_payment" class="form-control">
                                 </td>
                               </tr>-->
                            </tbody></table>
                        </div>
                    </div><!--end of payment table row 2 -->
                    <div class="box-footer text-center">
					<?php 
                        $data = array('name' => 'saveinvoice', 'value'=>'Save Invoice', 'class'=>'btn btn-success');
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
