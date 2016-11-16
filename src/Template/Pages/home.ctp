<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <h1>Welcome to <?php echo SITE_TITLE; ?></h1>
    <p><?php echo SITE_TITLE; ?> is an online Client Relations Manager (CRM) written by <a href="http://georgewhitcher.com" target="_blank">George Whitcher</a>.</p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Clients</h3>
            </div>
            <div class="panel-body">
                <p>Manage your clients.  Login is required.</p>
                <a class="btn btn-default" href="<?php echo BASE_URL; ?>/clients" role="button">View details »</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Invoices</h3>
            </div>
            <div class="panel-body">
                <p>Manage your invoices.  Login is required.</p>
                <a class="btn btn-default" href="<?php echo BASE_URL; ?>/invoices" role="button">View details »</a>
            </div>
        </div>
    </div>
</div>