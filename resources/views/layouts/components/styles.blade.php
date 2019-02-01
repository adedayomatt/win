<!-- <link rel="stylesheet" href="{{asset('css/vendors/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/b/layouts.css')}}">
<link rel="stylesheet" href="{{asset('css/b/styles.css')}}"> -->

<link rel="stylesheet" href="http://wyzi.io/css/vendors/bootstrap-4.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/vendors/toastr.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/vendors/select2.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/b/layouts.css">
<link rel="stylesheet" href="http://wyzi.io/css/b/styles.css">
<style>
    body{
        background-color: #fafbfd;
    }
    nav.bg-light{
        background-color: #fff !important;
    }

  .tag-search{
        width: 300px !important;
        border: 0;
        background-color: #f7f7f7 !important;
    }
    @yield('styles')

    @media(max-width: 576px){
        .container-fluid{
        padding-left: 0;
        padding-right: 0;
        }
        
        @yield('xs-styles')
    }

    @media(min-width: 576px){
        @yield('sm-styles')
    }

    @media (min-width: 768px){
        nav .tag-search{
        width: 400px !important;
        }
        nav .tag-search-wrapper{
            margin-left: 50px
        }

        @yield('md-styles')
    }

</style>
