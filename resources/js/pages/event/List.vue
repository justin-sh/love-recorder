<script setup lang="ts">
import Loading from '@/components/Loading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import axios from '@/lib/axios';
import type { BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useIntersectionObserver } from '@vueuse/core';
import { ref, useTemplateRef } from 'vue';
import { getTenantId } from '@/lib/utils';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'List children events',
        href: route('event.list', getTenantId())
    }
];

const nextPage = useTemplateRef('nextPage');

const gotoEditEvent = function(event) {
    router.get(route('event.edit', [getTenantId(), event.id]));
};

const page = usePage();
const events = ref(page.props.events.data);
const loading = ref(false);

useIntersectionObserver(nextPage, ([{ isIntersecting }]) => {
    if (!isIntersecting || !page.props.events.links.next) {
        return;
    }

    // console.log(page.props.events.links.next)
    loading.value = true;
    axios.get(page.props.events.links.next).then((response) => {
        // console.log(response.data);

        events.value = [...events.value, ...response.data.data];
        page.props.events.links = response.data.links;

        loading.value = false;
    });
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="List Children Event" />
        <div class="px-4 pb-4">
            <table class="mt-4 w-full table-auto border border-gray-400 dark:border-gray-500">
                <thead class="hidden md:table-header-group">
                <tr>
                    <th class="border border-gray-300 py-2 dark:border-gray-600">Event Id</th>
                    <th class="border border-gray-300 dark:border-gray-600">Child</th>
                    <th class="border border-gray-300 dark:border-gray-600">Type</th>
                    <th class="border border-gray-300 dark:border-gray-600">Details</th>
                    <th class="border border-gray-300 dark:border-gray-600">At</th>
                    <th class="border border-gray-300 dark:border-gray-600">End</th>
                    <th class="border border-gray-300 dark:border-gray-600">Note</th>
                    <th class="border border-gray-300 dark:border-gray-600">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="c in events" :key="c.id" class="flex flex-col hover:bg-accent md:table-row">
                    <td
                        class="flex border-0 border-gray-300 py-2 ps-2 text-center before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="Event Id"
                    >
                        #{{ c.id }} [{{ c.event_at_hr }}]
                    </td>
                    <td class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="For">
                        {{ c.for }}
                    </td>
                    <td
                        class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="Type"
                    >
                        {{ c.type }}
                    </td>
                    <td
                        class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="Details"
                    >
                        <template
                            v-if="c.details && Object.keys(c.details).length == 1 && Object.keys(c.details).includes('qty')">
                            {{ c.details['qty']['v'] + c.details['qty']['unit'] }}
                        </template>
                        <template v-else>
                            <template v-for="(v, k) in c.details">
                                {{ k + ': ' + v['v'] + v['unit'] }}
                            </template>
                        </template>
                    </td>
                    <td class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="At">
                        {{ c.event_at }}
                    </td>
                    <td class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="End">
                        {{ c.event_end }}
                    </td>
                    <td
                        class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="Note"
                    >
                        {{ c.note }}
                    </td>
                    <td
                        class="flex border-0 border-b border-gray-300 ps-2 text-center before:font-bold md:table-cell md:border dark:border-gray-600"
                        data-title="Action"
                    >
                        <Button style="cursor: pointer" @click="gotoEditEvent(c)">Edit Event</Button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div ref="nextPage" class="mt-3 flex justify-center">
                <Loading v-if="loading" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@media (width < 48rem) {
    tr {
        padding-top: 2px;
        padding-bottom: 2px;
    }

    td {
        padding-top: 2px;
    }

    td::before {
        min-width: 30%;
        text-align: left;
        content: attr(data-title);
    }
}
</style>
