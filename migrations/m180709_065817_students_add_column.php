<?php

use yii\db\Migration;

/**
 * Class m180709_065817_students_add_column
 */
class m180709_065817_students_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('students','lead_id',$this->integer()->unsigned()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('students','lead_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180709_065817_students_add_column cannot be reverted.\n";

        return false;
    }
    */
}
