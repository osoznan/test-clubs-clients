<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use frontend\models\Client;
use yii\helpers\ArrayHelper;

/** @var Client $model */
/** @var array $clubList */

$commandLabel = $model->isNewRecord ? 'Создать' : 'Редактировать';

$this->params['breadcrumbs'] = [
    ['label' => 'Клиенты', 'url' => '/client'],
    ['label' => $commandLabel]
];

$form = ActiveForm::begin([
    'method' => 'post',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'sex')->radioList(['М' => 'мужской', 'Ж' => 'женский'],
                ['class' => 'form-check form-switch']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'birth_date')
                ->widget(DatePicker::class, [
                    'options' => ['autocomplete' => 'off'],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'clubs')->checkboxList(ArrayHelper::map($clubList, 'id', 'name'),
                ['value' => $model->getClubList(), 'class'=> 'list-group']) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>