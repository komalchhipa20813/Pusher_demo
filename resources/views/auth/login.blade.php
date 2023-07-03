@extends('layout.master2')
@section('title',"Login")
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="login-left ">
                            <a>
                                <img src="{{ url('images/logo.jpg/') }}" alt="Logo">
                            </a>
                        </div>
                        
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- <a href="#" class="noble-ui-logo d-block mb-2">Noble<span>UI</span></a> -->
                            <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>

                            <form class="forms-sample row g-3 needs-validation login_from" method="POST" action="">
                                @csrf
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">User Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="userPassword"
                                        autocomplete="current-password" placeholder="Password">
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="authCheck">
                                    <label class="form-check-label" for="authCheck" name="remember" value="true">
                                        Remember me
                                    </label>
                                </div>
                                <div>
                                    <input type="submit" class="btn btn-primary w-100" value="Login">
                                    <!-- <a href="{{ url('/') }}" class="btn btn-primary me-2 mb-2 mb-md-0">Login</a> -->

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection