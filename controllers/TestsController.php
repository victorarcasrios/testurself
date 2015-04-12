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

    public function actionList()
    {
        \Yii::$app->response->format = 'json';
        return Test::find()->all();
    }

    public function actionGet($id)
    {
        $test = Test::findOne($id);
        if(! $test) return ['status' => -2];

        \Yii::$app->response->format = 'json';
        return ['status' => 1, 'test' => $test, 'questions' => $test->questions];        
    }

    /**
     * If request is GET, renders the form in creation mode
     * Else if it is an AJAX POST, calls create() with the given test data
     * @return mixed [rendered view | 1 | 0]
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
        if(Test::find()->where(['name' => $testData['name']])->exists()) return 0;

        $test = new Test();
        $test->name = $testData['name'];
        $test->user_id = 1;
        if( !$test->save() ) return 0;

        return $this->addQuestions($testData['questions'], $test);
    }

    private function addQuestions($questions, $test)
    {
        foreach($questions as $question){
            $testQuestion = new TestQuestion();
            $testQuestion->test_id = $test->id;
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

    private function edit($testData)
    {
        $test = Test::findOne($testData['id']);

        if($this->nameIsAlreadyUsedByOther($testData)) return 0;

        $test->name = $testData['name'];
        if( !$test->save() ) return 0;

        TestQuestion::deleteAll(['test_id' => $test->id]);
        return $this->addQuestions($testData['questions'], $test);
    }

    private function nameIsAlreadyUsedByOther($testData)
    {
        return Test::find()
            ->where(['name' => $testData['name']])
            ->andWhere(['<>', 'id', $testData['id']])
            ->exists();
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
