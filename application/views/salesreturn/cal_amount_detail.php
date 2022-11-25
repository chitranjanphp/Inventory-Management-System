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
            <td><b>Total Amount :</b></td>
            <td colspan="2" id="nAmt">
                <input type="text" name="total_amount" id="total_amount" value="<?php echo round($amountdetail['net_amount']); ?>" readonly="readonly" class="form-control">
            </td>
        </tr>
    </tbody>
 </table>
            