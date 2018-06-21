<?php

use yii\db\Migration;

/**
 * Class m180619_145131_create_course_column
 */
class m180619_145131_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'city_id' => $this->integer()->notNull()->unsigned(),
            'amo_view' => $this->boolean()
        ]);



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180619_145131_create_course_column cannot be reverted.\n";

        return false;
    }
    */
}
