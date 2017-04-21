<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Goal */

$this->title = 'Update Goal: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->goal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
