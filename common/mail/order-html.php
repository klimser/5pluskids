<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userName string */
/* @var $subjectName string */

?>
<p>Здравствуйте!</p>

<p>На сайте посетитель <?= $userName; ?> оставил заявку на занятие "<?= $subjectName; ?>".</p>

<p><?= Html::a('Обработать заявку', 'http://cabinet.5plus.uz/order/index') ?></p>
