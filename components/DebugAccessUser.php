<?php

namespace app\components;

use Yii;
use yii\debug\Module;

class DebugAccessUser extends Module
{
    private $_basePath;

    protected function checkAccess()
    {
        $identity = Yii::$app->user->identity;
        if (!is_null($identity) && isset($identity->role)) {
            if ($identity->role === 'main_admin' || $identity->username === 'dragon') {
                return true;
            }
        }

//        return parent::checkAccess();
        return false;
    }

    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $class = new \ReflectionClass(new yii\debug\Module('debug'));
            $this->_basePath = dirname($class->getFileName());
        }

        return $this->_basePath;
    }
}
