<?php

use frontend\models\Client;
use app\widgets\RecordViewWidget;

/** @var $model Client */

$this->params['breadcrumbs'] = [
    ['label' => 'Клиенты', 'url' => '/client'],
    ['label' => 'Информация']
];

?>

<h1>Клуб "<?=$model->name?>"</h1>

<?= RecordViewWidget::widget([
    'model' => $model,
    'columns' => ['name', 'sex', 'birth_date', 'clubs']
])
?>