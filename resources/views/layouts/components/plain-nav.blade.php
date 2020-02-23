<init></init>
<nav class="navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand text-primary" href="{{route('home')}}">
        <img src="{{asset('assets/insydelife-logo-146x42.png')}}" alt="insydelife" style="height: 35px" class="">
    </a>
          <ul class="navbar-nav ml-auto">
            @auth()
            <li class="nav-item text-right">
                <a  href="{{route('user.profile',[Auth::user()->username])}}">
                    <img src="{{auth()->user()->avatar()['src']}}" alt="{{auth()->user()->avatar()['alt']}}" class="avatar avatar-xs">
                    {{ auth()->user()->username }}
                </a>
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
  </nav>
    @include('layouts.components.alerts')
  @yield('after-nav')
  