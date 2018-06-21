<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $full_name
 * @property string $login
 * @property string $password
 * @property string $city_id
 * @property string $info
 *
 * @property City $city
 */
class User1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'info'], 'string'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'login' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
            'city_id' => Yii::t('app', 'City ID'),
            'info' => Yii::t('app', 'Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery1 the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery1(get_called_class());
    }
}
