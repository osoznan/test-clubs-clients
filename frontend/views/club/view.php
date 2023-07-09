<?php

use frontend\models\Club;
use app\widgets\RecordViewWidget;

/** @var $model Club */

$this->params['breadcrumbs'] = [
    ['label' => 'Клубы', 'url' => '/client'],
    ['label' => 'Информация']
];

?>

<h2>Клуб "<?=$model->name?>"</h2>

<?= RecordViewWidget::widget([
    'model' => $model,
    'columns' => ['name', 'address', 'created_at']
])
?>