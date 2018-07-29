<?php

use yii\db\Migration;

/**
 * Class m180728_184230_course_in_city_add_column
 */
class m180728_184230_course_in_city_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('course_in_city','product_id', $this->integer());

        $this->addForeignKey('fk_course_in_city_pr', 'course_in_city', 'product_id', 'product', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('course_in_city','product_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180728_184230_course_in_city_add_column cannot be reverted.\n";

        return false;
    }
    */
}
