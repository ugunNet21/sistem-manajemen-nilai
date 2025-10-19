<!-- resources/js/Pages/Admin/Students/Show.vue -->
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    student: Object,
    statistics: Object
});

// Fungsi untuk menghapus data dengan konfirmasi
const deleteStudent = () => {
    if (confirm(`Apakah Anda yakin ingin menghapus data siswa "${props.student.nama}"?`)) {
        router.delete(route('admin.students.destroy', props.student.id), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('admin.students.index'));
            }
        });
    }
};

// Fungsi untuk mendapatkan warna badge berdasarkan grade
const gradeBadgeClass = (grade) => {
    switch (grade) {
        case 'A': return 'bg-green-100 text-green-800 border-green-200';
        case 'B': return 'bg-blue-100 text-blue-800 border-blue-200';
        case 'C': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'D': return 'bg-red-100 text-red-800 border-red-200';
        default: return 'bg-gray-100 text-gray-800 border-gray-200';
    }
};

// Format angka dengan 2 digit desimal
const formatNumber = (number) => {
    return parseFloat(number).toFixed(2);
};

// Fungsi untuk mendapatkan grade dari nilai
const getGradeFromScore = (nilai) => {
    if (nilai >= 85) return 'A';
    if (nilai >= 70) return 'B';
    if (nilai >= 60) return 'C';
    return 'D';
};
</script>

<template>
    <div>

        <Head :title="`Detail Siswa - ${student.nama}`" />

        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detail Siswa</h1>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap data siswa dan nilai</p>
                </div>
                <div class="flex items-center space-x-2 mt-4 md:mt-0">
                    <Link :href="route('admin.students.index')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                    </Link>
                    <!-- Tombol Preview PDF -->
                    <Link :href="route('admin.students.report.preview', student.id)" target="_blank"
                        class="px-4 py-2 text-sm font-medium text-green-700 bg-white border border-green-300 rounded-lg hover:bg-green-50 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Preview Raport
                    </Link>

                    <!-- Tombol Download PDF -->
                    <a :href="route('admin.students.report.pdf', student.id)"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm inline-flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export PDF
                    </a>
                    <Link :href="route('admin.students.edit', student.id)"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm inline-flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                    </Link>
                    <button @click="deleteStudent"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm inline-flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Siswa -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Siswa</h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ student.nama.charAt(0).toUpperCase() }}
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ student.nama }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Kelas</label>
                            <p class="text-lg font-semibold text-gray-800 mt-1">{{ student.kelas }}</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <label class="text-sm font-medium text-gray-500">ID Siswa</label>
                            <p class="text-sm text-gray-600 mt-1 font-mono">{{ student.id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik Ringkas -->
                <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Total Mata Pelajaran</span>
                            <span class="text-lg font-bold text-purple-600">{{ statistics.total_mapel }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Total Nilai</span>
                            <span class="text-lg font-bold text-blue-600">{{ student.nilai_count }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Rata-rata</span>
                            <span class="text-lg font-bold text-green-600">{{ formatNumber(student.rata_rata) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Grade</span>
                            <span class="px-3 py-1 rounded-full text-sm font-bold border"
                                :class="gradeBadgeClass(student.grade)">
                                {{ student.grade }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Nilai -->
            <div class="lg:col-span-2">
                <!-- Kartu Statistik Nilai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg mr-4">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nilai Tertinggi</p>
                                <p class="text-2xl font-bold text-gray-800">{{ formatNumber(student.nilai_tertinggi) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-lg mr-4">
                                <i class="fas fa-chart-line text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nilai Terendah</p>
                                <p class="text-2xl font-bold text-gray-800">{{ formatNumber(student.nilai_terendah) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Nilai per Mata Pelajaran -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Detail Nilai Mata Pelajaran</h2>
                        <p class="text-sm text-gray-500 mt-1">Daftar lengkap nilai untuk semua mata pelajaran</p>
                    </div>

                    <div v-if="student.nilai && student.nilai.length > 0" class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mata
                                        Pelajaran</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Kelas</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Nilai</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Grade</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                        Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="(nilai, index) in student.nilai" :key="nilai.id"
                                    class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ nilai.mapel || 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-600">
                                        {{ nilai.kelas || '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-gray-700">
                                            {{ formatNumber(nilai.nilai) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border"
                                            :class="gradeBadgeClass(nilai.grade)">
                                            {{ nilai.grade }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-600">
                                        {{ new Date(nilai.created_at).toLocaleDateString('id-ID') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-12">
                        <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium mb-2">Belum ada data nilai</p>
                        <p class="text-gray-400 text-sm">Siswa ini belum memiliki catatan nilai.</p>
                    </div>

                    <!-- Ringkasan per Mapel -->
                    <div v-if="statistics.mapel_dengan_nilai && Object.keys(statistics.mapel_dengan_nilai).length > 0"
                        class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Ringkasan per Mata Pelajaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                            <div v-for="(stats, mapel) in statistics.mapel_dengan_nilai" :key="mapel"
                                class="bg-white rounded-lg p-3 border border-gray-200">
                                <div class="font-medium text-gray-800 mb-1">{{ mapel }}</div>
                                <div class="flex justify-between text-xs text-gray-600">
                                    <span>Rata: {{ formatNumber(stats.rata_rata) }}</span>
                                    <span>Total: {{ stats.count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>