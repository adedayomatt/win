<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
        <title>{{isset($subject) ? $subject : config('app.name')}}</title>
        <style>
            body{
                margin: 0;
                font-family: "Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                line-height: 40px;
            }
            .mail-head,
            .mail-body,
            .mail-foot{
                padding: 20px 10px;
            }
            .mail-head{
                background-color: #fff;
                text-align: center;
                /* box-shadow: 0px 5px 5px rgba(0,0,0,.2); */
            }
            button{
                border: none;
                word-wrap: break-word;
            }
            table{
                width: 100%;
            }
            table td{
                border-bottom: 1px solid #f2f2f2;
            }
            hr{
                height: 1px;
                border: none;
                background-color: #f2f2f2;
            }
            a{
                text-decoration: none;
            }
            .text-left{
                text-align: left;
            }            
            .text-center{
                text-align: center;
            }            
            .text-right{
                text-align: right;
            }
            .white{
                color: #fff;
            }
            .text-muted{
                color: grey;
            }
            .white,
            .btn,
            .btn:hover
           {
                color: #fff;
            }
            .color-primary{
                color: {{primaryColor()}};
            }
            .bg-primary,
            .btn
            {
                background-color: {{primaryColor()}};
            }
            .mail-foot{
                background-color: #f7f7f7;
            }
            .bg-white{
                background-color: #fff;
            }
            .btn{
                padding: 7px 20px;
                border-radius: 5px;
                text-decoration: none;
            }
            .btn:hover{
                text-decoration: none;
            }
            .btn-lg{
                font-size: 25px;
                padding: 10px 30px;
            }
            .d-block{
                display: block;
            }
            .d-flex{
                display: flex;
            }
            .tag{
                color: #000;
                display: inline-block;
                padding: 0 7px;
                background-color: #f7f7f7;
                border: 1px solid #f2f2f2;
                border-radius: 3px;
                margin: 3px 1px;
                font-size: 12px;
                text-decoration: none;
                }
            .tag:hover{
                text-decoration: none;
            }
            .avatar{
                border-radius: 50%;
                width: 50px;
                height: 50px;
            }
            @media (min-width: 768px){
                .mail-body{
                    margin-left: 10%;
                    margin-right: 10%;
                }
            }
        </style>
    </head>
    <body>
        <div class="mail-head">
            <div>
                <img src="{{asset('assets/insydelife-logo-146x42.png')}}" alt="insydelife"><br>
            </div>
            @yield('head')
        </div>
        <div class="mail-body">
            @yield('body')
        </div>
        <div class="mail-foot">
            @yield('foot')
            <div class="text-center">
                <img src="{{asset('assets/insydelife-logo-146x42.png')}}" alt="insydelife" width="70px"><br>
                &copy; {{config('app.name')}}, {{now()->format('Y')}}
            </div>
        </div>
    </body>
</html>