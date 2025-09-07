<script setup lang="ts">
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref, useTemplateRef } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';
import axios from 'axios';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'List children events',
        href: route('event.list')
    }
];

const nextPage = useTemplateRef('nextPage');

const gotoEditEvent = function(event) {
    router.get(route('event.edit', event.id));
};

const page = usePage();
const events = ref(page.props.events.data);


useIntersectionObserver(nextPage, ([{ isIntersecting }]) => {
    if (!isIntersecting || !page.props.events.links.next) {
        return;
    }

    // console.log(page.props.events.links.next)
    axios.get(page.props.events.links.next).then((response) => {
        // console.log(response.data);

        events.value = [...events.value, ...response.data.data];
        page.props.events.links = response.data.links;

    });
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="List Children Event" />
        <div class="px-4 pb-4">
            <table class="table-auto border border-gray-400 dark:border-gray-500 mt-4 w-full">
                <thead class="hidden md:table-header-group">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 py-2">Event Id</th>
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
                <tr v-for="c in events" :key="c.id" class="hover:bg-accent flex flex-col md:table-row">
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2 text-center py-2"
                        data-title="Event Id">
                        #{{ c.id }} [{{ c.event_at_hr }}]
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="For">{{ c.for }}
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="Type">{{ c.type }}
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="Details">
                        <template
                            v-if="c.details && Object.keys(c.details).length == 1 && Object.keys(c.details).includes('qty')">
                            {{ c.details['qty']['v'] + c.details['qty']['unit'] }}
                        </template>
                        <template v-else>
                            <template v-for="(v,k) in c.details">
                                {{ k + ': ' + v['v'] + v['unit'] }}
                            </template>
                        </template>
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="At">{{ c.event_at }}
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="End">{{ c.event_end }}
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2"
                        data-title="Note">{{ c.note }}
                    </td>
                    <td class="border-0 border-b md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2 text-center"
                        data-title="Action">
                        <Button style="cursor: pointer;" @click="gotoEditEvent(c)">Edit Event</Button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div ref="nextPage"></div>
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
