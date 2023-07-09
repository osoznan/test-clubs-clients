<?php

use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use frontend\models\ClientSearch;
use yii\data\ArrayDataProvider;

/** @var ClientSearch $model */
/** @var array $data */

$this->params['breadcrumbs'] = [
    ['label' => 'Клиенты']
];

?>
<a href="/client/create" class="btn btn-primary mb-3">Добавить</a>
<?php

Pjax::begin(['id' => 'page_pjax']);

$form = ActiveForm::begin([
    'id' => 'filter-form',
    'method' => 'post',
    'options' => ['class' => 'form-horizontal', 'data-pjax' => true, 'url' => '/client'],
]) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'sex')->checkboxList(['М' => 'мужской', 'Ж' => 'женский'],
                ['class' => 'form-check form-switch']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'birthFrom', ['options' => ['autocomplete' => 'off']])
                ->widget(DatePicker::class, [
                    'name' => 'dp_1',
                    'options' => ['autocomplete' => 'off'],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>
        </div>
        <div class="col-lg-6 mb-3">
            <?= $form->field($model, 'birthTo', ['options' => ['autocomplete' => 'off']])
                ->widget(DatePicker::class, [
                    'name' => 'dp_2',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['autocomplete' => 'off'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>
        </div>
    </div>
    <hr>
<?php
ActiveForm::end();

Pjax::begin(['id' => 'grid_pjax']);

echo GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => ['attributes' => ['id','name', 'sex', 'birth_date', 'created_at']]
    ]),
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
    'columns' => [
        'id',
        ['attribute' => 'name', 'label' => 'Имя'],
        ['attribute' => 'sex', 'label' => 'Пол'],
        [
            'label' => 'Дата рождения',
            'attribute' => 'birth_date',
            'format' => ['datetime', 'php:Y-m-d H:i:s']
        ],
        [
            'label' => 'Дата создания',
            'attribute' => 'created_at',
            'format' => ['datetime', 'php:Y-m-d H:i:s']
        ],
        [
            'label' => 'Клубы',
            'format' => 'html',
            'value' => function ($row) {
                if (!empty($row['clubs'])) {
                    return join(', ', array_map(function ($club) {
                        return "<a href='/client/view?id={$club['id']}'>{$club['name']}</a>";
                    }, $row['clubs']));
                }
            }

        ],
        ['class' => 'yii\grid\ActionColumn']
    ],
]);

Pjax::end();

$this->registerJs(<<< JS
$("document").ready(function(){
    attachFilterHandlers()
})
JS);

Pjax::end();
