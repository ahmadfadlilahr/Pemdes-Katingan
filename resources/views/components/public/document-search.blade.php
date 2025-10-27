@props(['categories'])

<!-- Document Search & Filter Component -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">

    <form method="GET" action="{{ route('documents') }}" class="space-y-4">

        <!-- Search Input -->
        <div class="relative">
            <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                Cari Dokumen
            </label>
            <div class="relative">
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan judul atau deskripsi..."
                       class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        @if($categories && $categories->count() > 0)
        <div>
            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                Kategori
            </label>
            <select name="category"
                    id="category"
                    onchange="this.form.submit()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <!-- Search Button -->
            <button type="submit"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>

            <!-- Clear Filters Button -->
            @if(request('search') || request('category'))
            <a href="{{ route('documents') }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Reset
            </a>
            @endif
        </div>

    </form>

</div>
