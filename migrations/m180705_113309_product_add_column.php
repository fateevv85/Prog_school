<?php

use yii\db\Migration;

/**
 * Class m180705_113309_product_add_column
 */
class m180705_113309_product_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('product', 'amo_view', 'amo_paid_view');

        $this->addColumn('product', 'amo_trial_view', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'amo_trial_view');

        $this->renameColumn('product', 'amo_paid_view', 'amo_view');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180705_113309_product_add_column cannot be reverted.\n";

        return false;
    }
    */
}
