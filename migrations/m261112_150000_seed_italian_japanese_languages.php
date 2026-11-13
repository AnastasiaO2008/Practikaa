<?php

use yii\db\Migration;

/**
 * Adds the initial language catalog entries without duplicating existing rows.
 */
class m261112_150000_seed_italian_japanese_languages extends Migration
{
    public function safeUp()
    {
        $table = $this->db->getTableSchema('{{%language}}', true);
        if ($table === null) {
            throw new \RuntimeException('Таблица language не найдена.');
        }

        foreach (['Итальянский', 'Японский'] as $name) {
            $exists = (new \yii\db\Query())
                ->from('{{%language}}')
                ->where(['name' => $name])
                ->exists($this->db);
            if (!$exists) {
                $this->insert('{{%language}}', ['name' => $name]);
            }
        }
    }

    public function safeDown()
    {
        // Не удаляем языки: на них могут ссылаться слова и история занятий.
        return true;
    }
}
