document.addEventListener("DOMContentLoaded", function () {

    // Keranjang
    const cartIcon = document.getElementById("cartIcon");
    const cartDropdown = document.getElementById("cartDropdown");
    const cartCount = document.getElementById("cart-count");
    const cartItemsContainer = document.getElementById("keranjang-items");
    const cartList = document.querySelector("#keranjang-items ul");
    const emptyCartMessage = document.getElementById("empty-cart");
    const cartContainer = document.getElementById("cart-items-container");
    // Mengambil data keranjang dari server
    let cart = [];


    // Fungsi untuk mengambil data keranjang dari server
    function fetchCartData() {
        fetch("/api/carts", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            cart = data.cart_items;
            console.log(cart)
            console.log("Isi cart setelah fetch:", cart);
            //updateCartView();
            if (cart.length > 0) {
                cart.forEach(item => {
                    let product = item.product;
        
                    let cartItemHTML = `
                        <div class="cart-item">
                            <img src="${product.image}" alt="${product.name}" width="50">
                            <div>
                                <p><strong>${product.name}</strong></p>
                                <p>Harga: Rp ${product.price}</p>
                                <p>Jumlah: ${item.quantity}</p>
                            </div>
                        </div>
                    `;
        
                    cartContainer.innerHTML += cartItemHTML;
                });
                
            } else if(cart.length == 0){
                    let emptycartHTML =

                `<div class="keranjang-kosong">
                <h5 class="fw-bold mt-3">Wah, keranjang belanjamu kosong</h5>
                <p class="text-muted">Yuk, isi dengan barang-barang impianmu!</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-success">Mulai Belanja</a>
                </div>`
                cartContainer.innerHTML = emptycartHTML;
            }
            
        
        })
        .catch(error => console.error("Error fetching cart data:", error));
    }

    fetchCartData()







    // Memperbarui tampilan keranjang
    function updateCartView() {
        let cartContainer = document.getElementById("cart-items-container");
        let cartCount = document.getElementById("cart-count");

        cartContainer.innerHTML = "";
        cartCount.innerText = cart.length;

        cart.forEach(item => {
            let product = item.product;

            let cartItemHTML = `
                <div class="cart-item">
                    <img src="${product.image1}" alt="${product.name}" width="50">
                    <div>
                        <p><strong>${product.name}</strong></p>
                        <p>Harga: Rp ${product.price}</p>
                        <p>Jumlah: ${item.quantity}</p>
                    </div>
                </div>
            `;

            cartContainer.innerHTML += cartItemHTML;
        });
    }

    // Fungsi untuk menambah produk ke keranjang
    window.addToCart = function (productId) {
        // Kirim request ke server untuk menambah produk ke keranjang
        fetch("/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            fetchCartData(); // Ambil ulang data keranjang setelah produk ditambahkan
        })
        .catch(error => console.error("Error adding to cart:", error));
    };

    // Fungsi untuk menghapus produk dari keranjang
    window.removeFromCart = function (index) {
        const productId = cart[index].product.id;

        fetch("/cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ productId: productId })
        })
        .then(response => response.json())
        .then(data => {
            fetchCartData(); // Ambil ulang data keranjang setelah produk dihapus
        })
        .catch(error => console.error("Error removing from cart:", error));
    };

    // Menampilkan dropdown keranjang saat mouse masuk ke icon keranjang
    cartIcon.addEventListener("mouseenter", function () {
        cartDropdown.style.display = "block";
    });

    // Menyembunyikan dropdown keranjang saat mouse keluar
    cartDropdown.addEventListener("mouseleave", function () {
        cartDropdown.style.display = "none";
    });

    // Fungsi untuk mengubah gambar thumbnail produk
    function changeImage(imageSrc, element) {
        document.getElementById('mainImage').src = imageSrc;
        let thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
    }

    // Filter harga
    const priceRange = document.getElementById("priceRange");
    const priceValue = document.getElementById("priceValue");

    priceRange.addEventListener("input", function () {
        priceValue.textContent = this.value;
    });

    // Form add to cart
    const forms = document.querySelectorAll('form.add-to-cart');
    forms.forEach(form => {
        form.addEventListener('submit', handleAddToCart);
    });

    // Menangani submit form add-to-cart dengan AJAX
    function handleAddToCart(event) {
        event.preventDefault(); // Mencegah form untuk submit secara default

        const form = event.target; // Menangkap form
        const button = form.querySelector('button');
        
        // Menambahkan loading spinner
        button.disabled = true;
        button.querySelector('.button-text').classList.add('d-none');
        button.querySelector('.spinner-border').classList.remove('d-none');
        
        // Mengambil data produk dari form
        const formData = new FormData(form);
        
        // Kirim data form ke backend menggunakan AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Menampilkan alert bahwa produk berhasil ditambahkan
            const alert = document.getElementById('product-added-alert');
            alert.classList.remove('d-none');

            // Sembunyikan alert setelah 3 detik
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);

            // Menambahkan produk ke keranjang berhasil, perbarui tampilan keranjang di navbar
            updateCartView();
            button.disabled = false;
            button.querySelector('.button-text').classList.remove('d-none');
            button.querySelector('.spinner-border').classList.add('d-none');
        })
        .catch(error => {
            console.error("Error adding to cart:", error);
            button.disabled = false;
            button.querySelector('.button-text').classList.remove('d-none');
            button.querySelector('.spinner-border').classList.add('d-none');
        });
    }

});





