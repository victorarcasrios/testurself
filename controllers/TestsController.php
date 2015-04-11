<?php

namespace app\controllers;

use Yii;
use app\models\Test;
use app\models\TestQuestion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestsController implements the CRUD actions for Test model.
 */
class TestsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( Yii::$app->request->isGet )
            return $this->render('form', [
                'mode' => 'create'
            ]);
        else if( Yii::$app->request->isAjax && Yii::$app->request->isPost )
            return $this->create(Yii::$app->request->post('test'));
    }

    private function create($testData)
    {
        if(Test::find()->where("name = {$testData['name']}")->exists()) return 0;

        $test = new Test();
        $test->name = $testData['name'];
        $test->user_id = 1;
        if( !$test->save() ) return 0;

        return $this->addQuestions($testData['questions'], $test->id);
    }

    private function addQuestions($questions, $testId)
    {
        foreach($questions as $question){
            $testQuestion = new TestQuestion();
            $testQuestion->test_id = $testId;
            $testQuestion->question_id = $question['id'];
            if( !$testQuestion->save() ) return 0;
        }
        return 1;
    }

    /**
     * Updates an existing Test model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( Yii::$app->request->isGet )
            return $this->render('form', [
                'mode' => 'edit',
                'id' => $id
            ]);
        else if(Yii::$app->request->isAjax && Yii::$app->request->isPost)
            return $this->edit(Yii::$app->request->post('test'));
    }

    public function actionDelete()
    {
        $notProperlyAccessed = !(Yii::$app->request->isAjax && Yii::$app->request->isPost);
        if( $notProperlyAccessed ) return 0;
        
        $id = Yii::$app->request->post('id');
        $question = Test::findOne(['id' => $id]);
        $question->delete();
        return 1;
    }
}
