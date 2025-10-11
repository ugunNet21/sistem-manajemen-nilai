<!-- js/Components/Admin/Dashboard/GradeDistributionChart.vue -->
<script setup>
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    data: {
        type: Array,
        default: () => [],
    }
});

const chartData = computed(() => {
    const grades = { A: 0, B: 0, C: 0, D: 0 };

    props.data.forEach(item => {
        if (grades.hasOwnProperty(item.grade)) {
            grades[item.grade] = item.count;
        }
    });

    const labels = Object.keys(grades);
    const chartValues = Object.values(grades);

    return {
        labels: labels,
        datasets: [
            {
                label: 'Jumlah Siswa',
                data: chartValues,
                backgroundColor: [
                    'rgba(74, 222, 128, 0.6)', // Green-400 (A)
                    'rgba(96, 165, 250, 0.6)', // Blue-400 (B)
                    'rgba(250, 204, 21, 0.6)',  // Yellow-400 (C)
                    'rgba(248, 113, 113, 0.6)', // Red-400 (D)
                ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',   // Green-500
                    'rgba(59, 130, 246, 1)',  // Blue-500
                    'rgba(234, 179, 8, 1)',   // Yellow-500
                    'rgba(239, 68, 68, 1)',   // Red-500
                ],
                borderWidth: 1,
                borderRadius: 5,
            },
        ],
    };
});

// Opsi untuk kustomisasi tampilan chart
const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
        },
        tooltip: {
            backgroundColor: '#1f2937',
            titleFont: {
                size: 14,
                weight: 'bold',
            },
            bodyFont: {
                size: 12,
            },
            callbacks: {
                label: function (context) {
                    return `Jumlah: ${context.raw} siswa`;
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                precision: 0,
            },
            grid: {
                color: '#e5e7eb',
            }
        },
        x: {
            grid: {
                display: false,
            }
        }
    }
}));
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Distribusi Grade Nilai</h3>

        <!-- Container untuk chart dengan tinggi yang ditentukan -->
        <div class="relative h-72">
            <Bar :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>
