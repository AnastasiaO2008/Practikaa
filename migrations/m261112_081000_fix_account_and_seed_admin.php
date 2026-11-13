<?php

use yii\db\Migration;

class m261112_081000_fix_account_and_seed_admin extends Migration
{
    public function safeUp()
    {
        // Хеш пароля не помещается в INT. Преобразуем колонку в VARCHAR.
        $schema = $this->db->getTableSchema('{{%account}}', true);
        if ($schema === null) {
            throw new \RuntimeException('Таблица account не найдена. Сначала проверь подключение к базе dnevnik.');
        }
        if (isset($schema->columns['password']) && $schema->columns['password']->type !== 'varchar') {
            $this->alterColumn('{{%account}}', 'password', $this->string(255)->notNull());
        }
        if (!isset($schema->columns['role'])) {
            $this->addColumn('{{%account}}', 'role', $this->string(20)->notNull()->defaultValue('user'));
        }

        // Тестовый администратор. После первого входа пароль рекомендуется сменить.
        if (!$this->getDb()->createCommand("SELECT COUNT(*) FROM {{%account}} WHERE mail = :mail")
            ->bindValue(':mail', 'admin@languagebloom.local')->queryScalar()) {
            $this->insert('{{%account}}', [
                'name' => 'Администратор',
                'mail' => 'admin@languagebloom.local',
                'password' => Yii::$app->security->generatePasswordHash('Admin123!'),
                'role' => 'admin',
            ]);
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{%account}}', 'role');
        // Не возвращаем INT: это уничтожило бы хеши паролей.
        return true;
    }
}
