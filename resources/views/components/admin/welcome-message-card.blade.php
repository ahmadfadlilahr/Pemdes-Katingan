@props(['message'])

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition duration-200">
    <!-- Header dengan Photo dan Info -->
    <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-start gap-6">
            <!-- Photo Section -->
            <div class="flex-shrink-0">
                @if($message->photo)
                    <img class="h-24 w-24 sm:h-32 sm:w-32 rounded-full object-cover border-4 border-gray-100"
                         src="{{ asset('storage/' . $message->photo) }}"
                         alt="{{ $message->name }}">
                @else
                    <div class="h-24 w-24 sm:h-32 sm:w-32 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-4 border-gray-100">
                        <svg class="h-12 w-12 sm:h-16 sm:w-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info & Actions -->
            <div class="flex-1 min-w-0">
                <!-- Name & Position -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $message->name }}</h3>
                    <p class="text-sm text-gray-600 font-medium">{{ $message->position }}</p>
                </div>

                <!-- Status Badge -->
                <div class="mb-4">
                    <form action="{{ route('admin.welcome-messages.toggle-status', $message) }}"
                          method="POST"
                          class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition duration-200 {{ $message->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}"
                                title="Klik untuk mengubah status">
                            <span class="w-2 h-2 rounded-full mr-2 {{ $message->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                            {{ $message->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.welcome-messages.edit', $message) }}"
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-200"
                       title="Edit Kata Sambutan">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="hidden sm:inline">Edit</span>
                        <span class="sm:hidden">Edit</span>
                    </a>

                    <form action="{{ route('admin.welcome-messages.destroy', $message) }}"
                          method="POST"
                          class="inline-block"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kata sambutan ini? Anda harus membuat kata sambutan baru setelah menghapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-200"
                                title="Hapus Kata Sambutan">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="hidden sm:inline">Hapus</span>
                            <span class="sm:hidden">Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                Pesan Sambutan
            </h4>
            <div class="prose prose-sm max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
                {!! Str::limit(strip_tags($message->message), 300, '...') !!}
            </div>
            @if(strlen(strip_tags($message->message)) > 300)
                <div class="mt-2">
                    <a href="{{ route('admin.welcome-messages.edit', $message) }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat selengkapnya →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
