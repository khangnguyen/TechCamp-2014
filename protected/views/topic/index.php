<? 
  if (!isset($_COOKIE['authentication'])) {
    $userKey = md5(uniqid(rand(), true));
    setcookie('authentication', $userKey, time() + (10 * 365 * 24 * 60 * 60));
  } else {
    $userKey = $_COOKIE['authentication'];
  }
?>

<base target="_parent" />

* You can filter using the two little text boxes beneath the titles and sort by clicking on the title bars

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'topic-grid',
    'dataProvider'=>$model->search($userKey),
    'filter'=>$model,
    'template'=>"{pager}\n{items}\n{pager}",
    'columns'=>array(
      array( 
            'name'=>'title',           
            'value'=>array($this, 'renderTopic'),
            'header'=>'Topics',
      ),
      array(
            'name'=>'speaker_name',            
            'value'=>array($this, 'renderSpeaker'),
            'header'=>'Speakers',
      ),
      array(
            'name'=>'id',
            'value'=>array($this, 'renderVote'),
            'header'=>'Votes',
	    'filter'=>false
      ),
    ),
)); ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vote.js"></script>
