<?php

namespace app\components;

use app\models\Lesson;

class LessonsExtraFields extends Lesson
{
    public $id;
    public $group_title;
    public $student_ln;
    public $student_fn;
    public $lead_id;
    public $p_last_name;
    public $p_first_name;
    public $p_mid_name;
    public $budget;
    public $notebook;
    public $email;

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