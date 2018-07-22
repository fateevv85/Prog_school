<?php

use yii\db\Migration;

/**
 * Class m180722_092616_add_columns_capacity
 */
class m180722_092616_add_columns_capacity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lesson', 'capacity', $this->smallInteger(5)->unsigned()->notNull());
        $this->addColumn('trial_lesson', 'capacity', $this->smallInteger(5)->unsigned()->notNull());

        $this->addColumn('lesson', 'start', $this->boolean()->defaultValue(0));
        $this->addColumn('trial_lesson', 'start', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('trial_lesson', 'capacity');
        $this->dropColumn('lesson', 'capacity');

        $this->dropColumn('trial_lesson', 'start');
        $this->dropColumn('lesson', 'start');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180722_092616_add_columns_capacity cannot be reverted.\n";

        return false;
    }
    */
}
