<?php

/* @var $this yii\web\View */

$this->title = 'Панель управления';
?>
<div class="row">
    <a href="<?= \yii\helpers\Url::to(['page/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-file"></span> Страницы</a>
    <a href="<?= \yii\helpers\Url::to(['menu/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-th-list"></span> Меню</a>
    <a href="<?= \yii\helpers\Url::to(['widget-html/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-cog"></span> Блоки</a>
</div>
<hr>
<div class="row">
    <a href="<?= \yii\helpers\Url::to(['subject/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-bullhorn"></span> Курсы по направлениям</a>
    <a href="<?= \yii\helpers\Url::to(['subject-age/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-bullhorn"></span> Курсы по возрасту</a>
    <a href="<?= \yii\helpers\Url::to(['teacher/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="fas fa-user-tie"></span> Учителя</a>
    <a href="<?= \yii\helpers\Url::to(['news/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="far fa-newspaper"></span> Новости</a>
    <a href="<?= \yii\helpers\Url::to(['promotion/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="fas fa-bell"></span> Акции</a>
</div>
<hr>
<div class="row">
    <a href="<?= \yii\helpers\Url::to(['order/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-book"></span> Заявки</a>
    <a href="<?= \yii\helpers\Url::to(['review/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-book"></span> Отзывы</a>
    <a href="<?= \yii\helpers\Url::to(['feedback/index']); ?>" class="btn btn-default btn-lg col-xs-12 col-sm-4 col-md-3"><span class="glyphicon glyphicon-book"></span> Обратная связь</a>
</div>