<!-- resources/js/Layouts/FrontendLayout.vue -->
<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const menuOpen = ref(false);
const { auth } = usePage().props;

const isAuthenticated = computed(() => !!auth.user);
const user = computed(() => auth.user);
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header / Navbar -->
        <header class="fixed top-0 inset-x-0 bg-white/80 backdrop-blur-lg shadow-sm z-50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <slot name="logo">
                    <a href="/" class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                        <span class="text-xl font-bold text-blue-700">SistemNilai</span>
                    </a>
                </slot>
                
                <nav class="hidden md:flex items-center space-x-8 font-medium">
                    <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                    <a href="#tentang" class="hover:text-blue-600 transition">Tentang</a>
                    <a href="#kontak" class="hover:text-blue-600 transition">Kontak</a>
                    
                    <!-- Menu tambahan untuk user yang sudah login -->
                    <a 
                        v-if="isAuthenticated" 
                        :href="route('dashboard')" 
                        class="hover:text-blue-600 transition"
                    >
                        Dashboard
                    </a>
                </nav>
                
                <div class="hidden md:flex items-center space-x-3">
                    <!-- Tampilan ketika sudah login -->
                    <div v-if="isAuthenticated" class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">
                            Halo, {{ user.name }}
                        </span>
                        <form @submit.prevent="$inertia.post(route('logout'))">
                            <button 
                                type="submit"
                                class="px-4 py-2 rounded-lg text-red-600 border border-red-600 hover:bg-red-600 hover:text-white transition"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                    
                    <!-- Tampilan ketika belum login -->
                    <div v-else class="flex items-center space-x-3">
                        <slot name="auth-buttons"></slot>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button @click="menuOpen = !menuOpen" class="md:hidden text-gray-700">
                    <i :class="menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>

            <!-- Mobile menu -->
            <div v-show="menuOpen" class="md:hidden bg-white border-t">
                <nav class="flex flex-col space-y-3 p-4 text-center font-medium">
                    <a href="#fitur" class="hover:text-blue-600">Fitur</a>
                    <a href="#tentang" class="hover:text-blue-600">Tentang</a>
                    <a href="#kontak" class="hover:text-blue-600">Kontak</a>
                    
                    <!-- Menu mobile untuk user yang sudah login -->
                    <a 
                        v-if="isAuthenticated" 
                        :href="route('dashboard')" 
                        class="hover:text-blue-600"
                    >
                        Dashboard
                    </a>
                    
                    <div class="border-t pt-3">
                        <!-- Auth buttons mobile untuk user belum login -->
                        <div v-if="!isAuthenticated">
                            <slot name="mobile-auth-buttons"></slot>
                        </div>
                        
                        <!-- Logout mobile untuk user sudah login -->
                        <div v-else class="space-y-2">
                            <div class="text-sm text-gray-600 py-2">
                                Logged in as {{ user.name }}
                            </div>
                            <form @submit.prevent="$inertia.post(route('logout'))" class="w-full">
                                <button 
                                    type="submit"
                                    class="w-full text-red-600 border border-red-600 rounded-lg py-2 hover:bg-red-600 hover:text-white transition"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer id="kontak" class="bg-gray-900 text-gray-300 py-10 px-6">
            <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10">
                <div>
                    <h3 class="text-xl font-semibold mb-3 text-white">SistemNilai</h3>
                    <p>Platform modern untuk manajemen nilai siswa, kelas, dan laporan akademik berbasis web.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-3 text-white">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#fitur" class="hover:text-white">Fitur</a></li>
                        <li><a href="#tentang" class="hover:text-white">Tentang</a></li>
                        <li><a href="#daftar" class="hover:text-white">Daftar</a></li>
                        <li v-if="isAuthenticated">
                            <a :href="route('dashboard')" class="hover:text-white">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-3 text-white">Kontak</h3>
                    <p><i class="fas fa-envelope mr-2"></i> support@sistemnilai.com</p>
                    <p><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</p>
                </div>
            </div>
            <div class="mt-10 text-center border-t border-gray-700 pt-4 text-sm text-gray-500">
                &copy; 2025 SistemNilai. Semua Hak Dilindungi.
            </div>
        </footer>
    </div>
</template>