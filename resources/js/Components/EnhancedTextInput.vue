<!--js/Components/EnhancedTextInput.vue-->
<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    label: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    error: {
        type: String,
        default: ''
    },
    icon: {
        type: String,
        default: ''
    },
    success: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);

const value = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
    }
});
</script>

<template>
    <div class="space-y-2">
        <label v-if="label" class="block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <div class="relative rounded-lg shadow-sm">
            <div v-if="icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i :class="`${icon} text-gray-400`"></i>
            </div>
            
            <input
                :type="type"
                v-model="value"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :class="[
                    'block w-full rounded-lg border-gray-300 transition-all duration-200 focus:ring-2 focus:border-transparent',
                    icon ? 'pl-10 pr-4' : 'px-4',
                    'py-3 border placeholder-gray-400',
                    disabled ? 'bg-gray-100 cursor-not-allowed' : 'bg-white',
                    error ? 'border-red-300 focus:ring-red-500' : 
                    success ? 'border-green-300 focus:ring-green-500' : 
                    'focus:ring-blue-500 focus:border-blue-500'
                ]"
            />
        </div>
        
        <p v-if="error" class="text-sm text-red-600 flex items-center space-x-1">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ error }}</span>
        </p>
    </div>
</template>