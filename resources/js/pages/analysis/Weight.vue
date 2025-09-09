<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { Radiobox } from '@/components/ui/radiobox';
import { Label } from '@/components/ui/label';
import { VueChart } from '@/components/ui/chart';
import RadioboxItem from '@/components/ui/radiobox/RadioboxItem.vue';
import Heading from '@/components/Heading.vue';
import { ref, watch } from 'vue';
import axios from '@/lib/axios';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Analysis',
        href: ''
    },
    {
        title: 'Analysis Weight',
        href: '/analysis/weight'
    }
];

const props = defineProps({
    children: Array<{ key: number, value: string }>,
    data: Array<Event>
});

const child = ref();

const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--color-chart-1');
    const textColorSecondary = documentStyle.getPropertyValue('--color-chart-2');
    const surfaceBorder = documentStyle.getPropertyValue('--color-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
};

const setChartData = (data: object[]) => {
    const documentStyle = getComputedStyle(document.documentElement);

    const labels = [];
    const wData = [];
    let prev = '';


    data.forEach(e => {
        if (prev !== '') {
            const x0 = new Date(prev);
            x0.setHours(0, 0, 0, 0);
            x0.setDate(x0.getDate() + 1);
            const x1 = new Date(e.event_at.substring(0, 10));
            x1.setHours(0, 0, 0, 0);

            while (x0 < x1) {
                labels.push(new Date(Date.UTC(x0.getFullYear(), x0.getMonth(), x0.getDate())).toISOString().substring(0, 10));
                wData.push(NaN);

                x0.setDate(x0.getDate() + 1);
            }
        }
        prev = e.event_at.substring(0, 10);
        labels.push(prev);
        wData.push(e.details.qty.v);
    });

    // labels.push('2025-09-19');
    // wData.push(NaN);
    // labels.push('2025-09-29');
    // wData.push(3200);

    return {
        labels: labels,
        datasets: [
            {
                label: 'Weight',
                fill: false,
                borderColor: documentStyle.getPropertyValue('--p-cyan-500'),
                yAxisID: 'y',
                tension: 0.4,
                data: wData,
                spanGaps: true,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(192,75,75)'),
                    borderDash: ctx => skipped(ctx, [6, 6])
                }
            }
        ]
    };
};

const weightOptions = setChartOptions();
const weightData = ref(setChartData(props.data));

watch(child, async function() {
    // console.log(child.value)

    const d = await (await axios.get(route('analysis.weight'), { params: { c_id: child.value } })).data;
    // console.log(d)
    weightData.value = setChartData(d);
});

// const page = usePage()
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Analysis Weight" />

        <div class="w-full md:w-5xl mt-4 px-4 py-6">
            <Heading title="Analysis Weight" description="Analysis weight" />

            <div class="grid gap-2">
                <Label for="child">Child</Label>
                <Radiobox id="child" :default-value="children?.[0].key" v-model="child">
                    <RadioboxItem :label="child.value" name="child" :value="child.key" :id="'child-' + child.key"
                                  v-for="child in children" />
                </Radiobox>
            </div>

            <VueChart type="line" :data="weightData" :options="weightOptions" class="h-[20rem] md:h-[35rem]" />
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
