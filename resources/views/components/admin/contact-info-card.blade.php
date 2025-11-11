@props(['contact'])

<div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-200">
    <!-- Header dengan Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Informasi Kontak</h3>
            <p class="text-sm text-gray-500">Terakhir diperbarui: {{ $contact->updated_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.contacts.edit', $contact) }}"
               class="inline-flex items-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-200"
               title="Edit Kontak">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="hidden sm:inline">Edit</span>
            </a>
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini? Anda harus membuat kontak baru setelah menghapus.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-200"
                        title="Hapus Kontak">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span class="hidden sm:inline">Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Information Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kontak Utama -->
        <x-admin.contact-section title="Kontak Utama">
            <!-- Email -->
            <x-admin.contact-item icon="email">
                <x-slot name="label">Email</x-slot>
                <x-slot name="value">{{ $contact->email }}</x-slot>
            </x-admin.contact-item>

            <!-- Telepon -->
            @if($contact->phone)
                <x-admin.contact-item icon="phone">
                    <x-slot name="label">Telepon</x-slot>
                    <x-slot name="value">{{ $contact->phone }}</x-slot>
                </x-admin.contact-item>
            @endif

            <!-- WhatsApp -->
            @if($contact->whatsapp)
                <x-admin.contact-item icon="whatsapp">
                    <x-slot name="label">WhatsApp</x-slot>
                    <x-slot name="value">{{ $contact->whatsapp }}</x-slot>
                </x-admin.contact-item>
            @endif
        </x-admin.contact-section>

        <!-- Media Sosial -->
        <x-admin.contact-section title="Media Sosial">
            @if($contact->facebook)
                <x-admin.contact-item icon="facebook">
                    <x-slot name="label">Facebook</x-slot>
                    <x-slot name="value">
                        <a href="{{ $contact->facebook }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $contact->facebook }}
                        </a>
                    </x-slot>
                </x-admin.contact-item>
            @endif

            @if($contact->instagram)
                <x-admin.contact-item icon="instagram">
                    <x-slot name="label">Instagram</x-slot>
                    <x-slot name="value">
                        <a href="{{ $contact->instagram }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $contact->instagram }}
                        </a>
                    </x-slot>
                </x-admin.contact-item>
            @endif

            @if($contact->twitter)
                <x-admin.contact-item icon="twitter">
                    <x-slot name="label">Twitter</x-slot>
                    <x-slot name="value">
                        <a href="{{ $contact->twitter }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $contact->twitter }}
                        </a>
                    </x-slot>
                </x-admin.contact-item>
            @endif

            @if($contact->youtube)
                <x-admin.contact-item icon="youtube">
                    <x-slot name="label">YouTube</x-slot>
                    <x-slot name="value">
                        <a href="{{ $contact->youtube }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $contact->youtube }}
                        </a>
                    </x-slot>
                </x-admin.contact-item>
            @endif
        </x-admin.contact-section>

        <!-- Alamat & Jam Kerja -->
        <x-admin.contact-section title="Alamat & Jam Kerja" class="md:col-span-2">
            <!-- Alamat -->
            <x-admin.contact-item icon="location">
                <x-slot name="label">Alamat</x-slot>
                <x-slot name="value">{{ $contact->address }}</x-slot>
            </x-admin.contact-item>

            <!-- Jam Kerja -->
            <x-admin.contact-item icon="clock">
                <x-slot name="label">Jam Kerja</x-slot>
                <x-slot name="value">{{ $contact->office_days }}, {{ $contact->office_hours_open }} - {{ $contact->office_hours_close }} WIB</x-slot>
            </x-admin.contact-item>
        </x-admin.contact-section>
    </div>
</div>
