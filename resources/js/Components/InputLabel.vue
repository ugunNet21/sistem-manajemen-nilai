<!--js/Components/InputLabel.vue-->
<script setup>
defineProps({
    value: String,
    required: {
        type: Boolean,
        default: false
    },
    helper: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <label class="block space-y-1">
        <div class="flex items-center space-x-2">
            <span class="font-semibold text-sm text-gray-900">
                <span v-if="value">{{ value }}</span>
                <span v-else><slot /></span>
            </span>
            <span v-if="required" class="text-red-500 text-xs">*</span>
        </div>
        <p v-if="helper" class="text-xs text-gray-500 font-normal">
            {{ helper }}
        </p>
    </label>
</template>