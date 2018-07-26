<?php

namespace app\components;

use app\models\TrialLesson;

class TrialLessonsExtraFields extends TrialLesson
{
    use LessonFieldsTrait;

    /*public function fields()
    {
        return [
            'id',
            'group_title',
            'name',
            'city_id',
            'amo_paid_view',
            'amo_trial_view',
            'lesson' => function ($data) {
                $product = new Product($this);
                $reflect = new \ReflectionClass($product);
                $public = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
                foreach ($public as $prop) {
                    $arr[$prop->name] = $this->{$prop->name};
                }
                return $arr;
            }
        ];
    }*/
}