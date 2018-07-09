<?php

use yii\db\Migration;

/**
 * Class m180709_163312_students_alter_column
 */
class m180709_163312_students_alter_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('students', 'control_sum', $this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180709_163312_students_alter_column cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180709_163312_students_alter_column cannot be reverted.\n";

        return false;
    }
    */
}
