<h1 class="page-header">Users</h1>
<a class="btn btn-success" href="<?php echo BASE_URL; ?>/users/add">New</a>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($users as $user) {
            echo '<tr>';
            echo '<td>'.$user['id'].'</td>';
            echo '<td>'.$user['username'].'</td>';
            echo '<td><a class="btn btn-warning" href="'.BASE_URL.'/users/edit/'.$user['id'].'">Edit</a></td>';
            echo '<td><a class="delete btn btn-danger" href="'.BASE_URL.'/users/delete/'.$user['id'].'">Delete</a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>