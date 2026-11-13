<?php

use yii\db\Migration;

class m261111_085348_create_account_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%account}}', true) !== null) {
            return;
        }
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'mail' => $this->string(255)->notNull(),
            'password' => $this->integer()->notNull(), // По вашему дампу это int
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }
}