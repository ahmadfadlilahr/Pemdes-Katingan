<button id="backToTop"
        class="fixed bottom-6 right-6 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 sm:p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-blue-300 opacity-0 invisible"
        aria-label="Kembali ke atas"
        onclick="scrollToTop()">
    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<script>
// Back to top functionality
(function() {
    const backToTopButton = document.getElementById('backToTop');

    if (!backToTopButton) return;

    // Show/hide button based on scroll position
    function toggleBackToTop() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.remove('opacity-100', 'visible');
            backToTopButton.classList.add('opacity-0', 'invisible');
        }
    }

    // Scroll to top function
    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    // Listen to scroll event
    window.addEventListener('scroll', toggleBackToTop);

    // Initial check
    toggleBackToTop();
})();
</script>

<style>
#backToTop {
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
}

#backToTop:hover svg {
    transform: translateY(-4px);
}
</style>
