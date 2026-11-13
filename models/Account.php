<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Аккаунт пользователя сайта.
 * Поле password содержит только хеш пароля.
 */
class Account extends ActiveRecord implements IdentityInterface
{
    public $newPassword;
    public static function tableName()
    {
        return 'account';
    }

    public function rules()
    {
        return [
            [['name', 'mail'], 'required'],
            [['name', 'mail'], 'string', 'max' => 255],
            [['mail'], 'email'],
            [['mail'], 'unique'],
            [['password'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => ['user', 'admin']],
            [['newPassword'], 'string', 'min' => 6, 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя пользователя',
            'mail' => 'Электронная почта',
            'password' => 'Хеш пароля',
            'role' => 'Роль',
        ];
    }

    public function getHistories()
    {
        return $this->hasMany(History::class, ['id_account' => 'id']);
    }

    public function setPassword($plainPassword)
    {
        $this->password = Yii::$app->security->generatePasswordHash($plainPassword);
    }

    public function validatePassword($plainPassword)
    {
        $stored = (string) $this->password;
        if ($stored === '') {
            return false;
        }

        // Существующие аккаунты могли быть созданы в старой версии проекта,
        // где password был INT и содержал пароль в открытом виде.
        // Для новых аккаунтов всегда проверяем безопасный хеш.
        $hashInfo = password_get_info($stored);
        if ($hashInfo['algoName'] !== 'unknown') {
            return Yii::$app->security->validatePassword($plainPassword, $stored);
        }

        // Совместимость со старыми записями: после первого успешного входа
        // сразу заменяем открытый пароль его хешем.
        if (!hash_equals($stored, (string) $plainPassword)) {
            return false;
        }
        $this->setPassword($plainPassword);
        if (!$this->save(false, ['password'])) {
            Yii::warning('Не удалось обновить старый пароль пользователя ' . $this->id, __METHOD__);
            return false;
        }
        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne((int) $id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Bearer-токены в этом проекте не используются.
    }

    public static function findByEmail($email)
    {
        return static::find()->where(['mail' => mb_strtolower(trim((string)$email), 'UTF-8')])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // Используем хеш пароля как ключ авторизации для rememberMe.
        return (string) $this->password;
    }

    public function validateAuthKey($authKey)
    {
        return is_string($authKey) && hash_equals((string) $this->password, $authKey);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
