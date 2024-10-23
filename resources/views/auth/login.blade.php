@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5">Login</h2>
            <div class="card mt-4">
                <div class="card-body">
                    <form id="login-form">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div id="error-message" class="alert alert-danger d-none"></div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#login-form').submit(function(e) {
            e.preventDefault();

            const email = $('#email').val();
            const password = $('#password').val();

            $.ajax({
                url: '/api/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    password: password
                }),
                success: function(data) {
                    console.log('data=>', data);
                    if (data.access_token) {
                        console.log('Token:', data.access_token);

                        localStorage.setItem('token', data.access_token);

                        console.log('Token di localStorage:', localStorage.getItem('token'));
                        window.location.href = '/home';
                    } else {
                        console.log('Login gagal, token tidak ditemukan');
                    }
                },
                error: function(xhr) {
                    const errorDiv = $('#error-message');
                    errorDiv.text(xhr.responseJSON.error || 'Login failed');
                    errorDiv.removeClass('d-none');
                }
            });
        });
    });
</script>
@endsection