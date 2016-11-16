<h1 class="page-header">Mail Invoice #:<?php echo $invoice['id']; ?> for <?php echo $client['title']; ?></h1>
<?php
echo $this->Form->create('Invoice.Mail');

echo '<div class="form-group">';
echo $this->Form->input('email_addresses', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Seperate each email address by comma...'));
echo '</div>';

echo '<div class="form-group">';
echo $this->Form->submit('Submit', array('class' => 'btn btn-primary', 'title' => 'Submit'));
echo '</div>';

echo $this->Form->end();
?>