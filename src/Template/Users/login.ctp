<!-- File: src/Template/Users/login.ctp -->
<h1 class="page-header">Login</h1>
<div id="login">
    <?= $this->Form->create() ?>
    <div class="form-group">
        <?= $this->Form->input('username', array('class' => 'form-control')) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->input('password', array('class' => 'form-control')) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->submit('Send', array('class' => 'btn btn-primary', 'title' => 'Login')); ?>
    </div>
    <?= $this->Form->end() ?>
</div>