<?php

use yii\db\Migration;

/**
 * Class m180619_151151_create_fk_product
 */
class m180619_151151_create_fk_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_product_city', 'product', 'city_id', 'city', 'city_id');

        $this->addForeignKey('fk_course_product', 'course', 'product_id', 'product', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180619_151151_create_fk_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_151151_create_fk_product cannot be reverted.\n";

        return false;
    }
    */
}
