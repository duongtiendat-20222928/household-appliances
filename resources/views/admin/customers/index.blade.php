@extends('admin.layouts.admin')

@section('title', 'Quản lý Khách hàng')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-users me-2"></i>Danh sách Tài khoản Khách hàng</h6>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success py-2"><i class="fa-solid fa-check me-2"></i>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger py-2"><i
                        class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Họ và Tên</th>
                            <th>Email đăng nhập</th>
                            <th>Ngày tham gia</th>
                            <th>Vai trò</th>
                            <th class="text-center" width="100">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="text-center">{{ $customer->id }}</td>
                                <td class="fw-bold">{{ $customer->name }}</td>
                                <td class="text-primary">{{ $customer->email }}</td>
                                <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-secondary">Khách hàng</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản khách hàng này? Mọi dữ liệu liên quan có thể bị ảnh hưởng.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Xóa khách hàng"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
