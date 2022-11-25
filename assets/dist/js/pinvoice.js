// JavaScript Document
$(document).ready(function(e) {
   $('.select2').select2()
    $('#example1').DataTable()
	$('#example2').DataTable({
	  'paging'      : true,
	  'lengthChange': false,
	  'searching'   : false,
	  'ordering'    : true,
	  'info'        : true,
	  'autoWidth'   : false
	})
    $('#date').datepicker({
	  format:'dd-mm-yyyy',
      autoclose: true
    })
	GetTempList();
	caculateAmount();
	$("#supp_id").change(function(){
		var supp_id=$(this).val();
		//alert(category_id);
		$.ajax({
		  type:"POST",
		  url: url+'/suppliers/getsinglesupplier',
		  data:{id:supp_id},
		  dataType:'json',
		  success:function(data){
			 //alert(data);
			 if(data!=false){
				$("#suppmobile").val(data['mobile']);
				$("#suppcompany").val(data['company_name']);
				$("#suppaddress").val(data['address']);
			 }else{
				$("#suppmobile").val("");
				$("#suppcompany").val("");
				$("#suppaddress").val(""); 
			 }
		  }
	  });
	});
	
	$("#items").change(function(){
		var barcode=$(this).val();
		//alert(category_id);
		if(barcode!=''){
			$.ajax({
			  type:"POST",
			  url: url+'/products/UOM',
			  data:{barcode:barcode},
			  dataType:'json',
			  success:function(data){
				  //alert(data['unit_name']);
				$("#barcode").val(barcode);
				$("#iunit").val(data['unit_name']); 
				//$("#barcode").attr("readonly","readonly");
			  }
		  });
	  }else{
			$("#barcode").val('');
			$("#iunit").val('');
		}
	});
	$("#barcode").keyup(function(){
		var barcode=$(this).val();
		
		if(barcode!=''){
				$.ajax({
				  type:"POST",
				  url: url+'/products/UOM',
				  data:{barcode:barcode},
				  dataType:'json',
				  success:function(data){
					  $('.select2').select2();
					  //alert(data['unit_name']);
					$("#items").val(barcode);
					$("#iunit").val(data['unit_name']); 
				  }
			  });
		}else{
			    $("#items").val('').trigger('change') ;
				$("#iunit").val('');
			}
	});
	$('#add').on('click',function () {
		//alert($('#temp_input_field input,select,checkbox').serialize());
		
			$.ajax({
				type: 'POST',
				url: url+'/purchase/add_purchase_temp',
				data: $('#temp_input_field input,select,checkbox').serialize(),
				dataType: "json",
				success: function (data) //on recieve of reply
				{
					if($.isEmptyObject(data.error)){
	                	$(".print-error-msg").css('display','none');
						$(".print-success-msg").css('display','block');
						$(".print-success-msg").html(data.success);
						//$("#templist").load(location.href+ " #templist");
						GetTempList();
						caculateAmount();
						SetBlank();
	                }else{
						$(".print-success-msg").css('display','none');
						$(".print-error-msg").css('display','block');
	                	$(".print-error-msg").html(data.error);
	                }
					removeMsg();
				},
				error:function(er){
						$(".print-success-msg").css('display','none');
						$(".print-error-msg").css('display','block');
						$(".print-error-msg").html(er.error);
					   //alert(JSON.stringify(er));
				}
			});	
		/*	
		$("#paid_amount").val("");
		$("#dues_amount").val("");
		$("#barcode").focus();*/
    }); 
	$("#paymode").change(function(){
		var paymode=$(this).val();
		//alert(paymode);
		if(paymode=='Online' || paymode=='Cheque'){
		    $("#modedisp").removeClass('hidden');	
		}else{
			$("#modedisp").addClass('hidden');
		}
	});
});
   function removeMsg(){
	  setTimeout(function() {
			$('.print-success-msg').fadeOut();
		},2000);
		setTimeout(function() {
			$('.print-error-msg').fadeOut();
		},2000);	
	}
	function GetTempList(){
	   	$.ajax({
			  url: url+'/purchase/purchase_temp_list',
			  success:function(data){
				  $(".item_temp_list").html(data); 
				  $('#example1').DataTable();
				 
			  }
		  });
	}
	function SetBlank(){
		$("#barcode").val("");
		$("#items").val('').trigger('change') ;
		$("#quantity").val("");
		$("#iunit").val("");
		$("#pprice").val("");
		$("#sprice").val("");
		$("#cgst").prop("checked", false);
		$('#sgst').prop('checked', false);
	}
	function deleteTemp(id){
		if(confirm('Are you sure want to delete record?')){
		  $.ajax({
				  url: url+'/purchase/delete_temp/'+id,
				  dataType:'json',
				  success:function(data){
					if($.isEmptyObject(data.error)){
							$(".print-error-msg").css('display','none');
							$(".print-success-msg").css('display','block');
							$(".print-success-msg").html(data.success);
							GetTempList();
							caculateAmount();
						}else{
							$(".print-success-msg").css('display','none');
							$(".print-error-msg").css('display','block');
							$(".print-error-msg").html(data.error);
						}
						removeMsg();
					},
					error:function(er){
							$(".print-success-msg").css('display','none');
							$(".print-error-msg").css('display','block');
							$(".print-error-msg").html(er.error);
						   //alert(JSON.stringify(er));
					}
			  });	
		}else{
		  return false;	
		}
	}
	function caculateAmount(){
		$.ajax({
		  url: url+'/purchase/cal_amount_detail',
		  success:function(data){
			  $(".cal_amount_detail").html(data); 
		  }
	  });
	}
	function caculateTotal(disc){
		var net_amount = $("#net_amount").val();
		if(disc!=''){
			if(isNaN(disc)){
				$("#dpercent").val('');
				$("#dvalue").val('');
				$("#total_amount").val('');
			}else{
			  var disc=parseInt(disc);	
			}
			
			var dvalue= parseFloat(net_amount*(disc/100));
			var total_amount= parseFloat(net_amount-dvalue);
			$("#dvalue").val(dvalue.toFixed(2));
			$("#total_amount").val(Math.round(total_amount.toFixed(2)));
		}else{
			$("#dvalue").val('');
			$("#total_amount").val(net_amount);
			$("#paid_amount").val('');
			$("#dues_amount").val('');
		}
	}
	function caculateDues(paid){
		if(paid!=''){
			if(isNaN(paid)){
				$("#paid_amount").val('');
				$("#dues_amount").val('');
			}else{
			  var paid=parseFloat(paid);	
			}
			var total_amount = parseFloat($("#total_amount").val());
			var dues_amount= parseFloat(total_amount-paid);
			$("#dues_amount").val(dues_amount.toFixed(2));
		}else{
			$("#dues_amount").val('');
		}
	}