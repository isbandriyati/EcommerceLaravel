document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const cartIcon = document.getElementById("cart-icon");
    const cartDropdown = document.getElementById("cart-dropdown");
    const emptyCart = document.getElementById("empty-cart");
    const cartItemsContainer = document.getElementById("cart-items");
    const cartList = document.querySelector("#cart-items ul");
    const cartCount = document.getElementById("cart-count");
    const itemCount = document.getElementById("item-count");

    if (!cartIcon || !cartDropdown || !emptyCart || !cartItemsContainer || !cartList || !cartCount || !itemCount) {
        console.error("⚠️ Ada elemen yang tidak ditemukan di HTML!");
        return;
    }

    // ✅ Fungsi untuk memperbarui tampilan keranjang
    function updateCartView() {
        if (cart.length === 0) {
            emptyCart.classList.remove("d-none");
            cartItemsContainer.classList.add("d-none");
            cartCount.classList.add("d-none");
        } else {
            emptyCart.classList.add("d-none");
            cartItemsContainer.classList.remove("d-none");
            cartCount.classList.remove("d-none");
            cartCount.textContent = cart.length;

            // Bersihkan daftar sebelum menambahkan elemen baru
            cartList.innerHTML = "";
            cart.forEach((item, index) => {
                let li = document.createElement("li");
                li.innerHTML = `${item.name} - Rp${item.price} <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">Hapus</button>`;
                cartList.appendChild(li);
            });

            itemCount.textContent = `${cart.length} Produk dalam Keranjang`;
        }

        // Simpan ke localStorage
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    // ✅ Fungsi untuk menambah produk ke keranjang
    window.addToCart = function (name, price) {
        cart.push({ name, price });
        updateCartView();
    };

    // ✅ Fungsi untuk menghapus produk dari keranjang
    window.removeFromCart = function (index) {
        cart.splice(index, 1);
        updateCartView();
    };

    // ✅ Pastikan dropdown muncul saat di-hover
    cartIcon.addEventListener("mouseenter", function () {
        cartDropdown.style.display = "block";
    });

    cartDropdown.addEventListener("mouseleave", function () {
        cartDropdown.style.display = "none";
    });

    // ✅ Muat ulang tampilan saat halaman dibuka
    updateCartView();
});


// dropdown profile
document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById("profile-icon");
    const profileDropdown = document.getElementById("profile-dropdown");

    profileIcon.addEventListener("click", function (event) {
        event.preventDefault();
        profileDropdown.style.display = (profileDropdown.style.display === "block") ? "none" : "block";
    });

    // Menutup dropdown jika klik di luar
    document.addEventListener("click", function (event) {
        if (!profileIcon.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = "none";
        }
    });
});


// javascript waktu headphone
document.addEventListener("DOMContentLoaded", function () {
    // Tentukan tanggal akhir countdown (Format: YYYY-MM-DD HH:MM:SS)
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

        // Hitung sisa waktu
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        // Tampilkan ke dalam elemen HTML
        document.getElementById("days").innerText = days < 10 ? "0" + days : days;
        document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
        document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
    }

    // Jalankan fungsi setiap 1 detik
    setInterval(updateCountdown, 1000);
});


//script untuk jumlah product di show

function decreaseQuantity() {
    let quantity = document.getElementById('quantity');
    if (quantity.value > 1) {
        quantity.value = parseInt(quantity.value) - 1;
    }
}

function increaseQuantity() {
    let quantity = document.getElementById('quantity');
    quantity.value = parseInt(quantity.value) + 1;
}

// thumbnail show product
function changeImage(imageSrc, element) {
    document.getElementById('mainImage').src = imageSrc;

    // Hapus class 'active' dari semua thumbnail
    let thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumb => thumb.classList.remove('active'));

    // Tambahkan class 'active' ke thumbnail yang diklik
    element.classList.add('active');
}