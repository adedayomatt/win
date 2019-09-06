<link rel="stylesheet" href="{{asset('css/app.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('css/b/layouts.css')}}">
<link rel="stylesheet" href="{{asset('css/b/styles.css')}}"> 

<!--
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/app.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/toastr.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/select2.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/vendors/owl.carousel.min.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/b/layouts.css">
<link rel="stylesheet" href="http://169.254.56.90/wyzi/public/css/b/styles.css">
 -->

<style>
    body{
        background-color: #fafafab8;
    }
    nav.navbar{
      background-color: #F1F1F1;
      box-shadow: 0px 3px 3px rgba(0,0,0,.2)
    }
    .top-alert{
      position:fixed; 
       z-index: 200;
       left:0;
        right: 0;
    }
  .global-search,
  .tag-search,
  .discussion-search,
  .training-search,
  .forum-search,
  .user-search,
  .school-search,
  .company-search
  {
        width: 300px !important;
    }
  nav .global-search{
    border: 0;
    border-radius: 0;
  }
.dropdown-toggle.no-icon::after{
  content: unset;
}
.btn{
  border: none;
}
.btn:focus,
.btn:active{
  border: none;
}
.bg-primary,
a.btn-primary,
a.btn-theme,
a[role='tab'],
.btn-primary,
.btn-theme,
.list-group.ball-bullet .list-group-item:hover .bullet
{
  background-color: {{primaryColor()}} !important;
}
a.btn-secondary,
.btn-secondary{
  background-color: {{secondaryColor()}} !important;
}
.color-primary,
nav.navbar .nav-link,
h1,h2,h3,h4,h5,h6,
a:hover,
nav.navbar .owl-carousel a,
.btn-default,
a.btn-default,
a.btn-secondary,
.btn-secondary
{
  color: {{primaryColor()}} !important;
}
a[role='tab'],
a.btn-primary,
a.btn-theme,
.btn-primary,
.btn-theme
{
  color: #fff !important;
}
a[role='tab'].active,
.btn-default
{
  background-color: #fff !important;
}
textarea.textarea{
  height: 100px !important;
}
.no-whitespace{
  white-space: unset;
}
.card,
.card-body{
  border: none;
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
.closer{
    font-size: 20px;
    color: red;
    font-weight: bolder;
    cursor: pointer;
}

    @yield('styles')

    @media(max-width: 576px){
        .container-fluid{
        padding-left: 0;
        padding-right: 0;
        }
        .lhs-fixed-head{
          position: fixed;
          z-index: 1029;
          left:0;
          right: 0;
}
        @yield('xs-styles')
    }

    @media(min-width: 576px){
        @yield('sm-styles')
    }

    @media (min-width: 768px){
        nav .global-search{
        width: 300px !important;
        }
        nav .global-search-wrapper{
            margin-left: 50px
        }
        .top-alert{
          right:20%; 
          left:20%;
        }
     


        @yield('md-styles')
    }

</style>
