@extends('layouts.appError')
@section('title', __('Not Found'))

@section('meta')
    <meta name="description" content="That resource is not found">
    <meta property="og:title" content="Not Found" />
    <meta property="og:description" content="That resource is not found" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('styles')
    form#status-page-search-wrapper>div{
        width: 100%
    }
    .search-container{
        padding: 0 5px
    }
    form#status-page-search-wrapper input.global-search{
        background-color: #fff !important
    }
@endsection

@section('md-styles')
    form#status-page-search-wrapper>div{
        width: 50%;
        margin: auto
    }
@endsection

@section('main')
   <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">We can't find the resource you are looking for.</h4>
            </div>
        </div>
   </div>
   <div class="search-container">
        <form class="form-inline my-2 my-lg-0" id="status-page-search-wrapper">
            <global-search container="#status-page-search-wrapper"></global-search>
    </form>
   </div>

@endsection
