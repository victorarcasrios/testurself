<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>¡Bienvenido a <small>TestUrSelf</small>!</h1>

        <p class="lead">Crea tus propios tests y autoevaluate ya</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 well alert-warning">
                <h2>Preguntas</h2>

                <p>Crea preguntas con hasta 4 opciones. Convierteté en tu propio profesor</p>

                <p><a class="btn btn-warning" href="<?= Yii::$app->urlManager->createUrl('questions/create') ?>">
                    Nueva pregunta &raquo;</a></p>
            </div>
            <div class="col-lg-4 well alert-success">
                <h2>Tests</h2>

                <p>Crea tus propios tests sin máximo de preguntas, agrupando las preguntas que creaste</p>

                <p><a class="btn btn-success" href="<?= Yii::$app->urlManager->createUrl('tests/create') ?>">Nuevo test &raquo;</a></p>
            </div>
            <div class="col-lg-4 well alert-info">
                <h2>Autoevalúate</h2>

                <p>Realiza tus tests y observa los resultados. No necesitas nada más. Los tests son
                    corregidos al instante.</p>

                <p><a class="btn btn-info" href="<?= Yii::$app->urlManager->createUrl('tests/index') ?>">Víctor Arcas Ríos &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
