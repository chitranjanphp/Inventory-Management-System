 <table class="table table-bordered">
        <tbody><tr>
            <td width="40%"><b>Gross Amount :</b></td>
            <td colspan="2" id="ga" width="60%">
                <input type="text" name="gross_amount" style="width:100%" value="<?php echo number_format($amountdetail['gross_amount'],2); ?>" id="gross_amount" readonly="readonly" class="form-control">
            </td>
        </tr>
        <tr>
            <td><b>GST Value:</b></td>
            <td colspan="2">
                <input type="text" name="gstval" id="gstval" value="<?php echo number_format($amountdetail['gstval'],2); ?>" readonly="readonly" class="form-control">
            </td>
        </tr>
        <tr>
            <td><b>Net Amount :</b></td>
            <td colspan="2">
                <input type="text" name="net_amount" value="<?php echo round($amountdetail['net_amount']); ?>" id="net_amount" class="form-control" readonly="readonly">
            </td>
        </tr>
        <tr>
            <td><b>Discount :</b></td>
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
    </tbody>
 </table>
            