<!-- resources/js/Pages/Admin/Grades/ModalImportExcel.vue -->
<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(['close']);

const form = useForm({
    file: null,
});

const closeModal = () => {
    emit('close');
    form.reset();
    form.clearErrors();
};

const submitImport = () => {
    form.post(route('grades.import'), {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    });
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="closeModal" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Import Data Excel</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form @submit.prevent="submitImport" class="space-y-4">
                    <div>
                        <label for="file-upload" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 transition cursor-pointer block">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">{{ form.file ? form.file.name : 'Klik atau drag & drop file' }}</p>
                            <p class="text-sm text-gray-500">Format: .xlsx, .xls</p>
                            <input id="file-upload" type="file" @input="form.file = $event.target.files[0]" accept=".xlsx,.xls" class="hidden">
                        </label>
                        <p v-if="form.errors.file" class="text-red-500 text-xs mt-1">{{ form.errors.file }}</p>
                    </div>
                    
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <p class="text-sm text-purple-800 font-medium mb-2">Format Excel (Gunakan Heading):</p>
                        <p class="text-xs text-purple-700">`nama_siswa` | `kelas` | `mata_pelajaran` | `nilai`</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" @click="closeModal" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" :disabled="form.processing || !form.file" class="flex-1 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                            {{ form.processing ? 'Mengimport...' : 'Import' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
