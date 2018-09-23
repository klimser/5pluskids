<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userName string */
/* @var $subjectName string */

?>
<p>Здравствуйте!</p>

<p>На сайте 5pluskids.uz посетитель <?= $userName; ?> оставил заявку на занятие "<?= $subjectName; ?>".</p>

<p><?= Html::a('Обработать заявку', 'http://cabinet.5pluskids.uz/order/index') ?></p>
