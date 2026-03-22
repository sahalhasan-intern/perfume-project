@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div x-data="{ addModal: false, editModal: false, editProduct: {}, editAction: '' }">
    <div class="mb-6 flex justify-end">
        <button @click="addModal = true" class="bg-black text-white rounded-md py-2 px-4 uppercase tracking-wide text-sm hover:bg-gray-800 transition">
            <i class="fas fa-plus mr-2"></i> Add Product
        </button>

        <!-- Add Product Modal -->
        <div x-show="addModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-vh-100 pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" @click="addModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="font-bold text-lg border-b border-gray-200 pb-2 mb-4">Add New Product</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Price ($)</label>
                                    <input type="number" step="0.01" name="price" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                                    <input type="number" name="stock" value="10" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" rows="3" class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm"></textarea>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Featured Image</label>
                                    <input type="file" name="image" class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                            <button type="button" @click="addModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($product->image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $product->stock }} In Stock</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button @click="editModal = true; editAction = '{{ route('admin.products.update', $product->id) }}'; editProduct = {{ json_encode($product) }}" class="text-blue-600 hover:text-blue-900">Edit</button>
                                
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-vh-100 pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="editModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form :action="editAction" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="font-bold text-lg border-b border-gray-200 pb-2 mb-4">Edit Product</div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" x-model="editProduct.name" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category_id" x-model="editProduct.category_id" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Price ($)</label>
                                <input type="number" step="0.01" name="price" x-model="editProduct.price" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" x-model="editProduct.stock" required class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="3" x-model="editProduct.description" class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Featured Image</label>
                                <input type="file" name="image" class="mt-1 w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <div class="mt-2 text-xs text-gray-400">Leave blank to keep current image.</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">Update</button>
                        <button type="button" @click="editModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
