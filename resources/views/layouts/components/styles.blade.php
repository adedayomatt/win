<link rel="stylesheet" href="{{asset('css/app.css?v='.config('app.version'))}}">
<link rel="stylesheet" href="{{asset('css/vendors/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors/jquery.atwho.min.css')}}">
<link rel="stylesheet" href="{{asset('css/b/layouts.css?v='.config('app.version'))}}">
<link rel="stylesheet" href="{{asset('css/b/styles.css?v='.config('app.version'))}}"> 

<style>
    body{
        background-color: #fff;
    }
    nav.navbar{
      background-color: #fff;
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
  .experience-search,
  .forum-search,
  .user-search,
  .school-search,
  .company-search
  {
        width: 100% !important;
        border: 0;
        border-radius: 0;
        border-bottom: 1px solid {{primaryColor()}};
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

a[role='tab'],
a[role='tab']:hover,
a.btn-primary,
a.btn-theme,
a.btn-theme:hover,
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
a[role='tab'].active,
a[role='tab'].active:hover,
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
textarea.textarea{
  height: 100px !important;
}
.no-whitespace{
  white-space: unset;
}
.break-word{
        word-wrap: break-word;
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
.single-comment{
    cursor: pointer;
    border-radius: 5px;
    padding: 5px

}
  .single-comment-content:hover{
    background-color: #fdfdfd;
  }

    @yield('styles')

    @media(max-width: 576px){
       
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
