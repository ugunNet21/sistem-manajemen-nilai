<!-- resources/js/Pages/Admin/Students/Index.vue -->
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import { ref } from 'vue';

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    students: Object
});

// Fungsi untuk menghapus data dengan konfirmasi
const deleteStudent = (studentId, studentName) => {
    if (confirm(`Apakah Anda yakin ingin menghapus data siswa "${studentName}"?`)) {
        router.delete(route('admin.students.destroy', studentId), {
            preserveScroll: true,
        });
    }
};

// Fungsi untuk mendapatkan warna badge berdasarkan grade
const gradeBadgeClass = (grade) => {
    switch (grade) {
        case 'A': return 'bg-green-100 text-green-800';
        case 'B': return 'bg-blue-100 text-blue-800';
        case 'C': return 'bg-yellow-100 text-yellow-800';
        case 'D': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

</script>

<template>
    <div>

        <Head title="Data Siswa" />

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Data Siswa</h1>
            <Link :href="route('admin.students.create')"
                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow-sm inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Siswa
            </Link>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kelas</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Jumlah Nilai
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Rata-rata
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Grade</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody v-if="students.data.length > 0" class="divide-y divide-gray-200">
                        <tr v-for="(siswa, index) in students.data" :key="siswa.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ students.from + index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ siswa.nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ siswa.kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ siswa.nilai_count }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ parseFloat(siswa.rata_rata).toFixed(2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold"
                                    :class="gradeBadgeClass(siswa.grade)">
                                    {{ siswa.grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <Link :href="route('admin.students.show', siswa.id)"
                                        class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition"
                                        title="Detail">
                                    <i class="fas fa-eye"></i>
                                    </Link>
                                    <Link :href="route('admin.students.edit', siswa.id)"
                                        class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    </Link>
                                    <button @click="deleteStudent(siswa.id, siswa.nama)"
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                <i class="fas fa-box-open fa-3x mb-4"></i>
                                <p>Belum ada data siswa.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <Pagination :paginator="students" />
        </div>
    </div>
</template>
