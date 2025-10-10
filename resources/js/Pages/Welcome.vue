<!-- resources/js/Pages/Welcome.vue -->
<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';

const { auth } = usePage().props;

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const isAuthenticated = !!auth.user;
</script>

<template>
    <Head title="Sistem Nilai Siswa - Dashboard Pendidikan Modern" />
    
    <FrontendLayout>
        <template #auth-buttons>
            <!-- Hanya tampilkan login/register jika belum login -->
            <Link 
                v-if="canLogin && !isAuthenticated"
                :href="route('login')" 
                class="px-4 py-2 rounded-lg text-blue-600 border border-blue-600 hover:bg-blue-600 hover:text-white transition"
            >
                Login
            </Link>
            <Link 
                v-if="canRegister && !isAuthenticated"
                :href="route('register')" 
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
            >
                Daftar
            </Link>
        </template>

        <template #mobile-auth-buttons>
            <!-- Hanya tampilkan login/register jika belum login -->
            <Link 
                v-if="canLogin && !isAuthenticated"
                :href="route('login')" 
                class="block text-blue-600 hover:text-blue-700 py-2"
            >
                Login
            </Link>
            <Link 
                v-if="canRegister && !isAuthenticated"
                :href="route('register')" 
                class="block bg-blue-600 text-white rounded-lg py-2 hover:bg-blue-700 transition"
            >
                Daftar
            </Link>
        </template>

        <!-- Hero Section -->
        <section class="pt-28 pb-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white text-center px-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Digitalisasi Penilaian Siswa dengan <span class="text-yellow-300">SistemNilai</span>
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8">
                    Platform modern untuk mengelola data siswa, nilai, dan laporan akademik secara cepat, aman, dan efisien.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <!-- Tampilkan tombol berbeda berdasarkan status login -->
                    <Link 
                        v-if="!isAuthenticated && canRegister"
                        :href="route('register')" 
                        class="px-6 py-3 bg-yellow-400 text-blue-800 font-semibold rounded-lg hover:bg-yellow-300 transition"
                    >
                        Coba Sekarang
                    </Link>
                    <Link 
                        v-else-if="isAuthenticated"
                        :href="route('dashboard')" 
                        class="px-6 py-3 bg-yellow-400 text-blue-800 font-semibold rounded-lg hover:bg-yellow-300 transition"
                    >
                        Ke Dashboard
                    </Link>
                    <a href="#fitur" class="px-6 py-3 border border-white rounded-lg hover:bg-white hover:text-blue-700 transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

        <!-- Fitur Section -->
        <section id="fitur" class="py-20 px-6 bg-white">
            <div class="max-w-6xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-12 text-gray-800">Fitur Unggulan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 flex items-center justify-center rounded-full mb-6">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Dashboard Interaktif</h3>
                        <p class="text-gray-600">Pantau statistik siswa, rata-rata nilai, dan performa kelas dalam satu tampilan intuitif.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-green-100 text-green-600 flex items-center justify-center rounded-full mb-6">
                            <i class="fas fa-file-excel text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Import & Export Data</h3>
                        <p class="text-gray-600">Kelola nilai dengan mudah melalui fitur impor dan ekspor Excel tanpa ribet.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-8 shadow-sm hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-purple-100 text-purple-600 flex items-center justify-center rounded-full mb-6">
                            <i class="fas fa-lock text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Keamanan Data</h3>
                        <p class="text-gray-600">Data siswa tersimpan dengan aman menggunakan enkripsi dan autentikasi multi-level.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang Section -->
        <section id="tentang" class="py-20 bg-gray-50 px-6">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Tentang SistemNilai</h2>
                    <p class="text-gray-600 mb-4">
                        SistemNilai adalah solusi digital yang memudahkan guru dan sekolah dalam pengelolaan nilai siswa secara efisien.
                        Dengan tampilan yang sederhana, data terorganisir dengan baik, dan akses cepat, setiap guru dapat bekerja lebih produktif.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Didesain responsif, kompatibel dengan perangkat apapun, dan dapat diintegrasikan dengan sistem sekolah lain.
                    </p>
                    <!-- Tampilkan tombol berbeda berdasarkan status login -->
                    <Link 
                        v-if="!isAuthenticated && canRegister"
                        :href="route('register')" 
                        class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition"
                    >
                        Daftar Sekarang
                    </Link>
                    <Link 
                        v-else-if="isAuthenticated"
                        :href="route('dashboard')" 
                        class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition"
                    >
                        Buka Dashboard
                    </Link>
                </div>
                <div class="flex justify-center">
                    <img src="https://cdn.dribbble.com/userupload/24922426/file/original-da2eb7c50d490988d85a0be18060eaf1.jpg?resize=752x&vertical=center" 
                         alt="Ilustrasi Sistem Nilai"
                         class="rounded-2xl shadow-lg w-full md:w-4/5">
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="daftar" class="py-20 bg-gradient-to-r from-blue-700 to-purple-700 text-center text-white px-6">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold mb-4">
                    {{ isAuthenticated ? 'Selamat Datang Kembali!' : 'Mulai Digitalisasi Penilaian Sekarang!' }}
                </h2>
                <p class="text-blue-100 mb-8">
                    {{ isAuthenticated 
                        ? 'Lanjutkan mengelola data siswa dan nilai akademik dengan SistemNilai.' 
                        : 'Daftar gratis dan nikmati kemudahan mengelola data siswa, nilai, serta laporan sekolah dengan SistemNilai.'
                    }}
                </p>
                <!-- Tampilkan tombol berbeda berdasarkan status login -->
                <Link 
                    v-if="!isAuthenticated && canLogin"
                    :href="route('login')" 
                    class="px-6 py-3 bg-yellow-400 text-blue-800 font-semibold rounded-lg hover:bg-yellow-300 transition"
                >
                    Login Sekarang
                </Link>
                <Link 
                    v-else-if="isAuthenticated"
                    :href="route('dashboard')" 
                    class="px-6 py-3 bg-yellow-400 text-blue-800 font-semibold rounded-lg hover:bg-yellow-300 transition"
                >
                    Lanjutkan ke Dashboard
                </Link>
            </div>
        </section>
    </FrontendLayout>
</template>