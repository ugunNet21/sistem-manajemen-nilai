<!-- resources/js/Pages/Admin/Grades/ModalForm.vue -->
<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch, ref } from 'vue';

const props = defineProps({
    show: Boolean,
    students: Array,
    grade: {
        type: Object,
        default: null
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    siswa_id: '',
    mapel: '',
    nilai: '',
});

const isEditMode = ref(false);

watch(() => props.grade, (newGrade) => {
    if (newGrade) {
        isEditMode.value = true;
        form.siswa_id = newGrade.siswa_id;
        form.mapel = newGrade.mapel;
        form.nilai = newGrade.nilai;
    } else {
        isEditMode.value = false;
        form.reset();
    }
});

const closeModal = () => {
    emit('close');
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    const options = {
        onSuccess: () => closeModal(),
        preserveScroll: true,
    };

    if (isEditMode.value) {
        form.put(route('admin.grades.update', props.grade.id), options);
    } else {
        form.post(route('admin.grades.store'), options);
    }
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="closeModal" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">{{ isEditMode ? 'Edit Nilai' : 'Tambah Nilai' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                        <select id="siswa_id" v-model="form.siswa_id" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" :class="{'border-red-500': form.errors.siswa_id}">
                            <option value="" disabled>Pilih Siswa</option>
                            <option v-for="student in students" :key="student.id" :value="student.id">
                                {{ student.nama }} ({{ student.kelas }})
                            </option>
                        </select>
                        <p v-if="form.errors.siswa_id" class="text-red-500 text-xs mt-1">{{ form.errors.siswa_id }}</p>
                    </div>
                    
                    <div>
                        <label for="mapel" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                        <input id="mapel" type="text" v-model="form.mapel" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" :class="{'border-red-500': form.errors.mapel}" placeholder="Contoh: Matematika">
                        <p v-if="form.errors.mapel" class="text-red-500 text-xs mt-1">{{ form.errors.mapel }}</p>
                    </div>
                    
                    <div>
                        <label for="nilai" class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100)</label>
                        <input id="nilai" type="number" v-model="form.nilai" min="0" max="100" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500" :class="{'border-red-500': form.errors.nilai}">
                        <p v-if="form.errors.nilai" class="text-red-500 text-xs mt-1">{{ form.errors.nilai }}</p>
                    </div>
                    
                    <div class="flex space-x-3 pt-4">
                        <button type="button" @click="closeModal" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" :disabled="form.processing" class="flex-1 px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition disabled:opacity-50">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
