<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.components.meta-head')
        @include('layouts.components.head-scripts')
        @include('layouts.components.styles')
        <style>
            body{
                background-color: #F5F8FA;
            }
        </style>
    </head>
    <body>
        <div id="app">
            @include('layouts.components.plain-nav')            
            <main>
                <div id="app-accordion">
                    <div class="container-fluid">
                        <div class="content">
                            @yield('main')
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('layouts.components.bottom-scripts')
    </body>
</html>
