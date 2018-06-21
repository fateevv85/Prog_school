<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User1]].
 *
 * @see User1
 */
class UserQuery1 extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return User1[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User1|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
