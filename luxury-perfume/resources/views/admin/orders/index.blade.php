@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h2 class="fw-bold mb-0 text-dark">Manage Orders</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <h6 class="mb-0 fw-bold">{{ $order->user->name }}</h6>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td class="fw-bold text-primary">${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm rounded-pill w-auto shadow-sm border-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'secondary'))) }}" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                        View Details
                                    </button>
                                    
                                    <!-- Order Details Modal -->
                                    <div class="modal fade text-start" id="orderModal{{ $order->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4">
                                                <div class="modal-header border-bottom-0 pb-0">
                                                    <h5 class="modal-title fw-bold">Order Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row mb-4">
                                                        <div class="col-md-6 border-end">
                                                            <h6 class="fw-bold text-muted text-uppercase small mb-3">Order Info</h6>
                                                            <p class="mb-1"><span class="text-muted me-2">Order ID:</span> <span class="fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                                                            <p class="mb-1"><span class="text-muted me-2">Date:</span> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                                            <p class="mb-1"><span class="text-muted me-2">Status:</span> 
                                                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning text-dark' : ($order->status == 'processing' ? 'info text-dark' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'secondary'))) }} rounded-pill px-2">{{ ucfirst($order->status) }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 ps-md-4">
                                                            <h6 class="fw-bold text-muted text-uppercase small mb-3">Customer Info</h6>
                                                            <p class="mb-1"><span class="text-muted me-2">Name:</span> {{ $order->user->name }}</p>
                                                            <p class="mb-1"><span class="text-muted me-2">Email:</span> <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></p>
                                                        </div>
                                                    </div>
                                                    
                                                    <h6 class="fw-bold mb-3 border-bottom pb-2">Order Items</h6>
                                                    <div class="table-responsive rounded-3 border">
                                                        <table class="table table-sm table-hover align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="ps-3 ps-3">Product</th>
                                                                    <th class="text-center">Qty</th>
                                                                    <th class="text-end">Price</th>
                                                                    <th class="text-end pe-3">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->items as $item)
                                                                    <tr>
                                                                        <td class="ps-3 py-2">
                                                                            <div class="d-flex align-items-center">
                                                                                <img src="{{ $item->product->image ? asset($item->product->image) : 'https://images.unsplash.com/photo-1523293115678-d2906200c01a?ixlib=rb-4.0.3&w=100&q=80' }}" class="rounded me-2 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                                                                                <div>
                                                                                    <h6 class="mb-0 small fw-bold">{{ $item->product->name }}</h6>
                                                                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $item->product->brand ?? 'ELAVA' }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">{{ $item->quantity }}</td>
                                                                        <td class="text-end text-muted small">${{ number_format($item->price, 2) }}</td>
                                                                        <td class="text-end pe-3 fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="table-light">
                                                                <tr>
                                                                    <td colspan="3" class="text-end fw-bold py-3">Total Amount:</td>
                                                                    <td class="text-end fw-bold text-primary fs-5 pe-3 py-3">${{ number_format($order->total, 2) }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($orders) === 0)
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted opacity-25 mb-3"></i>
                    <p class="text-muted mb-0">No orders found.</p>
                </div>
            @endif
            <div class="px-4 py-3 border-top">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
