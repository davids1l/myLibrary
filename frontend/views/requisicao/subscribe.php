<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Requisicao */

// <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
?>
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>
    console.log(mqtt)
</script>
<div class="subscribe-view">

    <h3>Subscrições</h3>

    <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= Html::submitButton('Subscrever', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
