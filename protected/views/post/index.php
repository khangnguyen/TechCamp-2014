<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Posts',
);

$this->menu=array(
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>Posts</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'post-grid',
    'dataProvider'=>$model->search($_SERVER['REMOTE_ADDR']),
    'filter'=>$model,
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
            'header'=>'Vote'
      ),
    ),
)); ?>

<script>
  $(function() {
    $(".js-vote-btn").click(function(e) {
      var $this = $(this);
      $.ajax({
        type: "POST",
        url: "/post/vote",
        data: {
          'id': '<?=$_SERVER['REMOTE_ADDR']?>',
          'post_id': $this.data('id'),
        },
        dataType: "json",
        success: function(data) {
          if (data.status === 'Success') {
            var $countBox = $this.parent().siblings('.js-vote-count');
            $countBox.html(parseInt($countBox.html()) + 1);
            $this.parents('.js-vote-container').html('You have successfully voted for this topic.');
          }
        }
      });
    });
  });
</script>