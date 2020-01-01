
@extends('layouts.appMail')

@section('head')
    @include('mail.snippets.user')
@endsection
@section('body')
    <h4 class="text-center color-primary">Thank you for verifying your email</h4>
    <div>
        <p>Dear <strong>{{$user->firstname}}</strong>, We are so glad to have you join this community.</p>
        <p>This is a community where trainings on different topics are provided by top trainers. You can keep up with your favorite niche by choosing <a href="{{route('tags')}}">tags</a> to follow. The tags you follow will be used to customize what you see on your feed. </p>
        <?php 
            $tag_suggestions = $_tags::whereNotIn('id',$user->interests())->get();
            $training_suggestions = $_trainings::take(3)->get();
            $discussion_suggestions = $_discussions::take(3)->get();
        ?>
        @if($tag_suggestions->count() > 0)
            <p>Here are some suggestions on tags you could follow</p>
            <table>
                @foreach($tag_suggestions as $tag)
                    <tr>
                        <td>
                            @include('mail.snippets.tag')
                        </td>
                        <td class="text-right">
                            <a href="{{route('tag.show',$tag->slug)}}" class="btn">follow</a>
                            {{-- <form action="{{route('tag.follow',[$tag->id])}}" method="POST">
                                @csrf
                                <button type="submit" class="btn">follow</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-right">
                <a href="{{route('tags')}}">see more tags</a>
            </div>
        @endif

        @if($training_suggestions->count() > 0)
            <p>You may also want to check this trainings, they have been resourceful</p>
            @foreach($training_suggestions as $training)
                @include('mail.snippets.training')
                <hr>
            @endforeach
            <div class="text-right">
                <a href="{{route('trainings')}}">see more trainings</a>
            </div>
        @endif

        @if($training_suggestions->count() > 0)
            <p>Remember, {{config('app.name')}} is a community where you can discuss several topics, for example, here are some things your fellow winners are talking about</p>
            @foreach($discussion_suggestions as $discussion)
                @include('mail.snippets.discussion')
                <hr>
            @endforeach
            <div class="text-right">
                <a href="{{route('discussions')}}">see more discussions</a>
            </div>
        @endif


        <p>You can now create your own tag, forums, discussions and contribute to other discussions</p>
        <div class="text-center">
            <a href="{{route('tag.create')}}" class="btn">create tag</a>
            <a href="{{route('forum.create')}}" class="btn">create forum</a>
            <a href="{{route('discussion.create')}}" class="btn">create discussion</a>
        </div>
        <div class="text-center">
            <h4>We say welcome once again!</h4>
        </div>
       
    </div>
@endsection