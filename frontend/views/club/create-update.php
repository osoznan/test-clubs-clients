<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use frontend\models\Club;

/** @var Club $model */
/** @var array $clubList */

$commandLabel = $model->isNewRecord ? 'Создать' : 'Редактировать';

$this->params['breadcrumbs'] = [
    ['label' => 'Клубы', 'url' => '/club'],
    ['label' => $commandLabel]
];

$form = ActiveForm::begin([
    'id' => 'create-form',
    'method' => 'post',
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'address')->textarea() ?>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton($commandLabel, ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>