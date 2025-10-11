<!-- resources/js/Components/Admin/FlashMessage.vue -->
<script setup>
import { computed, watch, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Akses props
const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success');

const flash = computed(() => page.props.flash);

watch(flash, (newValue) => {
    if (newValue.success) {
        message.value = newValue.success;
        type.value = 'success';
        show.value = true;
        setTimeout(() => show.value = false, 3000);
    } else if (newValue.error) {
        message.value = newValue.error;
        type.value = 'error';
        show.value = true;
        setTimeout(() => show.value = false, 3000);
    }
}, { deep: true });

// Style untuk notifikasi berdasarkan tipe (success/error)
const notificationClass = computed(() => {
    return {
        'bg-green-500': type.value === 'success',
        'bg-red-500': type.value === 'error',
    };
});
</script>

<template>
    <!-- Transition untuk animasi muncul dan hilang -->
    <transition enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="show" :class="notificationClass"
            class="fixed top-5 right-5 z-50 max-w-sm w-full text-white rounded-lg shadow-lg pointer-events-auto">
            <div class="p-4 flex items-center">
                <div class="flex-shrink-0">
                    <!-- Icon Success -->
                    <svg v-if="type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <!-- Icon Error -->
                    <svg v-if="type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-sm">{{ message }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false"
                        class="-mx-1.5 -my-1.5 bg-transparent rounded-md p-1.5 inline-flex text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-500 focus:ring-white">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
