<?php

use yii\db\Migration;

class m261111_085506_create_history_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%history}}', true) !== null) {
            return;
        }
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'id_account' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'language' => $this->integer()->notNull(),
            'lesson' => "ENUM('Грамматика', 'Лексика') NOT NULL",
            'time' => $this->string(255)->notNull(),
            'status' => "ENUM('Текущая', 'Завершено') NOT NULL",
        ]);

        // Внешние ключи
        $this->addForeignKey(
            'fk-history-account',
            '{{%history}}',
            'id_account',
            '{{%account}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-history-language',
            '{{%history}}',
            'language',
            '{{%language}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-history-account', '{{%history}}');
        $this->dropForeignKey('fk-history-language', '{{%history}}');
        $this->dropTable('{{%history}}');
    }
}