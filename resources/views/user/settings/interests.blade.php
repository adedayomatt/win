@if($update === true)
    <form action="{{route('update.interests',[$user->username])}}" method="POST">
        @csrf
        @method('PUT')
        <?php $prevTags = $user->tags ?>
        @include('tag.components.attach')
        <input type="submit" class="btn btn-primary" value="update interests">
    </form>
@else
    <form action="{{route('add.interests',[$user->username])}}" method="POST">
        @csrf
        @include('tag.components.attach')
        <input type="submit" class="btn btn-primary" value="update interests">
    </form>
@endif