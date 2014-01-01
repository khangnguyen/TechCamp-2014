<? 
  if (!isset($_COOKIE['authentication'])) {
    $userKey = md5(uniqid(rand(), true));
    setcookie('authentication', $userKey, time() + (10 * 365 * 24 * 60 * 60));
  } else {
    $userKey = $_COOKIE['authentication'];
  }
?>

<p class="js-vote-count"><?= $model->voteCount ?></p>
<p class="js-vote-container">
  <? if ($model->vote_id) { ?>
    Voted
  <? } else { ?>
    <input type="button" value="Vote"
           class="js-vote-btn" data-id="<?=$model->id?>"
           data-userkey="<?=$userKey?>"/>
  <? } ?>
</p>