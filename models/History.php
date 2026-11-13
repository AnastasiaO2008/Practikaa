<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $id_account
 * @property string $date
 * @property int $language
 * @property string $lesson
 * @property string $time
 * @property string $status
 *
 * @property Account $account
 * @property Language $language0
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_account', 'date', 'language', 'lesson', 'time', 'status'], 'required'],
            [['id_account', 'language'], 'integer'],
            [['date'], 'safe'],
            [['lesson', 'status'], 'string'],
            [['lesson'], 'in', 'range' => ['Грамматика', 'Лексика']], // Проверка ENUM
            [['status'], 'in', 'range' => ['Текущая', 'Завершено']], // Проверка ENUM
            [['time'], 'string', 'max' => 255],
            [['id_account'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['id_account' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_account' => 'Пользователь',
            'date' => 'Дата занятия',
            'language' => 'Язык',
            'lesson' => 'Тип урока',
            'time' => 'Время',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'id_account']);
    }

    /**
     * Gets query for [[Language0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Language::className(), ['id' => 'language']);
    }
}
