<!-- <link rel="stylesheet" href="{{asset('css/vendors/bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/b/layouts.css')}}">
<link rel="stylesheet" href="{{asset('css/b/styles.css')}}"> -->

 <!-- <link rel="stylesheet" href="http://wyzi.io/css/vendors/bootstrap-4.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/vendors/toastr.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/vendors/select2.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/vendors/owl.carousel.min.css">
<link rel="stylesheet" href="http://wyzi.io/css/b/layouts.css">
<link rel="stylesheet" href="http://wyzi.io/css/b/styles.css">  -->

<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/bootstrap-4.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/toastr.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/select2.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/owl.carousel.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/b/layouts.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/b/styles.css"> 
<style>
    body{
        background-color: #FAFAFA;
    }
    nav.bg-light{
        background-color: #fff !important;
    }

  .tag-search{
        width: 300px !important;
        border: 0;
        background-color: #f7f7f7 !important;
    }

    /* owl nav */

.owl-theme .owl-nav {
  position: absolute;
  top: 20%;
  left: 0;
  right: 0;
}
/* .owl-theme .owl-nav button:focus{
    box-shadow: none;
    border: none;
    outline-color: none;
} */
.owl-theme .owl-nav .owl-prev,
.owl-theme .owl-nav .owl-next {
  position: absolute;
  height: 100px;
  color: inherit;
  background: none;
  border: none;
  z-index: 100;
}
.owl-theme .owl-nav .owl-prev i,
 .owl-theme .owl-nav .owl-next i {
  font-size: 20px;
  color: #cecece;
}
.owl-theme .owl-nav .owl-prev {
  left: 0;
}
.owl-theme .owl-nav .owl-next {
  right: 0;
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
