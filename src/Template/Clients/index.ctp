<div class="row">
    <div class="col-md-10">
        <h1 class="page-header">Clients</h1>
    </div>
    <div class="col-md-2 cog-list">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo BASE_URL; ?>/clients/add">Add Client</a></li>
        </ul>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($clients as $client) {
            echo '<tr>';
            echo '<td>'.$client['id'].'</td>';
            echo '<td>'.$client['title'].'</td>';
            echo '<td><a class="btn btn-info" href="'.BASE_URL.'/clients/view/'.$client['id'].'">View</a></td>';
            echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/clients/edit/'.$client['id'].'">Edit</a></td>';
            echo '<td><a class="delete btn btn-danger" href="'.BASE_URL.'/clients/delete/'.$client['id'].'">Delete</a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>