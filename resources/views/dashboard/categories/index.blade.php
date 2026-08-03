<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product Categories</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Product Categories</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('categories.index') }}" method="get">
                @csrf
                <flux:input icon="magnifying-glass" name="q" value="{{ $q }}" placeholder="Search Product Categories" />
            </form>
        </div>
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('categories.create') }}" variant="subtle">Add New Category</flux:link>
            </flux:button>
        </div>
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{session()->get('successMessage')}}</flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Image
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Slug
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Created At
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                    <tr class="bg-white hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            {{ $key + 1 }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $category->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $category->slug }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $category->created_at }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-100 dark:bg-indigo-950 dark:text-indigo-400">
                                    <flux:icon name="pencil" class="size-3.5" /> Edit
                                </a>
                                <button
                                    type="button"
                                    onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus kategori ini?')) document.getElementById('delete-category-{{ $category->id }}').submit();"
                                    class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100 dark:bg-red-950 dark:text-red-400"
                                >
                                    <flux:icon name="trash" class="size-3.5" /> Hapus
                                </button>

                                <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
    
</x-layouts.app>