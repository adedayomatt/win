@if($update === true)
    <form action="{{route('update.interests',[$user->username])}}" method="POST">
        @csrf
        @method('PUT')
        @include('tag.components.select',['prev_tags' =>  $user->tagsFollowing])
        <h6>suggestions</h6>
        @include('tag.widgets.suggestions', ['suggestions_collection' => $_tags::whereNotIn('id',$user->interests())->orderby('name','asc')->get()])
        <input type="submit" class="btn btn-primary" value="update interests">
    </form>
@else
    <form action="{{route('add.interests',[$user->username])}}" method="POST">
        @csrf
        @include('tag.components.select')
        <h6>suggestions</h6>
        @include('tag.widgets.suggestions', ['suggestions_collection' => $_tags::whereNotIn('id',$user->interests())->orderby('name','asc')->get()])
        <input type="submit" class="btn btn-primary" value="update interests">
    </form>
@endif