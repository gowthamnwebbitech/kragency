@extends('layouts.app')

@section('title', 'Sub Admins')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h3>Sub Admins</h3>
        <a href="{{ route('admin.subadmin.create') }}" class="btn btn-primary">Add Sub Admin</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach($subadmins as $i => $admin)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->mobile }}</td>
            <td>{{ $admin->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.subadmin.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form method="POST" action="{{ route('admin.subadmin.destroy', $admin->id) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
