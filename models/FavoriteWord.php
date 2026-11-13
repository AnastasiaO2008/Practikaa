<?php
namespace app\models;

use yii\db\ActiveRecord;

class FavoriteWord extends ActiveRecord
{
    public static function tableName()
    {
        return 'favorite_word';
    }

    public function rules()
    {
        return [
            [['account_id', 'word_id', 'created_at'], 'required'],
            [['account_id', 'word_id', 'created_at'], 'integer'],
            [['account_id', 'word_id'], 'unique', 'targetAttribute' => ['account_id', 'word_id']],
            [['account_id'], 'exist', 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],
            [['word_id'], 'exist', 'targetClass' => Words::class, 'targetAttribute' => ['word_id' => 'id']],
        ];
    }

    public function getWord()
    {
        return $this->hasOne(Words::class, ['id' => 'word_id']);
    }

    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }
}
