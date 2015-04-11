<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tests".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 *
 * @property Examinations[] $examinations
 * @property Users $user
 * @property TestsQuestions[] $testsQuestions
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExaminations()
    {
        return $this->hasMany(Examinations::className(), ['test_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestsQuestions()
    {
        return $this->hasMany(TestsQuestions::className(), ['test_id' => 'id']);
    }
}
