<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;

$items = Category::find()
->select(['name'])
->indexBy('id')
->column();

/** @var yii\web\View $this */
/** @var app\models\Request $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_user')->hiddenInput([
        'value'=> Yii::$app->user->identity->getId()
    ])->label(false) ?>

    <?= $form->field($model, 'id_category')->dropDownList([
        $items
    ],
    ['prompt'=>'Выбор категории']) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gos_number')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '9AAA99 RUS 99',]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
