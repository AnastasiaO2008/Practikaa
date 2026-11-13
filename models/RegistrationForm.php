<?php
namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $name;
    public $mail;
    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return [
            [['name', 'mail', 'password', 'passwordRepeat'], 'required'],
            [['name'], 'string', 'min' => 2, 'max' => 255],
            [['mail'], 'email'],
            [['mail'], 'string', 'max' => 255],
            [['mail'], 'unique', 'targetClass' => Account::class, 'targetAttribute' => 'mail',
                'message' => 'Аккаунт с такой почтой уже существует.'],
            [['password'], 'string', 'min' => 8, 'max' => 255],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'mail' => 'Электронная почта',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $account = new Account();
        $account->name = $this->name;
        $account->mail = mb_strtolower(trim($this->mail), 'UTF-8');
        $account->setPassword($this->password);
        $account->role = 'user';

        return $account->save(false);
    }
}
