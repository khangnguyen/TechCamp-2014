<? 
  if (!isset($_COOKIE['authentication'])) {
    $userKey = md5(uniqid(rand(), true));
    setcookie('authentication', $userKey, time() + (10 * 365 * 24 * 60 * 60));
  } else {
    $userKey = $_COOKIE['authentication'];
  }
?>

<h1 style="float: left"><?= $model->title; ?></h1>

<p style="float: right">
Votes: <span class="js-vote-count"><?= $model->voteCount ?></span>
<span class="js-vote-container">
  <? if (Vote::model()->findByPK(array('id'=>$userKey, 'topic_id'=>$model->id))) { ?>
  <? } else { ?>
    <input type="button" value="Vote"
           class="js-vote-btn" data-id="<?=$model->id?>"
	   data-userkey="<?=$userKey?>"/>
  <? } ?>
</span>
</p>

<br clear="all"/>

<p>
  <p><?= $model->description ?></p>
  <? if ($model->duration) { ?>
    <p><?= $model->duration ?> minutes</p>
  <? } ?>
  <? if ($model->slide_url) { ?>
    <p>
      <a href="<?= $model->slide_url ?>" target="_blank">Link</a>
    </p>
  <? } ?>
</p>

<p style="margin-top: 30px">
  <h5>By <?= $model->speaker_name ?></h5>

  <? if ($model->speaker_description) { ?>
    <p><?= $model->speaker_description ?></p>
  <? } ?>

  <? if ($model->speaker_url) { ?>
    <p>
      <a href="<?= $model->speaker_url ?>" target="_blank">Link</a>
    </p>
  <? } ?>  
</p>

    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'techcampsaigon'; // required: replace example with your forum shortname
        //var disqus_url = 'http://localhost:9250/topic/view/id/2/title/1+This+is+awesome+man';
        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vote.js"></script>