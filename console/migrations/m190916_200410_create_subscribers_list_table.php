<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m190916_200410_create_subscribers_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%subscribers_list}}', [
            'user' => $this->string(15)->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscribers_list}}');
    }
}
