@extends('default')
@section('page')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form id="register_form" action="{{ route('user.register') }}" method="POST">
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
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" placeholder="名稱" required>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <a type="button" class="btn btn-secondary" style="width: 100%; color:white;" onclick="$('#register_form').submit()">註冊</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
       
        
    </script>
@endsection
                