<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "words".
 *
 * @property int $id
 * @property int $language
 * @property string $word
 * @property string $transcription
 * @property string $translation
 * @property string $pos
 *
 * @property Language $language0
 */
class Words extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language', 'word', 'transcription', 'translation', 'pos'], 'required'],
            [['language'], 'integer'],
            [['pos'], 'string'],
            [['pos'], 'in', 'range' => ['noun', 'expression']], // ENUM
            [['word', 'transcription', 'translation'], 'string', 'max' => 255],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language' => 'Язык',
            'word' => 'Слово',
            'transcription' => 'Транскрипция',
            'translation' => 'Перевод',
            'pos' => 'Часть речи',
        ];
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
