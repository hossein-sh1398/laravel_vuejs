<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="CSRF-TOKEN" content="{{csrf_token()}}">
        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{'css/app.css'}}">
        <link rel="stylesheet" type="text/css" href="{{'css/index.css'}}">
    </head>
    <body>
       <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                  <div id="app">
                      <app></app>
                  </div>
                </div>
            </div>
       </div>
       <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    </body>
</html>
