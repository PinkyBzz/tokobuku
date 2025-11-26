@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('page-title', 'Manage Categories')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-light">Total {{ $categories->count() }} categories</p>
        </div>
        <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 transition-colors text-xs uppercase tracking-widest shadow-xl shadow-gray-200">
            <i class="fas fa-plus mr-2"></i> Add Category
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white border border-gray-100 rounded-sm p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 serif">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-500 font-light mt-1">{{ $category->books_count }} books</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"
                                class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" 
                              action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Delete this category? All books in this category will be moved to Uncategorized.');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if($category->description)
                    <p class="text-sm text-gray-600 font-light">{{ Str::limit($category->description, 100) }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-sm max-w-md w-full p-8">
        <h2 class="text-2xl font-medium text-gray-900 serif italic mb-6">Add New Category</h2>
        
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Category Name</label>
                <input type="text" 
                       name="name" 
                       required
                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
            </div>

            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Description (Optional)</label>
                <textarea name="description" 
                          rows="3"
                          class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest">
                    Create Category
                </button>
                <button type="button" 
                        onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="px-6 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-sm max-w-md w-full p-8">
        <h2 class="text-2xl font-medium text-gray-900 serif italic mb-6">Edit Category</h2>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-medium uppercase tracking-widest text-gray-900 mb-2">Category Name</label>
                <input type="text" 
                       id="editName"
                       name="name" 
                       required
                       class="w-full px-4 py-3 bg-white border border-gray-200 text-sm font-light focus:outline-none focus:border-gray-900 transition-all">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 transition-colors text-xs uppercase tracking-widest">
                    Update Category
                </button>
                <button type="button" 
                        onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="px-6 py-3 bg-white border border-gray-200 hover:border-gray-900 text-gray-900 text-xs uppercase tracking-widest transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editCategory(id, name) {
    document.getElementById('editForm').action = `/admin/categories/${id}`;
    document.getElementById('editName').value = name;
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
@endsection
