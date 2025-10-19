<!-- resources/js/Components/Admin/Pagination.vue -->
<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    paginator: Object
});

const formatLabel = (label) => {
    if (label.includes('pagination.previous') || label.includes('Previous')) return '‹';
    if (label.includes('pagination.next') || label.includes('Next')) return '›';
    return label;
};
</script>

<template>
    <div v-if="paginator.links.length > 3" class="px-6 py-4 border-t border-gray-200 bg-white">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Info -->
            <div class="text-sm text-gray-700">
                Menampilkan {{ paginator.from }} sampai {{ paginator.to }} dari {{ paginator.total }} hasil
            </div>

            <!-- Navigation -->
            <nav class="flex items-center space-x-1">
                <template v-for="(link, index) in paginator.links" :key="index">
                    <Link 
                        v-if="link.url"
                        :href="link.url"
                        class="px-3 py-2 text-sm rounded-lg transition-colors border"
                        :class="link.active 
                            ? 'bg-purple-600 text-white border-purple-600' 
                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
                        v-html="formatLabel(link.label)"
                    />
                    <span 
                        v-else
                        class="px-3 py-2 text-sm text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed"
                        v-html="formatLabel(link.label)"
                    />
                </template>
            </nav>
        </div>
    </div>
</template>