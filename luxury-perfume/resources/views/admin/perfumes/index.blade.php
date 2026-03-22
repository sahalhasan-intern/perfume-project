@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h2 class="fw-bold mb-0 text-dark">Manage Products</h2>
        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addPerfumeModal">
            <i class="fas fa-plus me-2"></i> Add Product
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perfumes as $perfume)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ $perfume->image ? asset($perfume->image) : 'https://images.unsplash.com/photo-1594035910387-fea47728cefd?ixlib=rb-4.0.3&w=100&q=80' }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td class="fw-bold text-dark">{{ $perfume->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $perfume->brand }}</span></td>
                                <td class="text-muted">{{ $perfume->category->name }}</td>
                                <td class="fw-bold text-primary">${{ number_format($perfume->price, 2) }}</td>
                                <td>
                                    @if($perfume->stock > 10)
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill"><i class="fas fa-check-circle me-1"></i> {{ $perfume->stock }}</span>
                                    @elseif($perfume->stock > 0)
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill"><i class="fas fa-exclamation-circle me-1"></i> {{ $perfume->stock }}</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group border rounded-pill shadow-sm overflow-hidden" role="group">
                                        <button type="button" class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#editPerfumeModal{{ $perfume->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.perfumes.destroy', $perfume->id) }}" method="POST" class="d-inline border-start">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Perfume Modal -->
                                    <div class="modal fade text-start" id="editPerfumeModal{{ $perfume->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4">
                                                <div class="modal-header border-bottom-0 pb-0">
                                                    <h5 class="modal-title fw-bold">Edit Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.perfumes.update', $perfume->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold text-dark">Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="name" class="form-control rounded-pill px-3" value="{{ $perfume->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold text-dark">Brand <span class="text-danger">*</span></label>
                                                                <input type="text" name="brand" class="form-control rounded-pill px-3" value="{{ $perfume->brand }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                                                <select name="category_id" class="form-select rounded-pill px-3" required>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $perfume->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label fw-bold text-dark">Price ($) <span class="text-danger">*</span></label>
                                                                <input type="number" step="0.01" name="price" class="form-control rounded-pill px-3" value="{{ $perfume->price }}" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label fw-bold text-dark">Stock <span class="text-danger">*</span></label>
                                                                <input type="number" name="stock" class="form-control rounded-pill px-3" value="{{ $perfume->stock }}" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label fw-bold text-dark">Description</label>
                                                                <textarea name="description" class="form-control rounded-4" rows="3">{{ $perfume->description }}</textarea>
                                                            </div>
                                                            <!-- Note: Image upload not functional yet, UI placeholder -->
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label fw-bold text-dark">Image</label>
                                                                <input type="file" name="image" class="form-control rounded-pill px-3" accept="image/*">
                                                                <small class="text-muted">Upload a new image (or leave empty to keep current).</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Save Changes</button>
                                                    </div>
                                                </form>
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
            @if(count($perfumes) === 0)
                <div class="text-center py-5">
                    <i class="fas fa-box fa-3x text-muted opacity-25 mb-3"></i>
                    <p class="text-muted mb-0">No products found in the catalog.</p>
                </div>
            @endif
            <div class="px-4 py-3 border-top">
                {{ $perfumes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Add Perfume Modal -->
<div class="modal fade" id="addPerfumeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.perfumes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-pill px-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Brand <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control rounded-pill px-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select rounded-pill px-3" required>
                                <option value="" disabled selected>Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control rounded-pill px-3" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control rounded-pill px-3" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold text-dark">Description</label>
                            <textarea name="description" class="form-control rounded-4" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold text-dark">Image</label>
                            <input type="file" name="image" class="form-control rounded-pill px-3" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fas fa-save me-1"></i> Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->
@endsection
