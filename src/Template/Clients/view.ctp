<div class="row">
    <div class="col-md-10">
        <h1 class="page-header"><?php echo $client['title']; ?></h1>
    </div>
    <div class="col-md-2 cog-list">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo BASE_URL; ?>/invoices/add?client_id=<?php echo $client['id']; ?>">Add Invoice</a></li>
        </ul>
    </div>
</div>
<label>Body:</label>
<p><?php echo $client['body'];?></p>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Status</th>
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
            echo '<td>'.$invoice['i_date'].'</td>';
            if($invoice['status'] == 0) {
                echo '<td>Not Paid</td>';
            } else {
                echo '<td>Paid</td>';
            }
            echo '<td><a class="btn btn-info" href="'.BASE_URL.'/invoices/view/'.$invoice['id'].'">View</a></td>';
            echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/invoices/edit/'.$invoice['id'].'">Edit</a></td>';
            echo '<td><a class="delete btn btn-danger" href="'.BASE_URL.'/invoices/delete/'.$invoice['id'].'">Delete</a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>