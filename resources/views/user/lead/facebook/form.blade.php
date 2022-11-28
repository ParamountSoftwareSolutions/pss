@extends('user.layout.app')
@section('title', 'Property')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
							 <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>:Ads Table</h4>
                            </div>
                            <ul class="list-group">
                                @if(!empty($data->data))
                                @foreach ($data->data as $value)
                                 <li class="list-group-item"><a href="{{route('webhook.leads', ['RolePrefix' => RolePrefix(),$value->id,$token])}}">{{$value->name}}</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
{{--<script>
            function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
                console.log('statusChangeCallback');
                console.log(response);                   // The current login status of the person.
                if (response.status === 'connected') {   // Logged into your webpage and Facebook.
                    testAPI();
                } else {                                 // Not logged into your webpage or we are unable to tell.
                    document.getElementById('status').innerHTML = 'Please log ' +
                        'into this webpage.';
                }
            }


            function checkLoginState() {               // Called when a person is finished with the Login Button.
                FB.getLoginStatus(function (response) {   // See the onlogin handler
                    statusChangeCallback(response);
                });
            }


            window.fbAsyncInit = function () {
                FB.init({
                    appId: '760962731817972',
                    cookie: true,                     // Enable cookies to allow the server to access the session.
                    xfbml: true,                     // Parse social plugins on this webpage.
                    version: 'v14.0'           // Use this Graph API version for this call.
                });


                FB.getLoginStatus(function (response) {   // Called after the JS SDK has been initialized.
                    statusChangeCallback(response);        // Returns the login status.
                });
            };

            function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function (response) {
                    console.log('Successful login for: ' + response);
                    document.getElementById('status').innerHTML =
                        'Thanks for logging in, ' + response + '!';
                });
            }

        </script>--}}


<!-- The JS SDK Login Button -->





<!-- Load the JS SDK asynchronously -->
{{--<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>--}}

@endsection
