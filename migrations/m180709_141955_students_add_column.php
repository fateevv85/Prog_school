<?php

use yii\db\Migration;

/**
 * Class m180709_141955_students_add_column
 */
class m180709_141955_students_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('students', 'lead_id', $this->integer()->unsigned());
        $this->dropIndex('lead_id', 'students');
        $this->addColumn('students', 'control_sum', $this->integer()->unsigned()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('students', 'control_sum');
        $this->createIndex('lead_id','students','lead_id',true);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180709_141955_students_add_column cannot be reverted.\n";

        return false;
    }
    */
}
