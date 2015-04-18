<?php

namespace app\controllers;

use Yii;
use app\models\Examination;
use app\models\Test;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExaminationsController implements the CRUD actions for Examination model.
 */
class ExaminationsController extends Controller
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

    // /**
    //  * Lists all Examination models.
    //  * @return mixed
    //  */
    // public function actionIndex()
    // {
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => Examination::find(),
    //     ]);

    //     return $this->render('index', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Creates a new Examination model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNew($testId = false)
    {
        if(!$testId)
            return $this->render('/tests/index', [
                'infoMessage' => 'Selecciona el test que quierar realizar'
            ]);

        return $this->render('form', [
            'testId' => $testId
        ]);
    }

    public function actionGetNewForTest($testId)
    {
        \Yii::$app->response->format = 'json';

        $test = Test::findOne($testId);
        if(!$test) return ['status' => 0];

        $questions = array();
        foreach ($test->questions as $key => $question) {
            $questions[$key] = [
                'question' => $question,
                'options' => $question->options
            ];
        }
        return ['status' => 1, 'test' => $test, 'questions' => $questions];
    }

    /**
     * Finds the Examination model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Examination the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Examination::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
