<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart } from "vue-chart-3";
import { computed, onMounted, reactive } from "vue"

const labels = computed(() => props.data.labels )
const totals = computed(() => props.data.totals ) 
const title = computed(() => props.data.title) 

Chart.register(...registerables);
const barData = reactive({
    labels: labels,
    datasets: [
        {
            label: title,
            data: totals,
            backgroundColor: "rgb(75, 192, 192)",
            tension: 0.1,
        }
    ]
})

const props = defineProps({
    data: Object
})
</script>

<template>
    <div v-show="props.data">
        <BarChart :chartData="barData" />
    </div>
</template>