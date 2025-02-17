document.addEventListener("DOMContentLoaded", function () {

    // Keranjang
    const cartIcon = document.getElementById("cart-icon");
    const cartDropdown = document.getElementById("keranjang-dropdown");
    const cartCount = document.getElementById("cart-count");
    const cartItemsContainer = document.getElementById("keranjang-items");
    const cartList = document.querySelector("#keranjang-items ul");
    const emptyCartMessage = document.getElementById("empty-cart");

    // Mengambil data keranjang dari server
    let cart = [];

    // Fungsi untuk mengambil data keranjang dari server
    function fetchCartData() {
        fetch("/keranjang")  // Ganti dengan URL untuk mengambil data keranjang
            .then(response => response.json())
            .then(data => {
                cart = data.cartItems; // Menyimpan data produk keranjang
                updateCartView();
            })
            .catch(error => console.error("Error fetching cart data:", error));
    }

    // Memperbarui tampilan keranjang
    function updateCartView() {
        if (cart.length === 0) {
            emptyCartMessage.classList.remove("d-none");
            cartItemsContainer.classList.add("d-none");
        } else {
            emptyCartMessage.classList.add("d-none");
            cartItemsContainer.classList.remove("d-none");

            // Mengupdate daftar item keranjang
            cartList.innerHTML = "";
            cart.forEach((item, index) => {
                const li = document.createElement("li");
                li.innerHTML = `${item.product.name} - Rp${item.product.price} <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">Hapus</button>`;
                cartList.appendChild(li);
            });
        }
    }

    // Memanggil fungsi untuk mengambil data keranjang saat halaman dimuat
    fetchCartData();

    // Fungsi untuk menambah produk ke keranjang
    window.addToCart = function (productId) {
        // Kirim request ke server untuk menambah produk ke keranjang
        fetch("/keranjang/tambah", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ productId: productId })
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

        fetch("/keranjang/hapus", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
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

    // Dropdown Profil
    const profileIcon = document.getElementById("profile-icon");
    const profileDropdown = document.getElementById("profile-dropdown");

    profileIcon.addEventListener("click", function (event) {
        event.preventDefault();
        profileDropdown.style.display = profileDropdown.style.display === "block" ? "none" : "block";
    });

    // Menutup dropdown profil saat klik di luar
    document.addEventListener("click", function (event) {
        if (!profileIcon.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = "none";
        }
    });

    // Countdown Timer (Misalnya untuk produk yang diskon)
    const countdownDate = new Date("2025-03-01 00:00:00").getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = countdownDate - now;

        if (timeLeft <= 0) {
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
            document.getElementById("seconds").innerText = "00";
            return;
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById("days").innerText = days < 10 ? "0" + days : days;
        document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
        document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
    }

    setInterval(updateCountdown, 1000);

    // Fungsi untuk mengubah gambar thumbnail produk
    function changeImage(imageSrc, element) {
        document.getElementById('mainImage').src = imageSrc;
        let thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
    }

    // Menyembunyikan alert setelah 3 detik
    setTimeout(() => {
        document.getElementById('alert-message').style.display = 'none';
    }, 3000);

    // Filter harga
    const priceRange = document.getElementById("priceRange");
    const priceValue = document.getElementById("priceValue");

    priceRange.addEventListener("input", function () {
        priceValue.textContent = this.value;
    });

    // Filter kategori dan merek
    const checkboxes = document.querySelectorAll('input[name="categories[]"], input[name="brands[]"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            applyFilters();
        });
    });

    function applyFilters() {
        let selectedCategories = [];
        let selectedBrands = [];

        document.querySelectorAll('input[name="categories[]"]:checked').forEach(checkbox => {
            selectedCategories.push(checkbox.value);
        });

        document.querySelectorAll('input[name="brands[]"]:checked').forEach(checkbox => {
            selectedBrands.push(checkbox.value);
        });

        fetch("{{ route('products.index') }}", {
            method: "POST", // Menggunakan POST karena mengirim data
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                categories: selectedCategories,
                brands: selectedBrands
            })
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector(".row.mt-3").innerHTML = data.html;
        })
        .catch(error => console.error("Error:", error));
    }

    // Toggle Loading pada form
    function toggleLoading(form) {
        let button = form.querySelector('button');
        button.disabled = true;
        button.querySelector('.button-text').classList.add('d-none');
        button.querySelector('.spinner-border').classList.remove('d-none');
    }

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
        // Menambahkan produk ke keranjang berhasil, perbarui tampilan keranjang di navbar
        updateCartView(data.cart); // Data yang diterima adalah data keranjang terbaru
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

// Fungsi untuk memperbarui tampilan keranjang di navbar
function updateCartView(cart) {
    const cartCount = document.getElementById("cart-count");
    const cartItemsContainer = document.getElementById("keranjang-items");
    const cartList = document.querySelector("#keranjang-items ul");
    const emptyCartMessage = document.getElementById("empty-cart");

    if (cart.length === 0) {
        emptyCartMessage.classList.remove("d-none");
        cartItemsContainer.classList.add("d-none");
    } else {
        emptyCartMessage.classList.add("d-none");
        cartItemsContainer.classList.remove("d-none");

        // Mengupdate daftar item keranjang
        cartList.innerHTML = "";
        cart.forEach((item, index) => {
            const li = document.createElement("li");
            li.innerHTML = `${item.product.name} - Rp${item.product.price} <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">Hapus</button>`;
            cartList.appendChild(li);
        });

        // Menampilkan jumlah item di keranjang
        cartCount.textContent = cart.length;
    }
}