//filter kategori
$(document).ready(function() {
    $('#filter-form').on('change', 'input, #priceRange', function() {
        let categories = $('#filter-form input[name="categories[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        let brands = $('#filter-form input[name="brands[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        let price = $('#priceRange').val();

        $.ajax({
            url: "{{ route('HalamanHome.HalamanProduct.Produt_list') }}",
            type: "GET",
            data: {
                categories: categories,
                brands: brands,
                price: price
            },
            success: function(response) {
                $('#product-list').html(response.html);
                $('.pagination-container').html(response.pagination);

                // Re-attach event listener ke card setelah update produk
                $('#product-list .product-clickable').click(function() {
                    window.location.href = $(this).data('url');
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    });


});
$(document).ready(function() {
    $('.dropdown-toggle').click(function(e) {
        e.preventDefault();
        $(this).next('.dropdown-menu').toggle();
    });
});


$(document).ready(function() {
    $('#profile-icon').click(function(event) {
        event.preventDefault(); // Mencegah aksi default dari tag <a>
        $('#profile-dropdown').toggleClass('show'); // Toggle visibility dropdown
    });

    // Menyembunyikan dropdown jika klik di luar dropdown
    $(document).click(function(event) {
        if (!$(event.target).closest('#profile-icon').length && 
            !$(event.target).closest('#profile-dropdown').length) {
            $('#profile-dropdown').removeClass('show'); // Hapus kelas 'show'
        }
    });
});

function incrementQuantity(productId) {
    const inputField = document.getElementById(`quantity-${productId}`);
    inputField.stepUp(); // Atau inputField.value = parseInt(inputField.value) + 1; untuk kontrol lebih
}

function decrementQuantity(productId) {
    const inputField = document.getElementById(`quantity-${productId}`);
    const currentValue = parseInt(inputField.value);
    if (currentValue > 1) { // Mencegah nilai kurang dari 1
        inputField.stepDown(); // Atau inputField.value = currentValue - 1; untuk kontrol lebih
    }
}


function changeImage(newImageSrc, clickedThumbnail) {
    const mainImage = document.getElementById('main-image');
    mainImage.src = newImageSrc;

    // Tambahkan class 'active' ke thumbnail yang diklik dan hapus dari thumbnail lainnya
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumbnail => thumbnail.classList.remove('active'));
    clickedThumbnail.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('#filter-form input[type="checkbox"][name="categories[]"]');
    const brandCheckboxes = document.querySelectorAll('#filter-form input[type="checkbox"][name="brands[]"]');
    const productContainer = document.querySelector('.row');

    function filterProducts() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        const selectedBrands = Array.from(brandCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        const products = productContainer.querySelectorAll('.product-card');

        products.forEach(product => {
            const productCategories = product.dataset.categories ? product.dataset.categories.split(',') : [];
            const productBrand = product.dataset.brand;

            const categoryMatch = selectedCategories.length === 0 || selectedCategories.some(category => productCategories.includes(category));
            const brandMatch = selectedBrands.length === 0 || selectedBrands.includes(productBrand);

            if (categoryMatch && brandMatch) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });

    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
      });
    

    filterProducts();
});


const priceRange = document.getElementById('priceRange');
const priceValue = document.getElementById('priceValue');

priceRange.addEventListener('input', () => {
    priceValue.textContent = priceRange.value;
});

