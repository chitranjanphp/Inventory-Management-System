<table class="table table-bordered ">
    <thead>
        <tr class="bg-success text-center">
            <th class="table-plus">Sl No</th>
            <th style="text-align:center">Particulars</th>
            <th style="text-align:center">HSN</th>
            <th style="text-align:center">MRP</th>
            <th style="text-align:center">Quantity</th>
            <th style="text-align:center">Rate</th>
            <th style="text-align:center">Discount</th>
            <th style="text-align:center">GST</th>
            <th style="text-align:center">Amount</th>
            <th class="datatable-nosort" width="5%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
		//$this->load->library('Amount');
        if(is_array($temps)){$i=0; $total=0;
            foreach($temps as $temp){$i++;
        ?>
        <tr>
            <td class="table-plus"><?php echo $i; ?></td>
            <td style="text-align:center"><?php echo $temp['company'].'  '.$temp['product']; ?></td>
            <td style="text-align:center"><?php echo $temp['hsn_code']; ?></td>
            <td style="text-align:center"><?php echo $temp['mrp']; ?></td>
            <td style="text-align:center"><?php echo $temp['quantity']; ?></td>
            <td style="text-align:center"><?php echo $temp['rate']; ?></td>
            <td style="text-align:center"><?php echo $temp['discount']; ?></td>
            <td style="text-align:center"><?php echo $temp['gstvalue']; ?></td>   
            <td style="text-align:center"><?php echo $temp['amount']; ?></td>
            <td>
            	<button type="button" class="btn btn-xs btn-danger delete-temp " value="<?php echo $temp['id']; ?>"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        <?php
				$total+=$temp['amount'];
            }
        }
        ?>
        <input type="hidden" id="temp_total" value="<?php echo $total; ?>">
    </tbody>
</table>
