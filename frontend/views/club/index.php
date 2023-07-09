<?php

use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use frontend\models\ClubSearch;
use yii\db\Query;

/** @var ClubSearch $model */
/** @var Query $query */

$this->params['breadcrumbs'] = [
    ['label' => 'Клубы']
];

?>
    <a href="/club/create" class="btn btn-primary mb-3">Добавить</a>
<?php

Pjax::begin(['id' => 'page_pjax']);

$form = ActiveForm::begin([
    'id' => 'filter-form',
    'method' => 'post',
    'options' => ['class' => 'form-horizontal', 'data-pjax' => true, 'url' => '/club'],
]) ?>
    <div class="row mb-3">
        <div class="col-4">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'showDeleted')->checkbox() ?>
        </div>
    </div>
<?php
ActiveForm::end();

Pjax::begin(['id' => 'grid_pjax']);

echo GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => []
    ]),
    'columns' => [
        'id',
        [
            'attribute' => 'name',
            'format' => 'html',
            'value' => function ($model) {
                return !$model->deleted_at ?
                    $model['name'] : '<span class="bg-warning ml-3 p-1">Удалено</span> '
                    . $model['name'];
            }
        ],
        'address',
        'created_at:date',
        [
            'class' => yii\grid\ActionColumn::class
        ]
    ],
]);

Pjax::end();

$this->registerJs(<<< JS
$("document").ready(function(){
    attachFilterHandlers()
})
JS);

Pjax::end();