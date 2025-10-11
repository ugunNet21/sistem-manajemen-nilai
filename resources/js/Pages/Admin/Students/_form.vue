<!-- resources/js/Pages/Admin/Students/_form.vue -->
<script setup>
import { defineProps, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Props untuk menerima data dari parent component
const props = defineProps({
    form: Object, 
    submitAction: Function,
    actionLabel: {
        type: String,
        default: 'Simpan'
    }
});

// Emits untuk mengirim event ke parent
const emit = defineEmits(['submit']);
</script>

<template>
    <form @submit.prevent="submitAction">
        <div class="space-y-6">
            <!-- Input Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                <div class="mt-1">
                    <input type="text" id="nama" v-model="form.nama"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        :class="{ 'border-red-500': form.errors.nama }"
                        placeholder="Masukkan nama siswa"
                    >
                    <p v-if="form.errors.nama" class="mt-2 text-sm text-red-600">{{ form.errors.nama }}</p>
                </div>
            </div>

            <!-- Input Kelas -->
            <div>
                <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                <div class="mt-1">
                    <input type="text" id="kelas" v-model="form.kelas"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                        :class="{ 'border-red-500': form.errors.kelas }"
                        placeholder="Contoh: 7A"
                    >
                    <p v-if="form.errors.kelas" class="mt-2 text-sm text-red-600">{{ form.errors.kelas }}</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8 flex justify-end">
            <button type="submit" :disabled="form.processing"
                class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50"
            >
                <i class="fas fa-spinner fa-spin mr-2" v-if="form.processing"></i>
                {{ actionLabel }}
            </button>
        </div>
    </form>
</template>
