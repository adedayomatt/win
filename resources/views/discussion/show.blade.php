@extends('layouts.app50-50LHSfixed')
@section('styles')
    [data-role = 'unlike']{
        color: red;
    }
    .comment-area{
        position: fixed; 
        z-index: 1111;
        left: 0;
        bottom: 0;
        width: 100%;
    }
@endsection
@section('md-styles')
    .comment-seperator{
        height: 150px;
        }
    .comment-area{
        width: 50%;
        right:0;
        left: unset;
    }
@endsection
@section('after-nav')
    @include('components.modal.comment-reply')
@endsection

@section('LHS')
    <div class="card mt-2  border-0">
        <div class="card-body">
            <div class="card-title">
            @if($discussion->isMine())
                <div class="float-right">
                    @include('discussion.widgets.options')
                </div>         
             @endif
            <h5>{{$discussion->title}}</h5>
            @include('discussion.widgets.meta')
            @if($discussion->fromTraining())
                <div class="ml-2">
                    @include('training.widgets.snippet', ['training' => $discussion->training()])
                </div>
            @endif
            </div>
            {!! $discussion->content('full') !!}
            @include('tag.widgets.inline', ['tags' => $discussion->tags])
        </div>
    </div>
    <h6>Contributors ({{$discussion->contributions()->get()->count()}})</h6>
    <div class="">
        @if($discussion->contributions()->count() > 0)
            @include('components.owl-carousel', ['carousel_collection' => $discussion->contributions()->get(), 'carousel_template'=> 'discussion.templates.carousel-contributor', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3]])
        @else
            <div class="content-box text-muted text-center">
                No contributor yet
            </div>
        @endif
    </div>
    <h6>Related Discussions</h6>
    @if($discussion->relatedDiscussions()->count() > 0)
        @include('components.owl-carousel', ['carousel_collection' => $discussion->relatedDiscussions(), 'carousel_template' => 'discussion.templates.carousel-default', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3]])
    @else
        <div class="content-box text-muted text-center">
            No related discussion
        </div>
    @endif
@endsection

@section('RHS')
    <div class=" anchor" id="comments"></div>
    <div class="row">
        <div class="col-12 col-no-padding-xs">
            <div class="widget" style="background-color: inherit">
                <div class="">
                    <h6>Comments (<span class="figure">{{$discussion->comments->count()}}</span>)</h6>
                </div>
                <div class="comments-container">
                    @if($discussion->comments->count() > 0)
                        @include('comment.comments')
                    @else
                        <div class="content-box text-muted text-center">
                            <small class="">No comment yet</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-no-padding-xs">
        </div>
    </div>
    <div class="comment-seperator"></div>
    @include('comment.create')

@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
    <script>
        $('.comments-container').on('submit','form.comment-like',function(e){
         e.preventDefault();
        var form = $(this);
        var btn = $(this).find('[type = "submit"]');
        var counter = $(this).find('.likes-counter');
        if(auth()){
            request(
                url = form.attr('action'),
                method = 'POST',
                data =  {
                    _token: form.find('[name="_token"]').val(),
                    async: 1,
                    },
                success = function(response){
                    if(btn.data('role') == 'like'){
                        btn.attr('data-role','unlike');
                        btn.attr('title','unlike');
                    }
                    else if(btn.data('role') == 'unlike'){
                        btn.attr('data-role','like');
                        btn.attr('title','like');
                    }
                    toastr.success(response.message);
                    counter.text(response.count);
                },
                fail = function(status){
                    toastr.error(`failed: ${status}`);
            })
        }
        else{
            toastr.info('Sign in first!');
        }
	})

    </script>
@endsection