<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
  <a class="navbar-brand" href="{{route('home')}}">{{config('app.name')}}</a>
  
  <form class="form-inline my-2 my-lg-0" id="tag-search-wrapper">
        @include('tag.components.search')
 </form>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-collapse" aria-controls="nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
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
            <a href="{{route('posts')}}" class="nav-link" >
                Posts
            </a>
      </li>
      <li class="nav-item ">
            <a href="#" class="nav-link" >
                Trainings
            </a>
      </li>

              <!-- <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
              </li> -->

    </ul>

    <ul class="navbar-nav ml-auto">
        @auth()


              <li class="nav-item dropdown">

                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="{{auth()->user()->avatar()['src']}}" alt="{{auth()->user()->avatar()['alt']}}" class="avatar avatar-xs">
                      {{ auth()->user()->username }} <span class="caret"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                            
                  
                  <a class="dropdown-item" href="{{route('tag.create')}}">New tag</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{route('post.create')}}">New post</a>
                      <div class="dropdown-divider"></div>

                      <a class="dropdown-item" href="{{route('post.category.create')}}">New post category</a>
                      <div class="dropdown-divider"></div>


                      <a class="dropdown-item" href="{{route('forum.create')}}">New Forum</a>
                      <div class="dropdown-divider"></div>

                      <a class="dropdown-item" href="{{route('discussion.create')}}">New Discussion</a>
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
            <a href="{{route('login')}}" class="btn btn-primary btn-sm">Sign in</a>
            <a href="{{route('register')}}" class="btn btn-success btn-sm ml-3">Sign up</a>
        @endguest
    </ul>

<!-- Right Side Of Navbar -->
  </div>
</nav>
@yield('after-nav')