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
	/**********AutoComplete***********/
	$( "#autocust" ).autocomplete({
      source: function( request, response ) {
       // Fetch data
       $.ajax({
        url: url+"/sale/custList",
        type: 'post',
        dataType: "json",
        data: {
         search: request.term
        },
        success: function( data ) {
         response( data );
		 //alert(JSON.stringify(data));
		 $("#mobile").val('');  
	     $("#to").val('');
        }
       });
      },
      select: function (event, ui) {
       // Set selection
	   var custid=ui.item.value;
	   //alert(custid);
	   if(custid!=''){
	      getCustDetail(custid);
	   }
       $('#autocust').val(ui.item.label); // display the selected text
       $('#custid').val(ui.item.value); // save selected id to input
       return false;
      }
     });
	/**********End AutoComplete***********/ 
	 
	
	$("#items").change(function(){
		var barcode=$(this).val();
		//alert(category_id);
		if(barcode!=''){
			$.ajax({
			  type:"POST",
			  url: url+'/sale/SelProductDetail/'+barcode,
			  //data:{barcode:barcode},
			  dataType:'json',
			  success:function(data){
				  //alert(data['unit_name']);
				$("#barcode").val(barcode);
				$("#iunit").val(data['unit_name']); 
				$("#availqty").val(data['qty']);
				$("#price").val(data['sale_price']);
			  }
		  });
	  }else{
			$("#barcode").val('');
			$("#iunit").val('');
			$("#availqty").val('');
			$("#price").val('');
		}
	});
	$("#barcode").keyup(function(){
		var barcode=$(this).val();
		
		if(barcode!=''){
				$.ajax({
				  type:"POST",
				  url: url+'/sale/SelProductDetail/'+barcode,
				 // data:{barcode:barcode},
				  dataType:'json',
				  success:function(data){
					  $('.select2').select2();
					  //alert(data['unit_name']);
					$("#items").val(barcode);
					$("#availqty").val(data['qty']);
					$("#price").val(data['sale_price']);
					$("#iunit").val(data['unit_name']); 
				  }
			  });
		}else{
			    $("#items").val('').trigger('change') ;
				$("#iunit").val('');
				$("#availqty").val('');
				$("#price").val('');
			}
	});
	$("#qty").keyup(function(){
		var qty=$(this).val();
		var availqty=$("#availqty").val();
		if(isNaN(qty)){
			 $("#qty").val('');
		}else{
		    if(parseInt(qty)>parseInt(availqty)){
			   alert('Quantity is exceeding? Enter less then '+availqty);
			   $("#qty").val('');
			   return false;	
			}else{
			   return true;	
			}
		}
		
	});
	$('#add').on('click',function () {
		//alert($('#temp_input_field input,select,checkbox').serialize());
			$.ajax({
				type: 'POST',
				url: url+'/sale/add_sale_temp',
				data: $('#temp_input_field input,select,checkbox').serialize(),
				dataType: "json",
				success: function (data) //on recieve of reply
				{
					//alert(JSON.stringify(data));
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
	
	$("#paid_amount").keyup(function(){
		var paid_amount=$(this).val();
		//alert(paymode);
		if(isNaN(paid_amount)){
		  $("#paid_amount").val('');	
		}
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
    function getCustDetail(custid){
		$.ajax({
			  url: url+'/sale/getCustDetail/'+custid,
			  dataType:'json',
			  success:function(data){
				$("#mobile").val(data['mobile']);  
				$("#to").val(data['to']);  
			  }
		  });
	}
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
			  url: url+'/sale/sale_temp_list',
			  success:function(data){
				  $(".item_temp_list").html(data); 
				  $('#example1').DataTable();
				 
			  }
		  });
	}
	function SetBlank(){
		$("#barcode").val("");
		$("#items").val('').trigger('change') ;
		$("#availqty").val("");
		$("#iunit").val("");
		$("#price").val("");
		$("#qty").val("");
		$("#cgst").prop("checked", false);
		$('#sgst').prop('checked', false);
	}
	function deleteTemp(id){
		if(confirm('Are you sure want to delete record?')){
		  $.ajax({
				  url: url+'/sale/delete_temp/'+id,
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
		  url: url+'/sale/cal_amount_detail',
		  success:function(data){
			  $(".cal_amount_detail").html(data); 
		  }
	  });
	}
	function AdjustAmount(){
		
        if($("#adjust").prop('checked')) {
            $("#entinvno").removeClass('hidden');
			$("#adjamount").removeClass('hidden');
        } else {
            $("#entinvno").addClass('hidden');
			$("#adjamount").addClass('hidden');
        }
	}
	function getAdjAmount(invoice_no){
		var total_amount=$("#total_amount").val();
		$.ajax({
			  type:"POST",
			  url: url+'sale/get_adjust_amount',
			  data:{invoice_no:invoice_no},
			  dataType:'json',
			  success:function(data){
				 $("#adjust_amount").val(data['total']); 
				 $("#payable").val(total_amount-data['total']);
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
			$("#payable").val(Math.round(total_amount.toFixed(2)));
		}else{
			$("#dvalue").val('');
			$("#total_amount").val(net_amount);
			$("#payable").val(net_amount);
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
			var payable = parseFloat($("#payable").val());
			var dues_amount= parseFloat(payable-paid);
			$("#dues_amount").val(dues_amount.toFixed(2));
		}else{
			$("#dues_amount").val('');
			$("#paymode").val('');
		}
	}