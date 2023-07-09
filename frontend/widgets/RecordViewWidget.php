<?php

namespace app\widgets;

use yii\base\Widget;
use yii\db\ActiveRecord;

class RecordViewWidget extends Widget {
    public ActiveRecord $model;
    public array $columns;

    function run() {
        ?>
        <table class="table">
        <?php foreach ($this->columns as $attrName): ?>
            <tr>
                <td><?=$this->model->getAttributeLabel($attrName)?></td>
                <td><?=$this->model->$attrName?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <?php
    }
}