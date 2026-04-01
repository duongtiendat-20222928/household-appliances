@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
    <div class="bg-white p-4 rounded shadow-sm border mt-4">
        <h3 class="fw-bold border-bottom pb-3 mb-4"><i class="fa-solid fa-cart-shopping text-meta me-2"></i> Giỏ hàng của bạn
        </h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (count($cart) > 0)
            <div class="table-responsive">
                <table class="table align-middle border">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th class="text-center" style="width: 150px;">Số lượng</th>
                            <th>Thành tiền</th>
                            <th class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $details['image'] }}" class="rounded border" width="60"
                                            alt="{{ $details['name'] }}">
                                        <span class="fw-bold text-dark">{{ $details['name'] }}</span>
                                    </div>
                                </td>
                                <td class="text-danger fw-bold">{{ number_format($details['price'], 0, ',', '.') }} ₫</td>

                                <td class="text-center">
                                    <div class="input-group input-group-sm justify-content-center">
                                        <a href="{{ route('cart.update', ['id' => $id, 'action' => 'decrease']) }}"
                                            class="btn btn-outline-secondary px-3 fw-bold fs-6">-</a>

                                        <input type="text" value="{{ $details['quantity'] }}"
                                            class="form-control text-center bg-white" style="max-width: 50px;" readonly>

                                        <a href="{{ route('cart.update', ['id' => $id, 'action' => 'increase']) }}"
                                            class="btn btn-outline-secondary px-3 fw-bold fs-6">+</a>
                                    </div>
                                </td>

                                <td class="text-danger fw-bold">
                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} ₫</td>
                                <td class="text-center">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc muốn bỏ sản phẩm này khỏi giỏ?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-end mt-4">

                <a href="/" class="btn btn-outline-secondary px-4 py-2 fw-bold text-uppercase">
                    <i class="fa-solid fa-arrow-left me-2"></i> Tiếp tục mua sắm
                </a>

                <div class="border p-3 rounded bg-light shadow-sm" style="width: 350px;">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="fw-bold">Tổng tiền thanh toán:</span>
                        <span class="fw-bold text-danger fs-5">{{ number_format($total, 0, ',', '.') }} ₫</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 fw-bold text-uppercase py-2">
                        Tiến hành đặt hàng
                    </a>
                </div>

            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart" width="120"
                    class="mb-3 opacity-50">
                <h5 class="text-muted fw-bold">Giỏ hàng của bạn đang trống!</h5>
                <p class="text-muted small">Hãy chọn thêm đồ gia dụng vào giỏ nhé.</p>
                <a href="/" class="btn btn-primary mt-2 px-4"><i class="fa-solid fa-arrow-left me-2"></i>Tiếp tục mua
                    sắm</a>
            </div>
        @endif
    </div>
@endsection
