<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "examinations".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $test_id
 * @property string $date
 *
 * @property Answers[] $answers
 * @property Users $user
 * @property Tests $test
 */
class Examination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examinations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'test_id'], 'required'],
            [['user_id', 'test_id'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'test_id' => 'Test ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['examination_id' => 'id']);
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
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

    public function hadAnswered(Option $option)
    {
        return $this->getAnswers()->where(['option_id' => $option->id])->exists();
    }

    public function getScore()
    {
        $elements = $this->test->testQuestions;
        $answers = $this->getAnswers();
        $count = count($elements);
        $score = ['correct' => 0, 'incorrect' => 0, 'notAnswered' => $count, 'total' => $count];
        foreach($elements as $element)
        {
            $answer = $answers->where(['test_question_id' => $element->id])->one();
            if($answer){
                    $score['notAnswered']--;
                if($answer->option_id === $element->question->correct[0]->id)
                    $score['correct']++;
                else
                    $score['incorrect']++;
            }
        }
        return $score;
    }
}
