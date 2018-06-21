<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\City;

/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $full_name
 * @property string $username
 * @property string $password
 * @property string $city_id
 * @property string $info
 * @property string $auth_key
 * @property string $access_token
 *
 * @property City $city
 */
class User extends ActiveRecord implements IdentityInterface
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
            [['full_name', 'username', 'password', 'info', 'auth_key', 'access_token'], 'string'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
            [['username', 'password', 'auth_key', 'access_token'], 'trim'],
            [['username', 'password', 'full_name', 'city_id'], 'required'],
            [['password'], 'string', 'max' => 60, 'min' => 3,],
            [['username'], 'unique', 'targetClass' => 'app\models\User'],
            /*['username', function ($attribute, $params) {
                $user = $this->findByUsername($this->$attribute);
                if ( $user instanceof self ) {
                    $this->addError($attribute, 'Пользователь с таким "' . Yii::t('app', 'Username') . '" уже существует.');
                }
            }],*/
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
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'city_id' => Yii::t('app', 'City ID'),
            'info' => Yii::t('app', 'Info'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'access_token' => Yii::t('app', 'Токен'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getCityTitle()
    {
        $city = $this->city;

        return $city ? $city->title : '';
    }

    public static function getCitiesList()
    {
        return City::getCitiesList();
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        $user = static::findOne(['username' => $username]);
        //print_r($user);die;
        return $user;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        //var_dump($password);
        // if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
        //    return true;
        //} else {
        //     return false;
        //}
        return $this->password === $password;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->access_token = 'codabr-token' . \Yii::$app->security->generateRandomString();
                //$this->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        if ($this->id == 5 || $this->id == 8) {
            return false;
        }

        // ...custom code here...
        return true;
    }

    public static function getCurrentUserRole()
    {
        $identity = Yii::$app->user->identity;
        if (!is_null($identity)) {
            if (isset($identity->role)) {
                return $identity->role;
            }
        }
        return 'guest';
    }

    public function fields()
    {
        return ['full_name', 'city_id', 'access_token'];
    }

    public function extraFields()
    {
        return ['city'];
    }

}
