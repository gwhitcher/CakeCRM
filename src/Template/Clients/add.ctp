<h1 class="page-header">Add Client</h1>
<?php
echo $this->Form->create($client);

echo '<div class="form-group">';
echo $this->Form->input('title', array('class' => 'form-control', 'type' => 'text'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('address', array('class' => 'form-control mceNoEditor', 'type' => 'textarea'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('body', array('class' => 'form-control', 'type' => 'textarea'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>