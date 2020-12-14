@extends('layouts.santa')

@section('head')
    <script>
        function Login() {
            var username = $("#loginname")[0].value;
            var password = $("#loginpass")[0].value;

            var data = {"_token": "{{ csrf_token() }}", "username": username, "password": password};

            $.ajax({
                url: "/loginsanta",
                method: "POST",
                data: data,
                success: function(data) {
                    console.log(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} -->

                    @if (Auth::user() != null) 
                        {{ __('You are logged in!') }}
                    @else
                        <h2>Login</h2>
                        <form action="/api/loginsanta" method="post">
                            <input id="loginname" type="text" placeholder="Name" />
                            <br/>
                            <input id="loginpass" type="password" placeholder="Password" /> 
                            <br/>
                            <button type="button" onclick="Login()">Login</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
