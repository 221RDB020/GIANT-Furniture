document.addEventListener('DOMContentLoaded', () => {
    // Add to Wishlist
    const wishlistBtn = document.querySelector('.add-to-wishlist');

    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', (e) => {
            if (wishlistBtn.getAttribute('aria-checked') === 'true') {
                wishlistBtn.setAttribute('aria-checked', 'false');
            } else {
                wishlistBtn.setAttribute('aria-checked', 'true');
            }
        });
    }

    // Add to Cart
    const addToCartBtn = document.querySelector('.add-to-cart');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', (e) => {
            if (addToCartBtn.getAttribute('aria-checked') === 'true') {
                addToCartBtn.setAttribute('aria-checked', 'false');
                addToCartBtn.innerText = "Add to Cart";
            } else {
                addToCartBtn.setAttribute('aria-checked', 'true');
                addToCartBtn.innerText = "Remove from Cart";
            }
        });
    }
});