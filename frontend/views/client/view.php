<?php

use frontend\models\Client;
use app\widgets\RecordViewWidget;

/** @var $model Client */

$this->params['breadcrumbs'] = [
    ['label' => 'Клиенты', 'url' => '/client'],
    ['label' => 'Информация']
];

?>

<h2>Клиент "<?=$model->name?>"</h2>

<?= RecordViewWidget::widget([
    'model' => $model,
    'columns' => [
        'name',
        'sex',
        'birth_date',
    ]
])
?>
