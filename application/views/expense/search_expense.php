<table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Bill No.</th>
                <th>Amount</th>
                <th>Particular</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if(is_array($expenses)){
                    foreach($expenses as $row){
            ?>
            <tr>
                <td><?php echo date("d-m-Y",strtotime($row['date'])); ?></td>
                <td><?php echo $row['billno']; ?></td>
                <td><?php echo number_format($row['amount'],2); ?></td>
                <td><?php echo $row['particular']; ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="<?php echo base_url('expense/editexpense/'.$row['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>&nbsp;
                    <a class="btn btn-danger btn-sm" href="<?php echo base_url('expense/deleteexpense/'.$row['id']); ?>" onclick="return delConfirm();"><i class="fa fa-trash"></i> Delete</a>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
            </tbody>
           <tfoot align="right">
                <tr><th colspan="2" class="text-center"></th><th></th><th></th></tr>
            </tfoot>
  </table>