<!-- Modal -->
<div class="modal fade" id="commentReply" tabindex="-1" role="dialog" aria-labelledby="commentReplyTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="commentReplyTitle">Comment reply</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card border-0">
            <div class="card-body">
            <div class="snippet">
                <h5 class="commenter"></h5>
                <div class="comment-snippet"></div>
            </div>
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
{{-- 
<script>
    $('#commentReply').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var discussion = button.data('discussion');
    var comment = button.data('comment');
    var commenter = button.data('commenter');
    var replyFormContainer = button.data('reply-form');
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.commenter').text(commenter);
    modal.find('.modal-title').text('Reply to ' + commenter + '\'s comment on '+discussion);
    modal.find('.comment-snippet').html(comment);
    modal.find('.modal-body .card-body').html($(replyFormContainer).html());
    })
</script> --}}