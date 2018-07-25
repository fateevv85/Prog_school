<?php

use yii\db\Migration;

/**
 * Class m180724_145028_students_add_columns
 */
class m180724_145028_students_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('students', 'p_last_name', $this->string());
        $this->addColumn('students', 'p_first_name', $this->string());
        $this->addColumn('students', 'p_mid_name', $this->string());
        $this->addColumn('students', 'budget', $this->integer());
        $this->addColumn('students', 'notebook', $this->string());
        $this->addColumn('students', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('students', 'p_last_name');
        $this->dropColumn('students', 'p_first_name');
        $this->dropColumn('students', 'p_mid_name');
        $this->dropColumn('students', 'budget');
        $this->dropColumn('students', 'notebook');
        $this->dropColumn('students', 'email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180724_145028_students_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
