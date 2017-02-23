<h1 class="page-header">Edit Invoice Item</h1>
<?php
echo $this->Form->create($invoiceitem);

echo '<div class="form-group">';
echo $this->Form->input('time_billed', array('class' => 'form-control', 'type' => 'text', 'label' => 'Time Billed (hourly)'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('time_rate', array('class' => 'form-control', 'type' => 'text', 'label' => 'Rate'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->input('body', array('class' => 'form-control mceNoEditor', 'type' => 'textarea'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>