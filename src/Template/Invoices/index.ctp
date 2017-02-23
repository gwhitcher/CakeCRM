<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Invoices</h1>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Status</th>
            <th>Date</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($invoices as $invoice) {
            echo '<tr>';
            echo '<td>'.$invoice['id'].'</td>';
            echo '<td>'.$invoice->client->title.'</td>';
            if($invoice->status == 1) {
                echo '<td>Paid</td>';
            } else {
                echo '<td>Not Paid</td>';
            }
            echo '<td>'.$invoice['i_date'].'</td>';
            echo '<td><a class="btn btn-info" href="'.BASE_URL.'/invoices/view/'.$invoice['id'].'">View</a></td>';
            echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/invoices/edit/'.$invoice['id'].'">Edit</a></td>';
            echo '<td><a class="delete btn btn-danger" href="'.BASE_URL.'/invoices/delete/'.$invoice['id'].'">Delete</a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>