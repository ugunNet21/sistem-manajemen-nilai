<!--js/Components/EnhancedButton.vue-->
<script setup>
defineProps({
    type: {
        type: String,
        default: 'button'
    },
    variant: {
        type: String,
        default: 'primary' // primary, secondary, success, danger, outline
    },
    size: {
        type: String,
        default: 'medium' // small, medium, large
    },
    disabled: {
        type: Boolean,
        default: false
    },
    loading: {
        type: Boolean,
        default: false
    },
    icon: {
        type: String,
        default: ''
    },
    fullWidth: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['click']);
</script>

<template>
    <button :type="type" :disabled="disabled || loading" @click="emit('click')" :class="[
        'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2',
        // Sizes
        {
            'px-3 py-2 text-sm': size === 'small',
            'px-6 py-3 text-base': size === 'medium',
            'px-8 py-4 text-lg': size === 'large'
        },
        // Variants
        {
            'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500': variant === 'primary',
            'bg-purple-600 text-white hover:bg-purple-700 focus:ring-purple-500': variant === 'secondary',
            'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500': variant === 'success',
            'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500': variant === 'danger',
            'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-blue-500': variant === 'outline'
        },
        // States
        {
            'opacity-50 cursor-not-allowed': disabled || loading,
            'w-full': fullWidth
        }
    ]">
        <i v-if="loading" class="fas fa-spinner fa-spin mr-2"></i>
        <i v-else-if="icon" :class="`${icon} mr-2`"></i>

        <slot />
    </button>
</template>