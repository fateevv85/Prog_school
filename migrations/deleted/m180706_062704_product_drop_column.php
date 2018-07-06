<?php

use yii\db\Migration;

/**
 * Class m180706_062704_product_course_edit
 */
class m180706_062704_product_drop_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('product','amo_view');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('product','amo_view', $this->boolean());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180706_062704_product_course_edit cannot be reverted.\n";

        return false;
    }
    */
}
