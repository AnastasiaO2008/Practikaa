<?php

use yii\db\Migration;

class m261111_085449_create_words_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%words}}', true) !== null) {
            return;
        }
        $this->createTable('{{%words}}', [
            'id' => $this->primaryKey(),
            'language' => $this->integer()->notNull(),
            'word' => $this->string(255)->notNull(),
            'transcription' => $this->string(255)->notNull(),
            'translation' => $this->string(255)->notNull(),
            'pos' => "ENUM('noun', 'expression') NOT NULL",
        ]);

        // Внешний ключ на таблицу language
        $this->addForeignKey(
            'fk-words-language',
            '{{%words}}',
            'language',
            '{{%language}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-words-language', '{{%words}}');
        $this->dropTable('{{%words}}');
    }
}