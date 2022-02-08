@extends('default')
@section('page')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(!Auth::check())
                <form id="login_form">
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
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" style="width: 100%; color:white;" onclick="user_login()">登入</button>
                            {{-- <button type="button" class="btn btn-secondary" style="width: 49%">註冊</button> --}}
                        </div>
                    </fieldset>
                </form>
            @endif
            @if(!Auth::check())
                <div class="form-group">
                    <a href="{{ route('line.login') }}"><img class="mb-4" src="/images/btn_login_base.png"></a>
                </div>
            @endif

            @if(Auth::check())
                <ul>
                    <li>user: {{ Auth::user()->name }}</li>
                    <li>email: {{ Auth::user()->email }}</li>
                </ul>
                <div class="form-group">
                    <a href="{{ route('user.logout') }}" type="button" class="btn btn-primary" style="width: 100%; color:white;">登出</a>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        function user_login(){
            $.ajax({
                type: 'POST',
                url: '{{ route('user.login') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#login_form').serialize(),
                success: function(data) {
                    location.reload();
                },
                error: function(data) {
                    console.log(data.responseJSON)
                }
            });
        }
        
    </script>
@endsection
                