<?php

use yii\db\Migration;

/**
 * Class m180619_150757_create_course_column
 */
class m180619_150757_create_course_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('course', 'product_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('course', 'product_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_150757_create_course_column cannot be reverted.\n";

        return false;
    }
    */
}
