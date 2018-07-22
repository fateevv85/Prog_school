<?php

namespace app\models\tables;

use app\models\Group;
use Yii;

/**
 * This is the model class for table "students".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $group_id
 * @property string $lead_id
 * @property string $control_sum
 *
 * @property Group $group
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'lead_id', 'control_sum'], 'integer'],
            [['last_name', 'first_name'], 'string', 'max' => 255],
            [['control_sum'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'group_id' => 'Group ID',
            'lead_id' => 'Lead ID',
            'control_sum' => 'Control Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
    }
}
