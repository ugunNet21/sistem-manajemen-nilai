<!-- js/Components/Admin/Dashboard/AverageBySubjectChart.vue -->
<script setup>
defineProps({
    data: Array
});

const colors = ['bg-blue-600', 'bg-green-600', 'bg-purple-600', 'bg-orange-600', 'bg-red-600', 'bg-indigo-600'];
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Rata-rata Nilai per Mapel</h3>
        <div class="space-y-4">
            <div v-for="(item, index) in data" :key="item.mapel">
                <div class="flex justify-between mb-1 text-sm">
                    <span class="text-gray-600">{{ item.mapel }}</span>
                    <span class="font-medium text-gray-800">{{ parseFloat(item.rata_rata).toFixed(1) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="h-2.5 rounded-full" :class="colors[index % colors.length]"
                        :style="{ width: `${item.rata_rata}%` }"></div>
                </div>
            </div>
        </div>
    </div>
</template>
