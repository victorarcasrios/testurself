<?php

namespace app\controllers;

use Yii;
use app\models\Examination;
use app\models\Test;
use app\models\TestQuestion;
use app\models\Answer;
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        \Yii::$app->response->format = 'json';

        $output = array();
        $examinations = Examination::find()->all();

        foreach($examinations as $key => $examination){
            $output[$key] = ['examination' => $examination, 'test' => $examination->test];
        }
        return $output;
    }

    /**
        EDITION
    */

    public function actionNew($testId = false)
    {
        if(!$testId)
            return $this->render('/tests/index', [
                'infoMessage' => 'Selecciona el test que quierar realizar'
            ]);

        $examination = $this->generateExamination($testId);

        return $this->render('form', [
            'id' => $examination->id,
            'testId' => $testId
        ]);
    }

    private function generateExamination($testId)
    {
        $examination = new Examination();
        $examination->user_id = 1;
        $examination->test_id = $testId;
        $examination->save();
        return $examination;
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

    public function actionSaveAnswers()
    {
        \Yii::$app->response->format = 'json';
        $data = Yii::$app->request->post();
        $examination = Examination::findOne($data['examinationId']);
        $test = $examination->test;
        $answers = $data['answers'];

        return $this->saveAnswers($examination, $test, $answers);
    }

    private function saveAnswers($examination, $test, $answers)
    {
        foreach($answers as $answerData)
        {
            $optionId = $answerData['selected'];
            $questionId = $answerData['question']['id'];
            
            ## Test question not found
            $testQuestion = TestQuestion::findOne(['test_id' => $test->id, 'question_id' => $questionId]);
            if(!$testQuestion) continue;

            ## Look for answer
            $answer = Answer::findOne([
                'examination_id' => $examination->id,
                'test_question_id' => $testQuestion->id
            ]);

            ## New
            if(!$answer)
                if( !$this->newAnswer(new Answer(), $examination->id, $testQuestion->id, $optionId) ) return 0;
            ## Or existent
            $answer->option_id = intval($optionId);
            if( !$answer->save() ) return 0;
        }
        return 1;
    }

    private function newAnswer($answer, $examinationId, $testQuestionId, $optionId)
    {
        $answer->examination_id = $examinationId;
        $answer->test_question_id = $testQuestionId;
        $answer->option_id = $optionId;
        return $answer->save();
    }

    public function actionContinue($id)
    {
        $examination = Examination::findOne($id);

        if(!$examination || $examination->status == 0)
            return $this->render('index');

        return $this->render('form', [
            'id' => $examination->id,
        ]);
    }

    public function actionGet($id)
    {
        \Yii::$app->response->format = 'json';

        $examination = Examination::findOne($id);
        $test = $examination->test;

        $questions = array();
        foreach ($test->questions as $key => $question) {
            $questions[$key] = [
                'question' => $question,
                'options' => $question->options
            ];
            if($selected = $question->getAnswer($examination))
                $questions[$key]['selected'] = $selected->option_id;
        }
        return ['status' => 1, 'test' => $test, 'questions' => $questions];
    }

    public function actionClose($id)
    {
        $examination = Examination::findOne($id);
        $userCantCloseIt = false; //$examination->user->id !== Yii::$app->user->identity->id;

        if($userCantCloseIt)
            throw new NotFoundHttpException("There's no any examination with this id");
        else{
            $examination->status = 0;
            $examination->save();
            return $this->render('results', ['examination' => $examination]);            
        }
    }

    public function actionResults($id)
    {
        $examination = Examination::findOne($id);

        return $this->render('results', [
            'examination' => $examination
        ]);
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
