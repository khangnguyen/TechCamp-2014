<?php
/* @var $this NotificationController */
/* @var $model Notification */
/* @var $form CActiveForm */
?>

<?= $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'topic-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'columns' => array(
        'sender_name',
        'subject',
        'message',
        'created_at'
    ))); ?>