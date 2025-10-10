<!-- resources/js/Components/Admin/FlashMessage.vue -->
<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success'); // success, error, warning, info
const timeout = ref(null);

const typeClasses = computed(() => {
    switch (type.value) {
        case 'success':
            return 'bg-green-50 border-green-200 text-green-800';
        case 'error':
            return 'bg-red-50 border-red-200 text-red-800';
        case 'warning':
            return 'bg-yellow-50 border-yellow-200 text-yellow-800';
        case 'info':
            return 'bg-blue-50 border-blue-200 text-blue-800';
        default:
            return 'bg-green-50 border-green-200 text-green-800';
    }
});

const iconClasses = computed(() => {
    switch (type.value) {
        case 'success':
            return 'fas fa-check-circle text-green-500';
        case 'error':
            return 'fas fa-exclamation-circle text-red-500';
        case 'warning':
            return 'fas fa-exclamation-triangle text-yellow-500';
        case 'info':
            return 'fas fa-info-circle text-blue-500';
        default:
            return 'fas fa-check-circle text-green-500';
    }
});

onMounted(() => {
    // Check for flash messages when component is mounted
    checkForFlash();

    // Listen for Inertia events
    window.addEventListener('inertia:start', clearFlash);
    window.addEventListener('inertia:finish', checkForFlash);
});

const checkForFlash = () => {
    const flash = page.props.flash || {};

    if (flash.success) {
        setFlash('success', flash.success);
    } else if (flash.error) {
        setFlash('error', flash.error);
    } else if (flash.warning) {
        setFlash('warning', flash.warning);
    } else if (flash.info) {
        setFlash('info', flash.info);
    }
};

const setFlash = (flashType, flashMessage) => {
    // Clear any existing timeout
    if (timeout.value) {
        clearTimeout(timeout.value);
    }

    type.value = flashType;
    message.value = flashMessage;
    show.value = true;

    // Auto-hide after 15 seconds
    timeout.value = setTimeout(() => {
        show.value = false;
    }, 15000);
};

const clearFlash = () => {
    if (timeout.value) {
        clearTimeout(timeout.value);
    }
    show.value = false;
};

const closeFlash = () => {
    clearFlash();
};
</script>

<template>
    <div v-if="show" class="fixed top-4 right-4 z-50 max-w-md w-full">
        <div :class="typeClasses" class="border rounded-lg shadow-lg p-4 transition-all duration-300 transform">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i :class="iconClasses" class="text-xl"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">{{ message }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="closeFlash" class="inline-flex rounded-md focus:outline-none">
                        <i class="fas fa-times" :class="type === 'success' ? 'text-green-500 hover:text-green-700' :
                            type === 'error' ? 'text-red-500 hover:text-red-700' :
                                type === 'warning' ? 'text-yellow-500 hover:text-yellow-700' :
                                    'text-blue-500 hover:text-blue-700'"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>