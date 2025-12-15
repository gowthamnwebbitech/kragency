@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3>Create Sub Admin</h3>
        <form method="POST" action="{{ route('admin.subadmin.store') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
