<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property string $user_id
 * @property string $full_name
 * @property string $username
 * @property string $password
 * @property string $city_id
 * @property string $info
 *
 * @property City $city
 */
class User extends ActiveRecord implements IdentityInterface
{
    /*
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'dragon',
            'password' => 'codabr',
            'authKey' => 'codabr100key',
            'accessToken' => 'codabr-tokent7865sre5665e4s',
        ],
    ];

    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }


    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    */

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['full_name', 'username', 'password', 'info'], 'string'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'username' => Yii::t('app', 'username'),
            'password' => Yii::t('app', 'Password'),
            'city_id' => Yii::t('app', 'City ID'),
            'info' => Yii::t('app', 'Info'),
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }
    
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
                $this->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

}
