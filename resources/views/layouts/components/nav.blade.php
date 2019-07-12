<nav class="navbar navbar-expand-lg fixed-top">
  <a class="navbar-brand white" href="{{route('home')}}">{{config('app.name')}}</a>
  
  <form class="form-inline my-2 my-lg-0" id="tag-search-wrapper">
        @include('tag.components.search')
 </form>

  <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#nav-collapse" aria-controls="nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars color-primary"></i>
  </button>

  <div class="collapse navbar-collapse" id="nav-collapse">

   <ul class="navbar-nav ml-auto">
    <li class="nav-item ">
            <a href="{{route('forums')}}" class="nav-link" >
                Forums
            </a>
      </li>
      <li class="nav-item ">
            <a href="{{route('discussions')}}" class="nav-link" >
                Discussions
            </a>
      </li>
      <li class="nav-item ">
            <a href="{{route('trainings')}}" class="nav-link" >
                Trainings
            </a>
      </li>
      <li class="nav-item ">
            <a href="{{route('users')}}" class="nav-link" >
                Users
            </a>
      </li>
    </ul>

   

  <div class="navbar-nav">
    <div class="owl-carousel owl-theme" data-xs="2" data-sm="2" data-md="3" data-lg="3" style="width: 300px; overflow:auto">
          @foreach($_tags::trending() as $trend)
              <a href="{{route('tag.show',[$trend->tag->slug])}}" class="nav-link" title="{{$trend->tag->name}} - {{$trend->tag->description}}">
                  <small>#{{str_limit($trend->tag->name, 10)}}</small> 
              </a>
          @endforeach
      </div>
  </div>
   
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="{{route('tags')}}" class="nav-link" >
              All tags
          </a>
      </li>
    </ul>
    @auth()
    <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
              <a href="{{route('discussion.create')}}" class="btn btn-theme btn-sm" >
                  <i class="fa fa-plus"></i> New discussion
              </a>
        </li>

    </ul>
    @endauth()
    <ul class="navbar-nav ml-auto">
        @auth()

              <li class="nav-item dropdown">

                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{auth()->user()->avatar()['src']}}" alt="{{auth()->user()->avatar()['alt']}}" class="avatar avatar-xs">
                      {{ auth()->user()->username }} <span class="caret"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                            
                    <a class="dropdown-item" href="{{route('user.profile',[Auth::user()->username])}}">
                      <img src="{{auth()->user()->avatar()['src']}}" width="20px" height="20px" class="avatar"> My profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('tag.create')}}">create tag</a>
                    <div class="dropdown-divider"></div>
                    @if(Auth::user()->isVerified())
                      <a class="dropdown-item" href="{{route('training.create')}}">create training</a>
                      <div class="dropdown-divider"></div>
                    @endif

                      <a class="dropdown-item" href="{{route('forum.create')}}">create forum</a>
                      <div class="dropdown-divider"></div>

                      <a class="dropdown-item" href="{{route('discussion.create')}}">create discussion</a>
                      <div class="dropdown-divider"></div>


                      <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </div>
              </li>
          @endauth
        @guest()
        <li class="nav-item text-right">
            <a href="{{route('login')}}" class="btn btn-default btn-sm mx-1">Sign in</a>
            <a href="{{route('register')}}" class="btn btn-default btn-sm mx-1">Sign up</a>
        </li>
           
        @endguest
    </ul>

<!-- Right Side Of Navbar -->
  </div>
</nav>
  @include('layouts.components.alerts')
@yield('after-nav')