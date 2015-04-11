<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Question;
use app\models\Option;

class QuestionsController extends Controller
{

	public function actionIndex()
	{
		return $this->render('index');
	}	

	// CREATE

	public function actionCreate()
	{
		if( Yii::$app->request->isGet )
			return $this->render('form', [
				'mode' => 'create'
			]);
		else if( Yii::$app->request->isAjax && Yii::$app->request->isPost )
			return $this->create(Yii::$app->request->post('question'));
	}

	private function create($data)
	{
		$question = new Question();
		$question->text = $data['text'];
		$question->user_id = 1;
		$question->save();

		foreach($data['options'] as $option){
			$this->createOptionFor($option, $question->id);
		}

		return 1;
	}

	private function createOptionFor($data, $questionId)
	{
		$option = new Option();
		$option->question_id = $questionId;
		$option->text = $data['text'];
		$option->correct = filter_var($data['correct'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
		$option->save();
	}

	// READ

	public function actionList()
	{
		\Yii::$app->response->format = 'json';
		return ['status' => 1, 'questions' => Question::find()->all()];
	}

	public function actionGet($id)
	{
		\Yii::$app->response->format = 'json';

		$question = Question::findOne($id);
		if(! $question) return ['status' => 0];

		return  
			['status' => 1, 
			'question' => 
				['id' => $question->id,
				'text' => $question->text,
				'options' => $question->options]
		];
	}

	// UPDATE

	public function actionEdit($id = false)
	{
		if( Yii::$app->request->isGet )
			return $this->render('form', [
				'mode' => 'edit',
				'id' => $id
			]);
		else if(Yii::$app->request->isAjax && Yii::$app->request->isPost)
			return $this->edit(Yii::$app->request->post('question'));
	}

	private function edit($data)
	{
		$question = Question::findOne($data['id']);
		if(! $question) return 0;

		$question->text = $data['text'];
		$question->save();
		$this->updateOptions($data['options'], $question->options);

		return 1;
	}

	private function updateOptions($newData, $options)
	{
		foreach($options as $key => $option){
			$option->text = $newData[$key]['text'];
			$option->correct = filter_var($newData[$key]['correct'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
			$option->save();
		}
	}

	// DELETE

	public function actionDelete()
	{
		$notProperlyAccessed = !(Yii::$app->request->isAjax && Yii::$app->request->isPost);
		if( $notProperlyAccessed ) return 0;
		
		$id = Yii::$app->request->post('id');
		$question = Question::findOne(['id' => $id]);
		$question->delete();
		return 1;
	}

}