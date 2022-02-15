@extends('default')
@section('page')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            TODO：
            <ul>
                <li>user login、register "Request" 未設定</li>
            </ul>
            @if(Session::has('errors'))
                {{Session::get('errors')->first()}}
            @endif
            <form id="login_form" action="{{ route('user.login') }}" method="POST">
                @csrf
                <fieldset style="border: 0px;">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="email" placeholder="帳號" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" placeholder="密碼" required>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <a type="submit" class="btn btn-primary mr-2" style="width: 46%; color:white;" onclick="$('#login_form').submit()">登入</a>
                        <a type="button" class="btn btn-secondary" style="width: 46%; color:white;" href="{{ route('registerPage') }}">註冊</a>
                    </div>
                </fieldset>
            </form>
            
            <div class="form-group">
                <a href="{{ route('line.login') }}"><img src="/images/btn_login_base.png"></a>
            </div>
            <div class="form-group">
                <a href="{{ route('google.login') }}"><img src="/images/btn_google_signin_light_normal.png"></a>
            </div>
            <div class="form-group">
                <a href="{{ route('facebook.login') }}"><img src="/images/btn_facebook_login_base.png"></a>
            </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
       
        
    </script>
@endsection
                