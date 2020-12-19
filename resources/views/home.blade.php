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
                    if(data == "LOGIN") {
                        window.location.reload();
                    } else {
                        ShowError("Login incorrect. Please try again.");
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function ShowError(err) {
            $("#errormsg").html(err);
            $("#errormsg").css("display", "block");
        }

        function SubmitKey() {
            var userid = $("#userid")[0].value;
            var gamekey = $("#inputgamekey")[0].value;
            var gamename = $("#inputgamename")[0].value;

            var data = {"_token": "{{ csrf_token() }}", "gamename": gamename, "gamekey": gamekey};

            $.ajax({
                url: "/submitkey",
                method: "POST",
                data: data,
                success: function(data) {
                    if(data == "SUCCESS") {
                        ShowSuccessKey();
                    } else {
                        console.log(data);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function ShowSuccessKey() {
            $("#keysubmit").css("display", "block");

            setTimeout(function() {
                window.location.reload();
            }, 4000);
        }

        function RemoveKey(keyid) {
            var data = {"_token": "{{ csrf_token() }}", "gameid": keyid};

            $.ajax({
                url: "/removekey",
                method: "POST",
                data: data,
                success: function(data) {
                    if(data == "SUCCESS") {
                        window.location.reload();
                    } else {
                        console.log(data);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap" rel="stylesheet"> 

    <style>
        body {
            background-image: url("https://i.ibb.co/w6QZXqK/christmas-snow-gif-2.gif");
            /* background-image: url("https://www.google.com/url?sa=i&url=http%3A%2F%2Fclipart-library.com%2Fsnowy-animated-cliparts.html&psig=AOvVaw1WoKU8MuYBCAGr4ICpRR6b&ust=1608302388023000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCJCBuraf1e0CFQAAAAAdAAAAABA9"); */
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Merriweather', serif;
        }

        .inputheader {
            margin: 0;
            margin-top: 20px;
        }

        .container {
        }

        .card {
            border: 2px solid black;
            background-color: #ecf0f1;
        }

        .card-header {
            font-weight: 800;
            font-size: 28px;
        }

        .gamekeycontainer {
            width: 100%;
            margin-top: 50px; 
            background-color: #34495e; 
            color: white; 
            border: 1px solid black;
        }

        table {
        }

        tr {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        
        td, th {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-right: 1px solid black;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center; border-bottom: 2px solid black; background-color: #34495e; color: white;">Koopagno Secret Santa 2020</div>

                <div class="card-body">
                    @if (Auth::user() != null) 
                        <p style="text-align: center; text-transform: uppercase; font-size: 24px; font-weight: 800;"><u>{{Auth::user()->name}}</u></p>

                        <div style="width: 100%; padding-top: 50px; padding-bottom: 50px; background-color: #95a5a6; border: 1px solid black; text-align: center;">
                            <h3 style="margin-bottom: 50px; font-weight: 700;">Game Key Submission</h3>
                            <form action="/api/submitkey" method="post">
                                <input id="userid" name="userid" type="hidden" value="{{Auth::id()}}" />
                                <p class="inputheader">Game Key (Put "Gift" if it's a steam gift):</p>
                                <input id="inputgamekey" name="gamekey" type="text" placeholder="AAAAAA-AAAAAA-AAAAAA" autocomplete="off"/>
                                <p class="inputheader">Game Name:</p>
                                <input id="inputgamename" name="gamename" type="text" placeholder="Rudolph Massacre Simulator" autocomplete="off" />
                                <br/>
                                <br/>
                                <button type="button" onclick="SubmitKey()" style="background-color: white; border: 1px solid black; color: black; padding: 10px; padding-left: 20px; padding-right: 20px;">
                                    Submit
                                </button>
                            </form>
                        </div>

                        <div class="gamekeycontainer">
                            <table style="width: 100%;">
                            <tr>
                                <th>Game Name</th>
                                <th>Game Key</th>
                                <th></th>
                            </tr>
                            @if(ISSET($keys))
                                @foreach($keys as $key)
                                <tr>
                                    <td>{{$key->gamename}}</td>
                                    <td>{{$key->key}}</td>
                                    <td style="text-align: center;">
                                        <p onclick="RemoveKey('{{$key->id}}')" style="color: white; background-color: red; margin: 0; cursor: pointer;">
                                            Remove Key
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </table>
                        </div>
                    @else
                        <h2>Login</h2>
                        <form action="/api/loginsanta" method="post">
                            <input id="loginname" type="text" placeholder="Name" />
                            <br/>
                            <input id="loginpass" type="password" placeholder="Password" /> 
                            <br/>
                            <button type="button" onclick="Login()">Login</button>
                        </form>
                        <p id="errormsg" style="color: red; font-size: 14px;"></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="keysubmit" style="display: none; position: static; left: 0; top: 0; width: 100%; height: 100%; z-index: 500; background-color: rgba(0,0,0,0.9);">
    <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center;">
        <p style="color: white; text-transform: uppercase; font-size: 32px; font-weight: 800;">Your key has been sacrificially consumed by Santa's grubby little hands.</p>
        <img src="https://cdn.lowgif.com/full/75a352671f906739-dancing-christmas-snow-gif-on-gifer-by-agardana.gif">
        <p style="color: white; text-transform: uppercase; font-size: 32px; font-weight: 800; padding-top: 20px;">Thank you for your cooperation in feeding Santa.</p>
    </div>
</div>
@endsection
