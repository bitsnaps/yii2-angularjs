<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
//use app\assets\AngularAsset;

AppAsset::register($this);
//AngularAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
<script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    
<nav class="navbar-inverse navbar-fixed-top navbar" role="navigation"  bs-navbar>
    <div class="container">
        <div class="navbar-header">
            <button ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed" type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#!/">My Company</a>
        </div>
        <div ng-class="!navCollapsed && 'in'" ng-click="navCollapsed=true" class="collapse navbar-collapse" >
            <ul class="navbar-nav navbar-right nav">
                <li data-match-route="/$">
                    <a href="#!/">Home</a>
                </li>
                <li data-match-route="/about">
                    <a href="#!/about">About</a>
                </li>
                <li data-match-route="/contact">
                    <a href="#!/contact">Contact</a>
                </li>
                <li data-match-route="/dashboard" ng-show="loggedIn()" class="ng-hide">
                    <a href="#!/dashboard">Dashboard</a>
                </li>
                <li ng-class="{active:isActive('/logout')}" ng-show="loggedIn()" ng-click="logout()"  class="ng-hide">
                    <a href="">Logout</a>
                </li>
                <li data-match-route="/login" ng-hide="loggedIn()">
                    <a href="#!/login">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container">
        
        <!-- ngRoute -->
        <div ng-view></div>
        
          <!-- ui-router -->
          <!--<ui-view></ui-view>-->
        
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
