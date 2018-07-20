<?php

namespace app\components;


use yii\helpers\Html;

class FieldHelper
{
    public static function generateInput($id, $label, $name = null)
    {
        $name = ($name) ?: $id;

        return
            Html::beginTag('div', [
                'class' => 'form-group'
            ]) .

            Html::label($label, $id, [
                'class' => 'control-label'
            ]) .

            Html::input('number', $name, null, [
                'class' => 'form-control',
                'id' => $id,
                'min' => 0,
                'max' => 10
            ]) .

            Html::tag('div', null, [
                'class' => 'help-block'
            ]) .

            Html::endTag('div');

    }
}