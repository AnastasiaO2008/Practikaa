<?php
use yii\db\Migration;

class m261112_120000_create_favorite_word_table extends Migration
{
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%favorite_word}}', true) !== null) {
            return;
        }
        $this->createTable('{{%favorite_word}}', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'word_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('ux-favorite-account-word', '{{%favorite_word}}', ['account_id', 'word_id'], true);
        $this->addForeignKey('fk-favorite-account', '{{%favorite_word}}', 'account_id',
            '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-favorite-word', '{{%favorite_word}}', 'word_id',
            '{{%words}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-favorite-word', '{{%favorite_word}}');
        $this->dropForeignKey('fk-favorite-account', '{{%favorite_word}}');
        $this->dropTable('{{%favorite_word}}');
    }
}
