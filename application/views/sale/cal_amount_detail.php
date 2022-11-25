 <table class="table table-bordered">
        <tbody><tr>
            <td width="40%"><b>Gross Amount :</b></td>
            <td colspan="2" id="ga" width="60%">
                <input type="text" name="gross_amount" style="width:100%" value="<?php echo round($amountdetail['gross_amount']); ?>" id="gross_amount" readonly="readonly" class="form-control">
            </td>
        </tr>
        <tr>
            <td><b>GST Value:</b></td>
            <td colspan="2">
                <input type="text" name="gstval" id="gstval" value="<?php echo round($amountdetail['gstval']); ?>" readonly="readonly" class="form-control">
            </td>
        </tr>
        <tr>
            <td><b>Net Amount :</b></td>
            <td colspan="2">
                <input type="text" name="net_amount" value="<?php echo round($amountdetail['net_amount']); ?>" id="net_amount" class="form-control" readonly="readonly">
            </td>
        </tr>
        <tr>
            <td><b>Invoice Disc(%) :</b></td>
            <td>
                <input type="text" name="dpercent" value="" id="dpercent" class="form-control" onkeyup="caculateTotal(this.value);">
            </td>
            <td>
                <input type="text" name="dvalue" value="" id="dvalue" class="form-control" readonly="readonly">
            </td>
        </tr>
        <tr>
            <td><b>Total Amount :</b></td>
            <td colspan="2" id="nAmt">
                <input type="text" name="total_amount" id="total_amount" value="<?php echo round($amountdetail['net_amount']); ?>" readonly="readonly" class="form-control">
            </td>
        </tr>
        <tr>
            <td><label class="checkbox"><input type="checkbox" name="adjust" id="adjust" value="" onclick="AdjustAmount();" /><b>Adjustment :</b></label></td>
            <td width="35%">
                <span class="hidden" id="entinvno"><input type="text" name="adinvoice_no" value="" id="adinvoice_no" placeholder="Invoice No." onkeyup="getAdjAmount(this.value);" class="form-control" autocomplete="off"></span>
            </td>
            <td>
                <span class="hidden" id="adjamount"><input type="text" name="adjust_amount" value="0" id="adjust_amount" class="form-control" readonly="readonly"></span>
            </td>
        </tr>
         <tr>
            <td><b>Payable Amount :</b></td>
            <td colspan="2" id="nAmt">
                <input type="text" name="payable" id="payable" value="<?php echo round($amountdetail['net_amount']); ?>" readonly="readonly" class="form-control">
            </td>
        </tr>
    </tbody>
 </table>
         