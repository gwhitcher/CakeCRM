<div class="row">
    <div class="col-md-6">
        <h1 class="page-header"> <?php echo $client['title']; ?></h1>
    </div>
    <div class="col-md-5">
        <h1 class="page-header pull-right">Invoice #<?php echo $invoice['id']; ?></h1>
    </div>
    <div class="col-md-1 cog-list">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo BASE_URL; ?>/invoiceitems/add/<?php echo $invoice['id']; ?>">Add Invoice Item</a></li>
            <li><a href="<?php echo BASE_URL; ?>/invoices/printing/<?php echo $invoice['id']; ?>">Print</a></li>
            <li><a href="<?php echo BASE_URL; ?>/invoices/mail/<?php echo $invoice['id']; ?>">Mail</a></li>
        </ul>
    </div>
</div>

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
            <th>Time</th>
            <th>Rate</th>
            <th>Total</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_array = array();
        $invoice_id = 1;
        foreach($invoiceitems as $invoiceitem) {
            $total_array[] = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            $total_rate = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
            echo '<tr>';
            echo '<td>'.$invoice_id.'</td>';
            echo '<td>'.nl2br($invoiceitem['body']).'</td>';
            echo '<td>'.$invoiceitem['time_billed'].'</td>';
            echo '<td>$'.$invoiceitem['time_rate'].'</td>';
            echo '<td>$'.$total_rate.'</td>';
            echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/invoiceitems/edit/'.$invoiceitem['id'].'">Edit</a></td>';
            echo '<td><a class="delete btn btn-danger" href="'.BASE_URL.'/invoiceitems/delete/'.$invoiceitem['id'].'">Delete</a></td>';
            echo '</tr>';
            $invoice_id++;
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
        echo '<td> </td>';
        echo '<td> </td>';
        echo '</tr>';
        ?>
        </tbody>
    </table>
</div>

<?php
if(!empty($invoice['notes'])) {
    echo '<strong>Notes:</strong> '.$invoice['notes'];
}
?>

<p>Generated: <?php echo $invoice['i_date']; ?></p>