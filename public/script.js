document.addEventListener("DOMContentLoaded", function () {

    // Keranjang
    const cartIcon = document.getElementById("cartIcon");
    const cartDropdown = document.getElementById("cartDropdown");
    const cartCount = document.getElementById("cart-count");
    const cartItemsContainer = document.getElementById("keranjang-items");
    const cartList = document.querySelector("#keranjang-items ul");
    const emptyCartMessage = document.getElementById("empty-cart");

    // Mengambil data keranjang dari server
    let cart = [];

    // Fungsi untuk mengambil data keranjang dari server
    function fetchCartData() {
        fetch("/cart/items", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            cart = data.cart_items;
            console.log("Isi cart setelah fetch:", cart);
            updateCartView();
        })
        .catch(error => console.error("Error fetching cart data:", error));
    }

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


const addToCart = (productId, quantity) => {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        // Lakukan sesuatu dengan data yang diterima, misalnya perbarui tampilan keranjang
        console.log(data);
    })
    .catch(error => console.error(error));
};


//filter kategori
$(document).ready(function() {
    // Fungsi untuk mengirim AJAX saat filter diubah
    $('#filter-form input').on('change', function() {
        // Ambil data filter
        var categories = [];
        $('#filter-form input[name="categories[]"]:checked').each(function() {
            categories.push($(this).val());
        });

        var brands = [];
        $('#filter-form input[name="brands[]"]:checked').each(function() {
            brands.push($(this).val());
        });

        var price = $('#priceRange').val();

        // Kirim permintaan AJAX ke server
        $.ajax({
            url: "{{ route('products.index') }}",
            type: "GET",
            data: {
                categories: categories,
                brands: brands,
                price: price
            },
            success: function(response) {
                console.log(response);  // Cek respons dari server

                // Update daftar produk di halaman dengan HTML yang diterima dari server
                $('#product-list').html(response.html);
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);  // Cek jika ada error
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