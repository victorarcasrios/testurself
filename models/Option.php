<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $text
 * @property integer $correct
 *
 * @property Answers[] $answers
 * @property Questions $question
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'text', 'correct'], 'required'],
            [['question_id', 'correct'], 'integer'],
            [['text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'text' => 'Text',
            'correct' => 'Correct',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }
}
