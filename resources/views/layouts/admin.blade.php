<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @notifyCss

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel-admin') }} admin
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest('admin')
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre onclick="deleteNotification()">
                                    Notifications <span style="font-weight: bold;" id="notification"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 300px;">
                                    @foreach(Auth::guard('admin')->user()->notifications as $notification)
                                        @if($notification->read_at)
                                            <p>{{$notification->data['msg']}}</p>
                                        @else
                                            <p style="font-weight: bold;">{{$notification->data['msg']}}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('admin')->user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

 <!-- Scripts -->
 <script src="{{ mix('js/app.js') }}"></script>
 @notifyJs
 
    <script>

        const element = document.getElementById("notification");
        if(localStorage.getItem('total')){
                element.innerHTML  = localStorage.getItem('total');
        }
        
        //laravel echo for brodcasting
        Echo.channel(`new-user`)
        .listen('NewUserCreatedEvent', (e) => {
            toastr.info('<a href="http://127.0.0.1:8000/user/id">'+ e.user.name + ' has joined!' +'</a>');
            
            if(!localStorage.getItem('total')){
                localStorage.setItem('total',1);
                element.innerHTML  = localStorage.getItem('total');
            }else{
                var total= localStorage.getItem('total');
                localStorage.setItem('total',++total);
                
                element.innerHTML  = localStorage.getItem('total');
            }
        });

        //notification delete
        function deleteNotification() {
            localStorage.removeItem('total');
            element.innerHTML  = null;
        }
        
        
    </script>
    <x:notify-messages />
</body>
</html>
