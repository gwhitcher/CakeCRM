<h1 class="page-header">Edit Invoice for <?php echo $client->title; ?></h1>
<?php
echo $this->Form->create($invoice);

echo '<div class="form-group">';
echo $this->Form->input('notes', array('class' => 'form-control', 'type' => 'textarea'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('status', array('class' => 'form-control', 'type' => 'select', 'options' => array('0' => 'Not Paid', '1' => 'Paid')));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>