<?php

use yii\db\Migration;

/**
 * Class m180706_094657_create_table_students
 */
class m180706_094657_create_table_students extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('students', [
            'id'=>$this->primaryKey(),
            'last_name'=>$this->string(),
            'first_name'=>$this->string(),
            'group_id'=>$this->integer()->unsigned()
        ]);

        $this->addForeignKey('fk_students_group', 'students', 'group_id', 'group', 'group_id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_students_group', 'students');
        $this->dropTable('students');
    }
}
