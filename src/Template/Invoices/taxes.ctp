<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Taxes</h1>
    </div>
</div>
<?php
echo $this->Form->create('');

echo '<div class="form-group">';
echo '<div class="row">';
echo '<div class="col-sm-12">';
echo '<label>Start Date</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';

echo '<div class="col-sm-2">';
echo $this->Form->month('start_date', array('empty'=> 'Month', 'class' => 'form-control', 'value' => date('m'), 'required' => true));
echo '</div>';

echo '<div class="col-sm-2">';
echo $this->Form->day('start_date', array('empty'=> 'Day', 'class' => 'form-control', 'value' => date('d'), 'required' => true));
echo '</div>';

echo '<div class="col-sm-2">';
echo $this->Form->year('start_date', array('empty'=> 'Year', 'class' => 'form-control', 'value' => date('Y'), 'required' => true));
echo '</div>';

echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<div class="row">';
echo '<div class="col-sm-12">';
echo '<label>End Date</label>';
echo '</div>';
echo '</div>';

echo '<div class="row">';

echo '<div class="col-sm-2">';
echo $this->Form->month('end_date', array('empty'=> 'Month', 'class' => 'form-control', 'value' => date('m'), 'required' => true));
echo '</div>';

echo '<div class="col-sm-2">';
echo $this->Form->day('end_date', array('empty'=> 'Day', 'class' => 'form-control', 'value' => date('d'), 'required' => true));
echo '</div>';

echo '<div class="col-sm-2">';
echo $this->Form->year('end_date', array('empty'=> 'Year', 'class' => 'form-control', 'value' => date('Y'), 'required' => true));
echo '</div>';

echo '</div>';
echo '</div>';

echo $this->Form->submit('Submit', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>

<?php
foreach($invoices as $invoice) { ?>
    <h1>Invoice #:<?php echo $invoice->id; ?> for <?php echo $invoice->client->title; ?></h1>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Client Address</h3>
                </div>
                <div class="panel-body">
                    <p><?php echo $invoice->client->title; ?></br>
                        <?php echo nl2br($invoice->client->address); ?></p>
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
            </tr>
            </thead>
            <tbody>
            <?php
            $total_array = array();
            foreach($invoice->invoice_items as $invoiceitem) {
                $total_array[] = $invoiceitem['time_billed'] * $invoiceitem['time_rate'];
                echo '<tr>';
                echo '<td>'.$invoiceitem['id'].'</td>';
                echo '<td>'.$invoiceitem['body'].'</td>';
                echo '<td>'.$invoiceitem['time_billed'].'</td>';
                echo '<td>$'.$invoiceitem['time_rate'].'</td>';
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
            echo '<td><button class="btn btn-default" type="button">Total: <span class="badge">$'.$total.'</span></button></td>';
            echo '</tr>';
            ?>
            </tbody>
        </table>
    </div>
    <p>Generated: <?php echo $invoice->i_date; ?></p>
<?php } ?>