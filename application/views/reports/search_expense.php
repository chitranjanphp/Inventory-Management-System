<table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Bill No.</th>
                <th>Amount</th>
                <th>Particular</th>
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