<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userName string */

?>
<p>Здравствуйте!</p>

<p>На сайте 5pluskids.uz посетитель <?= $userName; ?> оставил сообщение через форму обратной связи.</p>

<p><?= Html::a('Обработать сообщение', 'http://cabinet.5pluskids.uz/feedback/index') ?></p>
