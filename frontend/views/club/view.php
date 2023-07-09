<?php

use frontend\models\Club;
use app\widgets\RecordViewWidget;

/** @var $model Club */

$this->params['breadcrumbs'] = [
    ['label' => 'Клубы', 'url' => '/client'],
    ['label' => 'Информация']
];

?>

<h1>Клуб "<?=$model->name?>"</h1>

<?= RecordViewWidget::widget([
    'model' => $model,
    'columns' => ['name', 'address', 'created_at']
])
?>