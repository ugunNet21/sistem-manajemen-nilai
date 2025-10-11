<!-- resources/js/Pages/Admin/Students/Edit.vue -->
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StudentForm from './_form.vue';

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    student: Object
});

const form = useForm({
    nama: props.student.nama,
    kelas: props.student.kelas,
});

// Fungsi untuk menangani update data
const submit = () => {
    form.put(route('admin.students.update', props.student.id));
};
</script>

<template>
    <div>

        <Head :title="`Edit Siswa - ${student.nama}`" />

        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Data Siswa</h1>
                    <p class="text-sm text-gray-500">Anda sedang mengubah data untuk {{ student.nama }}.</p>
                </div>
                <Link :href="route('admin.students.index')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <StudentForm :form="form" :submitAction="submit" actionLabel="Perbarui" />
            </div>
        </div>
    </div>
</template>
