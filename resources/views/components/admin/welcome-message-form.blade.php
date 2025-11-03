@props([
    'action',
    'method' => 'POST',
    'welcomeMessage' => null,
    'isEdit' => false
])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $welcomeMessage->name ?? '') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') @enderror"
                       placeholder="Nama Kepala Dinas"
                       required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                    Jabatan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="position"
                       id="position"
                       value="{{ old('position', $welcomeMessage->position ?? '') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('position') @enderror"
                       placeholder="Kepala Dinas Pemberdayaan Masyarakat Desa"
                       required>
                @error('position')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Kata Sambutan <span class="text-red-500">*</span>
                </label>
                <textarea name="message"
                          id="message"
                          rows="12"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('message') @enderror"
                          placeholder="Tulis kata sambutan di sini..."
                          required>{{ old('message', $welcomeMessage->message ?? '') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">
                    Tulis kata sambutan dengan format teks biasa. Gunakan Enter untuk membuat paragraf baru.
                </p>
                @error('message')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Photo Upload -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Foto Profil
                    <span class="text-sm font-normal text-gray-500">(Opsional)</span>
                </h3>

                <div>
                    <!-- Photo Preview -->
                    @if($isEdit && $welcomeMessage->photo)
                        <div id="currentPhotoContainer" class="mb-4">
                            <img id="currentPhoto"
                                 src="{{ asset('storage/' . $welcomeMessage->photo) }}"
                                 alt="Current Photo"
                                 class="w-full h-48 object-cover rounded-md border">
                            <p class="text-sm text-gray-600 mt-2">Foto saat ini</p>
                        </div>
                    @endif

                    <div id="photoPreviewContainer" class="hidden mb-4">
                        <div class="relative">
                            <img id="photoPreview" class="w-full h-48 object-cover rounded-md border" alt="Preview">
                            <button type="button"
                                    id="removePhoto"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-2" id="photoInfo"></p>
                    </div>

                    <!-- Upload Area -->
                    <div id="photoUploadArea"
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="photo"
                                       class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span id="photoUploadText">Upload foto</span>
                                    <input id="photo" name="photo" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                        </div>
                    </div>
                    @error('photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Signature Upload -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Tanda Tangan
                    <span class="text-sm font-normal text-gray-500">(Opsional)</span>
                </h3>

                <div>
                    <!-- Signature Preview -->
                    @if($isEdit && $welcomeMessage->signature)
                        <div id="currentSignatureContainer" class="mb-4">
                            <img id="currentSignature"
                                 src="{{ asset('storage/' . $welcomeMessage->signature) }}"
                                 alt="Current Signature"
                                 class="w-full h-32 object-contain rounded-md border bg-white">
                            <p class="text-sm text-gray-600 mt-2">Tanda tangan saat ini</p>
                        </div>
                    @endif

                    <div id="signaturePreviewContainer" class="hidden mb-4">
                        <div class="relative">
                            <img id="signaturePreview" class="w-full h-32 object-contain rounded-md border bg-white" alt="Preview">
                            <button type="button"
                                    id="removeSignature"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-2" id="signatureInfo"></p>
                    </div>

                    <!-- Upload Area -->
                    <div id="signatureUploadArea"
                         class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="signature"
                                       class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span id="signatureUploadText">Upload tanda tangan</span>
                                    <input id="signature" name="signature" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG (background transparan) hingga 2MB</p>
                        </div>
                    </div>
                    @error('signature')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status Publikasi</h3>

                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                           {{ old('is_active', $welcomeMessage->is_active ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan sebagai kata sambutan utama
                    </label>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Hanya satu kata sambutan yang bisa aktif. Jika diaktifkan, kata sambutan lain akan otomatis dinonaktifkan.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEdit ? 'Perbarui' : 'Simpan' }} Kata Sambutan
                </button>

                <a href="{{ route('admin.welcome-messages.index') }}"
                   class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Photo Upload Handler
        setupImageUpload('photo', 'photoPreview', 'photoPreviewContainer', 'photoUploadArea', 'photoInfo', 'removePhoto', 'photoUploadText', 'currentPhotoContainer');

        // Signature Upload Handler
        setupImageUpload('signature', 'signaturePreview', 'signaturePreviewContainer', 'signatureUploadArea', 'signatureInfo', 'removeSignature', 'signatureUploadText', 'currentSignatureContainer');
    });

    function setupImageUpload(inputId, previewId, containerPreviewId, uploadAreaId, infoId, removeButtonId, uploadTextId, currentContainerId) {
        const input = document.getElementById(inputId);
        const uploadArea = document.getElementById(uploadAreaId);
        const previewContainer = document.getElementById(containerPreviewId);
        const preview = document.getElementById(previewId);
        const info = document.getElementById(infoId);
        const removeButton = document.getElementById(removeButtonId);
        const uploadText = document.getElementById(uploadTextId);
        const currentContainer = document.getElementById(currentContainerId);

        // File input change
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Silakan pilih file gambar yang valid.');
                    return;
                }

                if (file.size > 2097152) {
                    alert('Ukuran file harus kurang dari 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    info.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

                    uploadArea.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                    if (currentContainer) currentContainer.classList.add('hidden');
                    uploadText.textContent = 'Ganti gambar';
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image
        removeButton.addEventListener('click', function() {
            input.value = '';
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            if (currentContainer) currentContainer.classList.remove('hidden');
            uploadText.textContent = inputId === 'photo' ? 'Upload foto' : 'Upload tanda tangan';
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('border-blue-400', 'bg-blue-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-400', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
    }
</script>
@endpush
