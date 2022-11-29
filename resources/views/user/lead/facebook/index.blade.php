@extends('user.layout.app')
@section('title', 'Property')
@section('style')
<script>
    window.fbAsyncInit = function() {

        FB.init({
            appId: '760962731817972',
            xfbml: true,
            version: 'v14.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function subscribeApp(page_id, page_access_token) {
        console.log('Successfully page acess token', page_access_token);
        FB.api(
            '/' + page_id + '/subscribed_apps',
            'post', {
                access_token: page_access_token,
                subscribed_fields: ['leadgen']
            },
            function(response) {
                console.log('Successfully subscribed page', response);
            }
        );
    }

    function myFacebookLogin() {
        /*FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });*/
        FB.login(function(response) {
            //var check = response);

            FB.api('/me/accounts', function(response) {
                console.log(response);
                var pages = response.data;
                console.log("new data here", pages);
                var ul = document.getElementById('list');
                for (var i = 0, len = pages.length; i < len; i++) {
                    var page = pages[i];
                    var access = page.access_token;
                    var page_id = "webhook/leads_form/" + page.id + "/" + access;
                    var li = document.createElement('li');
                    li.className = "list-group-item";
                    var a = document.createElement('a');
                    a.href = page_id;
                    a.onclick = subscribeApp.bind(this, page.id, page.access_token);
                    a.innerHTML = page.name;
                    li.appendChild(a);
                    //li.innerHTML = page.name;
                    ul.appendChild(li);
                }
            })
        }, {
            scope: ['pages_show_list', 'leads_retrieval', 'pages_manage_metadata', 'pages_read_engagement']
        });
    }
    // 'pages_manage_ads',
</script>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Facebook Pages</h4>


                            <button class="btn btn-primary" onclick="myFacebookLogin()" style="margin-left: auto; display: block;">Login Facebook</button>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="list"></ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')


<!-- The JS SDK Login Button -->





<!-- Load the JS SDK asynchronously -->
{{--<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>--}}

@endsection