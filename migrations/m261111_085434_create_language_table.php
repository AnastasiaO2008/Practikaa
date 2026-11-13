<?php

use yii\db\Migration;

class m261111_085434_create_language_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%language}}', true) !== null) {
            return;
        }
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}