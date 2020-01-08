<a href="{{route('tag.discussions',[$tag->slug])}}" class="mx-2">{{number_format($tag->discussions->count())}} discussions</a>
<a href="{{route('tag.experiences',[$tag->slug])}}" class="mx-2">{{number_format($tag->experiences->count())}} experiences</a>
<a href="{{route('tag.followers',[$tag->slug])}}" class="mx-2">{{number_format($tag->users->count())}} followers</a>
