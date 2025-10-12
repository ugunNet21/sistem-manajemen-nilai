<!--js/Components/EnhancedCard.vue-->
<script setup>
defineProps({
    title: {
        type: String,
        default: ''
    },
    subtitle: {
        type: String,
        default: ''
    },
    padding: {
        type: String,
        default: 'p-6'
    },
    shadow: {
        type: Boolean,
        default: true
    },
    border: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <div :class="[
        'bg-white rounded-xl transition-all duration-200',
        padding,
        shadow ? 'shadow-sm hover:shadow-md' : '',
        border ? 'border border-gray-200' : ''
    ]">
        <div v-if="title || subtitle" class="mb-6">
            <h3 v-if="title" class="text-lg font-semibold text-gray-900">{{ title }}</h3>
            <p v-if="subtitle" class="text-sm text-gray-600 mt-1">{{ subtitle }}</p>
        </div>
        
        <slot />
    </div>
</template>