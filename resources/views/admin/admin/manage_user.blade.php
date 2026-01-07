@extends('admin_layout')
@section('admin_content')

<h3>Quản lý người dùng</h3>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $a)
        <tr>
            <td>{{ $a->admin_id }}</td>
            <td>{{ $a->admin_name }}</td>
            <td>{{ $a->admin_email }}</td>
            <td>{{ $a->role ? $a->role->role_name : 'Chưa có role' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
