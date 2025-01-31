<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-10">
        <h2 class="text-center text-2xl font-bold mb-6">Dashboard Ringkasan Data</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Jumlah Produk</h3>
                <p class="text-2xl mt-2">300</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Jumlah Kategori Produk</h3>
                <p class="text-2xl mt-2">300</p>
            </div>
            <div class="bg-red-500 text-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">Jumlah Klik Produk</h3>
                <p class="text-2xl mt-2">500</p>
            </div>
            <div class="mt-10 p-6 bg-white shadow-md rounded-lg">
            <h3 class="text-xl font-semibold mb-4">Grafik Data</h3>
            <canvas id="dataChart"></canvas>
        </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('dataChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Jumlah Produk', 'Jumlah Kategori', 'Jumlah Klik'],
                datasets: [{
                    label: 'Total',
                    data: [300, 300, 500],
                    backgroundColor: ['#3b82f6', '#22c55e', '#ef4444'],
                    borderColor: ['#1e40af', '#166534', '#b91c1c'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
