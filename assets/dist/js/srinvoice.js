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
        url: url+"sale/custList",
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
	 
	$("#invoice_no").keyup(function(){
		var invoice_no=$(this).val();
		//alert(invoice_no);
		if(invoice_no!=''){
			$.ajax({
			  type:"POST",
			  url: url+'salesreturn/SaleInvoiceIdByInvoiceNo/',
			  data:{invoice_no:invoice_no},
			  dataType:'json',
			  success:function(data){
				
			    $("#invoice_id").val(data['invoice_id']);
				
			  }
		  });
		}else{
			$("#invoice_id").val('');
		}
	});
	$("#items").change(function(){
		var barcode=$(this).val();
		var invoice_id=$("#invoice_id").val();
		    
			if(barcode!='' && invoice_id!=''){
				$.ajax({
				  type:"POST",
				  url: url+'salesreturn/SaleProductDetail/',
				  data:{barcode:barcode,invoice_id:invoice_id},
				  dataType:'json',
				  success:function(data){
					 // alert(data);
					$("#barcode").val(barcode);
					$("#iunit").val(data['units']); 
					$("#pqty").val(data['qty']);
					$("#price").val(data['price']);
				  },
				  /*error:function(er){
					   alert(JSON.stringify(er));
				  }*/
			  });
		  }else{
				$("#barcode").val('');
				$("#iunit").val('');
				$("#pqty").val('');
				$("#price").val('');
			}
		//$("#invoice_no").focus();	
	});
	$("#barcode").keyup(function(){
		var barcode=$(this).val();
		var invoice_id=$("#invoice_id").val();
		  if(barcode!='' && invoice_id!=''){
				$.ajax({
				  type:"POST",
				  url: url+'salesreturn/SaleProductDetail/',
				  data:{barcode:barcode,invoice_id:invoice_id},
				  dataType:'json',
				  success:function(data){
					  $('.select2').select2();
					  //alert(data['unit_name']);
					$("#items").val(barcode);
					$("#pqty").val(data['qty']);
					$("#price").val(data['price']);
					$("#iunit").val(data['units']); 
				  }
			  });
		  }else{
			    $("#items").val('').trigger('change') ;
				$("#iunit").val('');
				$("#pqty").val('');
				$("#price").val('');
			}
		//$("#invoice_no").focus();	
	});
	$("#rqty").keyup(function(){
		var rqty=$(this).val();
		var pqty=$("#pqty").val();
		if(isNaN(rqty)){
			 $("#rqty").val('');
		}else{
		    if(parseInt(rqty)>parseInt(pqty)){
			   alert('Return QTY should be less than or equal to Purchase QTY!');
			   $("#rqty").val('');
			   return false;	
			}else{
			   return true;	
			}
		}
		
	});
	$('#add').on('click',function () {
		//alert($('#temp_input_field input,select,checkbox').serialize());
		    var invoice_id = $("#invoice_id").val();
			if(invoice_id==''){
				alert('Enter invoice no.!');
				$("#invoice_no").focus();
				$("#items").val('').trigger('change') ;
				return false;
			}
			$.ajax({
				type: 'POST',
				url: url+'salesreturn/sales_return_temp/'+invoice_id,
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
	
});
    function getCustDetail(custid){
		$.ajax({
			  url: url+'sale/getCustDetail/'+custid,
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
			  url: url+'salesreturn/return_temp_list',
			  success:function(data){
				  $(".item_temp_list").html(data); 
				  $('#example1').DataTable();
				 
			  }
		  });
	}
	function SetBlank(){
		$("#barcode").val("");
		$("#items").val('').trigger('change') ;
		$("#pqty").val("");
		$("#iunit").val("");
		$("#price").val("");
		$("#rqty").val("");
	}
	function deleteTemp(id){
		if(confirm('Are you sure want to delete record?')){
		  $.ajax({
				  url: url+'salesreturn/delete_temp/'+id,
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
		  url: url+'salesreturn/cal_amount_detail',
		  success:function(data){
			  $(".cal_amount_detail").html(data); 
		  }
	  });
	}
	