<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $text
 * @property integer $user_id
 *
 * @property Options[] $options
 * @property Users $user
 * @property TestsQuestions[] $testsQuestions
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'user_id'], 'required'],
            [['user_id'], 'integer'],
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
            'text' => 'Text',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestsQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['question_id' => 'id']);
    }

    public function getAnswer($examination)
    {
        $testQuestion = $this->getTestsQuestions()->where(['test_id' => $examination->test->id])->one();
        // $testQuestion = $examination->test->getTestsQuestions->where(['question_id' => $this->id])->one();

        return Answer::findOne([
            'examination_id' => $examination->id,
            'test_question_id' =>  $testQuestion->id
        ]);
    }
}
