@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5">Change Password</h2>
            <div class="card mt-4">
                <div class="card-body">
                    <form id="change-password-form">
                        @csrf
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Current Password</label>
                            <input type="password" name="old_password" class="form-control" id="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                        </div>
                        <div id="error-message" class="alert alert-danger d-none"></div>
                        <div id="success-message" class="alert alert-success d-none"></div>
                        <button type="submit" class="btn btn-primary w-100">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('change-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const old_password = document.getElementById('old_password').value;
        const new_password = document.getElementById('new_password').value;
        const new_password_confirmation = document.getElementById('new_password_confirmation').value;

        const token = localStorage.getItem('token');

        const response = await fetch('/api/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ old_password, new_password, new_password_confirmation })
        });

        const data = await response.json();

        if (response.ok) {
            // Tampilkan pesan sukses
            const successDiv = document.getElementById('success-message');
            successDiv.textContent = data.message || 'Password changed successfully';
            successDiv.classList.remove('d-none');
            // Sembunyikan pesan error jika ada
            document.getElementById('error-message').classList.add('d-none');
        } else {
            // Tampilkan pesan error
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = data.error || 'Failed to change password';
            errorDiv.classList.remove('d-none');
            // Sembunyikan pesan sukses jika ada
            document.getElementById('success-message').classList.add('d-none');
        }
    });
</script>
@endsection
