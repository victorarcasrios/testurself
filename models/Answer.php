<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property integer $id
 * @property integer $examination_id
 * @property integer $test_question_id
 * @property integer $option_id
 *
 * @property Examinations $examination
 * @property Options $option
 * @property TestsQuestions $testQuestion
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['examination_id', 'test_question_id', 'option_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'examination_id' => 'Examination ID',
            'test_question_id' => 'Test Question ID',
            'option_id' => 'Option ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamination()
    {
        return $this->hasOne(Examination::className(), ['id' => 'examination_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestQuestion()
    {
        return $this->hasOne(TestsQuestion::className(), ['id' => 'test_question_id']);
    }
}
