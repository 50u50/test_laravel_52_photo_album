<html>
    <head>
        <title>Album Manager - @yield('title')</title>
    </head>
    <body>
        <h1>Album manager</h1>

        @if(Session::has('message'))
        <p class="flash-message">
            {{ Session::get('message') }}
        </p>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </body>
</html>
