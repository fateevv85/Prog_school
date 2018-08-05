<?php

use yii\db\Migration;

/**
 * Class m180731_153110_students_add_column
 */
class m180731_153110_students_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('students', 'phone', $this->string(30));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('students', 'phone');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_153110_students_add_column cannot be reverted.\n";

        return false;
    }
    */
}
