<h1 class="page-header">Edit User</h1>
<?php echo $this->Form->create($user);?>
<?php
echo '<div class="form-group">';
echo $this->Form->input('name', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('username', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('email', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('password', array('class' => 'form-control'));
echo '</div>';

echo '<div class="form-group">';
if ($current_user['role'] == 'admin') {
    echo $this->Form->input('role', array('options' => array('3' => 'Admin', '2' => 'Moderator', '1' => 'User'), 'class' => 'form-control'));
}
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Send', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>