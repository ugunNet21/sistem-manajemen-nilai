<!-- js/Components/Admin/Dashboard/StatCard.vue -->
<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    value: [String, Number],
    icon: String,
    color: String,
});

const colorClasses = computed(() => {
    const classes = {
        blue: { border: 'border-blue-500', bg: 'bg-blue-100', text: 'text-blue-600' },
        green: { border: 'border-green-500', bg: 'bg-green-100', text: 'text-green-600' },
        purple: { border: 'border-purple-500', bg: 'bg-purple-100', text: 'text-purple-600' },
        orange: { border: 'border-orange-500', bg: 'bg-orange-100', text: 'text-orange-600' }
    };
    return classes[props.color] || classes.blue;
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm p-6" :class="`border-l-4 ${colorClasses.border}`">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">{{ label }}</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ value }}</p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" :class="colorClasses.bg">
                <i :class="[icon, colorClasses.text, 'text-xl']"></i>
            </div>
        </div>
    </div>
</template>
