<div class="">
    <div class="">
        <i class="fas fa-quote-left mr-2 grey"></i>
         {!!$comment->content()!!} 
         <i class="fas fa-quote-right ml-2 grey"></i>
        <?php $discussion = $comment->discussion ?>
         @include('discussion.widgets.snippet')
    </div>
</div>
