@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container mt-5">
    <h2>Welcome, <span id="user-name">User</span></h2>
    <p>You are logged in.</p>
    <button id="logout-button" class="btn btn-danger">Logout</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        console.log('token home', token);

        if (!token) {
            window.location.href = '/login';
            return;
        }

        const response = await fetch('/api/me', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            }
        });

        if (response.ok) {
            const user = await response.json();
            document.getElementById('user-name').textContent = user.name;
        } else {
            // Token tidak valid atau expired
            window.location.href = '/login';
        }

        document.getElementById('logout-button').addEventListener('click', async () => {
            const logoutResponse = await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });

            if (logoutResponse.ok) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            } else {
                alert('Failed to logout');
            }
        });
    });
</script>
@endsection
