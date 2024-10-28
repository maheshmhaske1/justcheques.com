@extends('layouts.app')

@section('content')
<section class="mid-content   ">

    <div class="container">
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div id="navBreadCrumb"> <a href="/">Home</a>&nbsp;<span class="separator">//</span>&nbsp;
            Login
        </div>
        <div class="row">
            <div class="col-md-6"> <!-- bof  breadcrumb -->

                <gcse:searchresults></gcse:searchresults>
                <div class="headerWrapper">
                    <h1 id="loginDefaultHeading">Ready to Make a Purchase?</h1>
                    <p class="loginpagesub-heading">Please create an account or sign in with an exisiting account.</p>
                </div>
                <div class="desk-err-log-ms">
                </div>
                <div class="split-mode row">
                    <div class="">
                        <div id="register" class="forward">
                            <fieldset>
                                <h2>New Account</h2>
                                <div class="information">Create a Account Profile with <strong>Cheques
                                        Plus</strong> which allows you to shop faster, track the status of your
                                    current orders, review your previous orders and take advantage of our other
                                    member's benefits.</div>

                                <a href="register">
                                    <div class="buttonRow back" id="register-button"><input
                                            class="cssButton submit_button button  button_create_account"
                                            type="submit" value="Sign Up"></div>
                                </a>
                            </fieldset>
                        </div>
                    </div>
                    <div class="hid_er_log_in">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="centerColumn" id="loginDefault">

                    <div class="">
                        <div id="login" class="back">

                            <fieldset>
                                <h2>Login Account</h2>
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
                                    <p>
                                        <label class="inputLabel" for="login-email-address">Email Address:</label>
                                        <input type="text" name="email" size="18"
                                            id="email">
                                    </p>
                                    <p>
                                        <label class="inputLabel" for="login-password">Password:</label>
                                        <input type="password" name="password" size="18" id="password">
                                    </p>

                                    <div class="buttonRow back"><input
                                            class="cssButton submit_button button  button_login" type="submit"
                                            value="Sign In"></div>
                                    <div class="buttonRow back important"><a href="#">Forgot your
                                            password?</a>
                                        |
                                        <a href="#">Having Problems Logging in? Click Here and try
                                            logging in again</a>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- top-inr-part -->
    </div>
    </div><!-- row -->
</section>
@endsection