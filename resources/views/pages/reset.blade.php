@extends('layouts.main')

@section('heading')

@stop

@section('pagetitle')

    Reset Password

@stop

@section('content')

    @if (isset($message))
        <div class="alert alert-danger">{{ $message }}</div>
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

    <div class="form-page-small">
        <div class="form">

            <!-- Reset Form -->
            <form class="register-form" id="register-form" role="form" method="post" action="{{ url('/reset') }}">
                {{ csrf_field() }}
                    <div class="form-group">
                    <input type="password" placeholder="password" name="password" id="password"/>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="confirm password" name="password_confirmation" id="password_confirm"/>
                </div>
                <input type="hidden" name="code" id="code" value="{{ $code }}"/>
                <button>change password</button>
            </form>
        </div>
    </div>

@stop

@section('footer')

@stop