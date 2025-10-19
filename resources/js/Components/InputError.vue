<!--js/Components/InputError.vue-->
<script setup>
defineProps({
    message: String,
    type: {
        type: String,
        default: 'error' // error, warning, success
    }
});

const typeConfig = {
    error: {
        icon: 'fas fa-exclamation-circle',
        class: 'text-red-600 bg-red-50 border-red-200'
    },
    warning: {
        icon: 'fas fa-exclamation-triangle',
        class: 'text-yellow-600 bg-yellow-50 border-yellow-200'
    },
    success: {
        icon: 'fas fa-check-circle',
        class: 'text-green-600 bg-green-50 border-green-200'
    }
};
</script>

<template>
    <div v-show="message" class="mt-2 animate-fade-in">
        <div :class="[
            'flex items-center space-x-2 p-3 rounded-lg border text-sm font-medium',
            typeConfig[type].class
        ]">
            <i :class="typeConfig[type].icon"></i>
            <span>{{ message }}</span>
        </div>
    </div>
</template>