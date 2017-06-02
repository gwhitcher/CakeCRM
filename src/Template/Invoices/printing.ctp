<h1>Invoice #:<?php echo $invoice['id']; ?> for <?php echo $client->title; ?></h1>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Client Address</h3>
            </div>
            <div class="panel-body">
                <p><?php echo $client['title']; ?></br>
                    <?php echo nl2br($client['address']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Company Address</h3>
            </div>
            <div class="panel-body">
                <p><?php echo MAIN_ADDRESS; ?></p>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Time (Hours)</th>
            <th>Rate</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_array = array();
        foreach($invoiceitems as $invoiceitem) {
            $total_array[] = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            $total_rate = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            echo '<tr>';
            echo '<td>'.$invoiceitem['id'].'</td>';
            echo '<td>'.$invoiceitem['body'].'</td>';
            echo '<td>'.$invoiceitem['time_billed'].'</td>';
            echo '<td>$'.$invoiceitem['time_rate'].'</td>';
            echo '<td>$'.$total_rate.'</td>';
            echo '</tr>';
        }
        $total = 0;
        foreach($total_array as $total_item) {
            $total += $total_item;
        }
        echo '<tr>';
        echo '<td> </td>';
        echo '<td> </td>';
        echo '<td> </td>';
        echo '<td> </td>';
        echo '<td><button class="btn btn-default" type="button">Total: <span class="badge">$'.$total.'</span></button></td>';
        echo '</tr>';
        ?>
        </tbody>
    </table>
</div>
<p>Generated: <?php echo $invoice->i_date; ?></p>