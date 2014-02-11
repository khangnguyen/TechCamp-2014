  $(function() {
    $(".js-vote-btn").live('click', function(e) {
      var $this = $(this);
      $.ajax({
        type: "POST",
        url: "http://techcamp.vn/voting/topic/vote",
        data: {
	  'id': $this.data('userkey'),
          'topic_id': $this.data('id')
        },
        dataType: "json",
        success: function(data) {
          if (data.status === 'Success') {
            var $countBox = $this.parent().siblings('.js-vote-count');
            $countBox.html(parseInt($countBox.html()) + 1);
            $this.parents('.js-vote-container').html('Voted');
          }
        }
      });
    });
  });
