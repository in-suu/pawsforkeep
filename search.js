document.addEventListener("DOMContentLoaded", () => {
    const searchInputs = document.querySelectorAll('.nav-search');

    searchInputs.forEach(input => {
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault(); 
                const query = input.value.toLowerCase().trim();

                if (query === '') return;
                if (query.includes('top product') || query.includes('top') || query.includes('furry')) {
                    const target = document.getElementById('top-products');
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        window.location.href = 'index.php#top-products';
                    }
                } 
                
                else if (query.includes('story') || query.includes('about') || query.includes('mission')) {
                    window.location.href = 'our-story.php';
                }
                
                else if (query.includes('contact') || query.includes('message') || query.includes('reach') || query.includes('fb')) {
                    window.location.href = 'contact-us.php';
                }

                else if (query.includes('store') || query.includes('find') || query.includes('location')) {
                    window.location.href = 'store1.php';
                }

                else {
                    window.location.href = 'products.php';
                }
            }
        });
    });
});