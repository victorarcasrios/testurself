<?php

use app\models\Test;
use app\models\Question;
use app\models\Option;

function fractionToPercent($numerator, $denominator)
{
	return number_format(($numerator/$denominator)*100);
}

$this->title = "Resultados {$examination->test->name} ($examination->date)";

$this->params['breadcrumbs'][] = ['label' => 'Autoevaluaciones', 'url' => ['examinations/index']];
$this->params['breadcrumbs'][] = $this->title;

$score = $examination->score;
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title"><?= $this->title ?></h4>
	</div>
	<div class="panel-body">
		<div class="panel panel-info" style="background-color: cornflowerblue;">
			<a href="#collapseTop" data-toggle="collapse" data-parent="accordion">
				<div class="panel-heading">
					<h4 class="panel-title" style="color: white;">Recuento y puntuación</h4>
				</div>
			</a>
			<div id="collapseTop" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-striped">
								<tbody>
									<tr>
										<th>Correctas</th>
										<td><?= $score['correct'] ?></td>
										<td><?= fractionToPercent($score['correct'], $score['total']) ?>%</td>
									</tr>
									<tr>
										<th>Incorrectas</th>
										<td><?= $score['incorrect'] ?></td>
										<td><?= fractionToPercent($score['incorrect'], $score['total']) ?>%</td>
									</tr>
									<tr>
										<th>Sin responder</th>
										<td><?= $score['notAnswered'] ?></td>
										<td><?= fractionToPercent($score['notAnswered'], $score['total']) ?>%</td>
									</tr>
									<tr>
										<th>Total</th>
										<td><?= $score['total'] ?></td>
										<td></td>
									</tr>
								</tbody>
							</table>							
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--  -->

		<div class="panel panel-info">
			<div class="panel-heading">
				<h4 class="panel-title">Preguntas</h4>
			</div>
			<div class="panel-body">
				<div class="panel-group" id="accordion">
					<?php 
					foreach($examination->test->testQuestions as $key => $tq): 
						$question = $tq->question;
						$isCorrect = $examination->hadAnswered($question->correct[0]);
						$answer = $tq->getExaminationAnswer($examination);
						$wasRight = $question->correct[0]->id == $answer->option_id;
					?>
						<div class="panel panel-<?= $isCorrect ? 'success' : 'danger' ?>">
							<a href="#collapse<?= $key ?>" data-toggle="collapse" data-parent="accordion">
								<div class="panel-heading" style="background-color: <?= $isCorrect ? '#3DF474' : '#F43D5C' ?>">
									<h4 class="panel-title">#<?= $key+1 ?> <small><?= $question->text ?></small></h4>
								</div>
							</a>
							<div id="collapse<?= $key ?>" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="row">
										<?php 
										foreach($question->options as $option): 
											$isSelected = $answer->option->id == $option->id;
										?>
											<div class="col-lg-6" style="height: auto;">
												<div class="alert alert-<?= ($option->correct == 1) ? 'success' : 'danger' ?>">
													<?= $option->text ?>
													<?php if($isSelected): ?>
														<i class="fa fa-<?= ($wasRight) ? 'check' : 'minus' ?>-circle"></i>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>		
			</div>
		</div>
	</div>
</div>
