@extends('default')
@section('page')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        login success!
        {{-- {{dump( Auth::user()) }} --}}
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