
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="UTF-8">
        <title>Invoice</title>
        <style type="text/css" media="print">
			@page {
					margin:0 10px;
					/*size:8.27in 11.69in ;
					/*height:3508 px;
					width:2480 px;
					/*size: auto;   auto is the initial value */
					/*margin:0;   this affects the margin in the printer settings 
			  		-webkit-print-color-adjust:exact;*/
			}
			@media print{
				table {page-break-inside: avoid;}
				#buttons{
						display:none;
				}
				#invoice{
					margin-top:20px;
  				}
			}
		</style>
    </head>
    
    <body>
    	<div id="invoice" style="width:1000px;">
            <center>
                <font size="+1" style="border:1px solid #000000; padding:5px;"></font><br /><br>
                <font size="+3" style="letter-spacing:2px">SHREE BALAJI ENTERPRISES<br /></font>
                <font size="+1">Behind of Dulari Petrol Pump, Harmu Bypass<br />
                Harmu, Ranchi<br />
                Ph : <br />
                GSTIN - 20EWKPS4878E1Z6                </font><br />
            </center>
            <hr style="border:1px solid #000000;" />
            <table align="center" width="95%">
            	<tr>
                    <th align="left" width="18%">Invoice No</th>
                    <td align="left" width="34%"></td>
                    <td align="left" width="13%"></td>
                    <th align="left" width="18%">Date</th>
                    <td align="left" width="17%">01-01-1970</td>
                </tr>
                <tr>
                    <th align="left">Name</th>
                    <td align="left"></td>
                    <td align="left"></td>
                    <th align="left">Phone</th>
                    <td align="left"></td>
                </tr>
                <tr>
                    <th align="left">Address</th>
                    <td align="left" colspan="2" style="font-size:15px; padding-right:10px;"><br />State :  State Code : </td>
                    <th align="left">GSTIN</th>
                    <td align="left"></td>
                </tr>
                <tr>
                    <th align="left">Reverse Charge</th>
                    <td align="left"></td>
                    <td></td>
                    <th align="left">Transport Mode</th>
                    <td align="left"></td>
                </tr>
                <tr>
                    <th align="left">Payment Mode</th>
                    <td align="left"></td>
                    <td align="left"></td>
                    <th align="left">Paid Amount</th>
                    <td align="left">0.00</td>
                </tr>
                            </table>
            <table align="center" width="95%" height="800" border="1" cellpadding="0" cellspacing="0" id="table" >
            	<tr height="30">
                	<th align="center" width="5%" rowspan="2">S.No.</th>
                	<th align="center" rowspan="2">Description</th>
                	<th align="center" rowspan="2">HSN</th>
                	<th align="center" rowspan="2">MRP</th>
                	<th align="center" width="5%" rowspan="2">UOM</th>
                	<th align="center" rowspan="2">Qty.</th>
                	<th align="center" rowspan="2">Rate</th>
                	<th align="center" rowspan="2">Charity</th>
                	<th align="center" rowspan="2">Disc.<br />Amt.</th>
                	<th align="center" rowspan="2">CD<br />%</th>
                	<th align="center" rowspan="2">Taxable<br />Amount</th>
                                    	<th align="center" rowspan="2">Total</th>
                </tr>
                <tr height="30">
                	                </tr>
                                <tr id="blank">
                	<td></td><td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
					                </tr>
                                                <tr height="30">
                	<td></td>
                    <th align="center">Total</th><td></td>
                    <td></td><td></td><td align="center"></td><td></td><td align="center"></td>
                    <td align="center"></td>
                    <td></td>
                    <td align="center">0.00</td>
					                    <th align="center">0.00</th>
                </tr>
                <tr height="30">
             		<th style="text-align:center;" colspan="12">Total Invoice Amount in Words</th>
             		             	</tr>
             	<tr height="30">
                	<td colspan="12" style="padding:20px;" 
                    		>
                		<font size="+1">    Only</font> 
               		</td>
                	             	</tr>
              				 	<tr height="40">
             		<td style="text-align:center;" colspan="9"><font size="+2">Total Payable Amount </font></td>
             		<td align="right" colspan="7"><font size="+2" style="margin-right:20px;">Rs. 0.00</font></td>
			 	</tr>
            </table>
            <table align="center" width="95%">
            	            	<tr>
                	<th align="left">Bank Details</th>
                    <td></td>
                </tr>
            	<tr>
                	<td>
                    	Bank : State Bank of India<br />
                    	Bank A/C : 37170055053<br />
                        Bank IFSC : SBNI0009010					</td>
                    <td></td>
                </tr>            	<tr>
                	<td rowspan="3">
                    	Terms &amp; Conditions:
                        <ol style="width:350px; font-weight:300; font-size:13px;">
                            <li>All Disputes are subject to Ranchi Jurisdiction only.</li>
                            <li>Goods once sold will not be exchanged or returned.</li>
                            <li>Damaged Goods to be returned within 30 Days.</li>
                            <li>Any kind of goods returned 10% will be deducted.</li>
                            <li>Our responsibility ceases once the consignment is dispatched from the shop.</li>
                        </ol>
                  	</td>
                    <td align="center" valign="top">For SHREE BALAJI ENTERPRISES</td>
                </tr>
                <tr height="10">
                	<td align="center">Authorised Signature</td>
                </tr>
                <tr height="10">
                	<td align="center">Thank You!</td>
                </tr>
            </table>
         	<div id="buttons">
             	<center>
                  	<button type="button" class="btn btn-danger" onclick="window.print();" 
                    	style="background-color:#F70004; height:30px; width:70px; border-radius:5px; color:#FFFFFF; font-size:14px;" >Print</button>
                 	<button type="button" onclick="closeThis('');" class="btn btn-default"
                    	style="background-color:#F70004; height:30px; width:70px; border-radius:5px; color:#FFFFFF; font-size:14px;">Close</button>
             	</center>
         	</div>
        </div>
        <script language="javascript">
        	function closeThis(str){
				var page=str;
				if(page=='report'){
					window.location="../reports?pagename=report";
				}	
				else{
					window.location="../invoice?pagename=invoice";	
				}
			}
        </script>
    </body>
</html>