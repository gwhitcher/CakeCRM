<!-- Bootstrap -->
<?= $this->Html->css('/resources/bootstrap/css/bootstrap.min.css'); ?>
<!-- Print -->
<?= $this->Html->css('print.css'); ?>

<div class="container print-container">
<?= $this->fetch('content') ?>
</div>