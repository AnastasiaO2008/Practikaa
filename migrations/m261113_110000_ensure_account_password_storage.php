<?php

use yii\db\Migration;

/**
 * Поле account.password должно вмещать password_hash (обычно 60+ символов).
 * Старые учебные версии использовали INT и не сохраняли хеш корректно.
 * Миграция не удаляет и не переписывает существующие аккаунты.
 */
class m261113_110000_ensure_account_password_storage extends Migration
{
    public function safeUp()
    {
        $table = $this->db->getTableSchema('{{%account}}', true);
        if (!$table || !isset($table->columns['password'])) {
            throw new \RuntimeException('Не найдена таблица account или поле password.');
        }

        $column = $table->columns['password'];
        if ($column->type !== 'string' || ($column->size !== null && $column->size < 255)) {
            $this->alterColumn('{{%account}}', 'password', $this->string(255));
        }
    }

    public function safeDown()
    {
        // Преобразование обратно в INT приведёт к потере хешей паролей.
        return true;
    }
}
