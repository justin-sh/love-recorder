<script setup lang="ts">
import Chart from 'primevue/chart';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    type: 'pie' | 'doughtnut' | 'line' | 'bar' | 'radar' | 'polarArea',
    options: object
    data: object
    class?: HTMLAttributes['class']
}>();
</script>

<template>

    <Chart v-bind="props" />

</template>
