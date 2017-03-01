<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>
        <?php
        if ($this->request->params['action'] == 'display') {
            echo SITE_TITLE.' - '.$title_for_layout;
        } elseif(!empty($title_for_layout)) {
            echo $title_for_layout.' - '.SITE_TITLE;
        } else {
            echo SITE_TITLE;
        }
        ?>
    </title>

    <!-- Bootstrap -->
    <?= $this->Html->css('/resources/bootstrap/css/bootstrap.min.css'); ?>

    <!-- Custom -->
    <?= $this->Html->css('/css/styles.css'); ?>

    <!-- Jquery -->
    <?= $this->Html->script('/resources/jquery/jquery.js'); ?>

    <!--Jquery-UI-->
    <?= $this->Html->script('/resources/jquery-ui/jquery-ui.min.js'); ?>
    <?= $this->Html->css('/resources/jquery-ui/jquery-ui.css'); ?>

    <!--TinyMCE-->
    <?= $this->Html->script('/resources/tinymce/tinymce.min.js'); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><?php echo SITE_TITLE; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/about">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CRM <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo BASE_URL; ?>/clients">Clients</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/invoices">Invoices</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/taxes">Taxes</a></li>
                        <li><a class="confirm" href="<?php echo BASE_URL; ?>/update">Update</a></li>
                    </ul>
                </li>
                <?php
                if(!empty($current_user)) {
                    echo '<li><a href="'.BASE_URL.'/users/logout">Logout</a></li>';
                } else {
                    echo '<li><a href="'.BASE_URL.'/users/login">Login</a></li>';
                }
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" role="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div> <!-- /container -->

<!-- Bootstrap -->
<?= $this->Html->script('/resources/bootstrap/js/bootstrap.min.js'); ?>
<!-- JS -->
<?= $this->Html->script('/js/default.js'); ?>
</body>
</html>