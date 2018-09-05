<?php
/* @var $this yii\web\View */
?>

<?= $this->render('index-content'); ?>

<hr>
<div class="row">
    <a href="<?= \yii\helpers\Url::to(['user/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-user"></span> Пользователи</a>
</div>