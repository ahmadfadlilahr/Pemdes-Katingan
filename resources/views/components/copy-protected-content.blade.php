@props([
    'content' => '',
    'showNotification' => true,
])

<div
    x-data="copyProtection({{ $showNotification ? 'true' : 'false' }})"
    @contextmenu.prevent="handleContextMenu"
    @copy.prevent="handleCopy"
    @cut.prevent="handleCut"
    @selectstart.prevent.stop
    @dragstart.prevent
    class="select-none user-select-none"
    style="-webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;"
>
    {{ $slot }}

    <!-- Notification Toast -->
    <div
        x-show="showToast"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-4 right-4 z-50 max-w-sm"
        style="display: none;"
    >
        <div class="bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-start space-x-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="flex-1">
                <p class="font-semibold text-sm">Konten Dilindungi</p>
                <p class="text-xs mt-1 text-red-100">Maaf, konten ini tidak dapat disalin atau di-copy untuk melindungi hak cipta.</p>
            </div>
            <button
                @click="showToast = false"
                class="text-white hover:text-red-100 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    function copyProtection(showNotification = true) {
        return {
            showToast: false,
            toastTimeout: null,

            handleContextMenu(e) {
                if (showNotification) {
                    this.showNotification();
                }
                return false;
            },

            handleCopy(e) {
                if (showNotification) {
                    this.showNotification();
                }
                return false;
            },

            handleCut(e) {
                if (showNotification) {
                    this.showNotification();
                }
                return false;
            },

            showNotification() {
                // Clear existing timeout
                if (this.toastTimeout) {
                    clearTimeout(this.toastTimeout);
                }

                // Show toast
                this.showToast = true;

                // Auto hide after 3 seconds
                this.toastTimeout = setTimeout(() => {
                    this.showToast = false;
                }, 3000);
            }
        }
    }
</script>

<style>
    /* Additional CSS to prevent text selection */
    .select-none * {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    /* Prevent drag and drop */
    .select-none img {
        -webkit-user-drag: none;
        -khtml-user-drag: none;
        -moz-user-drag: none;
        -o-user-drag: none;
        user-drag: none;
        pointer-events: none;
    }

    /* Disable text cursor */
    .select-none {
        cursor: default !important;
    }
</style>
