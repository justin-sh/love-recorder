<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Child } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'List children',
        href: '/children/list',
    },
];

const page = usePage();
const children = page.props.children as Child[];

const gotoAddEvent = function (child: Child) {
    router.get('/event/add', { c_id: child.id });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="List Children" />
        <div class="px-4">
            <table class="mt-4 w-full table-auto border border-gray-400 dark:border-gray-500">
                <thead class="hidden md:table-header-group">
                    <tr>
                        <th class="border border-gray-300 py-2 dark:border-gray-600">Id</th>
                        <th class="border border-gray-300 dark:border-gray-600">Name</th>
                        <th class="border border-gray-300 dark:border-gray-600">Gender</th>
                        <th class="border border-gray-300 dark:border-gray-600">Birthday</th>
                        <th class="border border-gray-300 dark:border-gray-600">Age</th>
                        <th class="border border-gray-300 dark:border-gray-600">Height</th>
                        <th class="border border-gray-300 dark:border-gray-600">Weight</th>
                        <th class="border border-gray-300 dark:border-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="c in children" :key="c.id" class="flex flex-col hover:bg-blue-50 md:table-row">
                        <td
                            class="flex border-0 border-gray-300 py-2 ps-2 text-center before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Id"
                        >
                            {{ c.id }}
                        </td>
                        <td
                            class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Name"
                        >
                            {{ c.name }}
                        </td>
                        <td
                            class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Gender"
                        >
                            {{ c.gender }}
                        </td>
                        <td
                            class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Birthday"
                        >
                            {{ c.birthday }}
                        </td>
                        <td class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600" data-title="Age">
                            <template v-if="c.age?.year">{{ c.age?.year }}ys</template> <template v-if="c.age?.month">{{ c.age?.month }}ms</template>
                            <template v-if="c.age?.day">{{ c.age?.day + 1 }}ds</template>
                        </td>
                        <td
                            class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Height"
                        >
                            {{ c.height ?? 'Unknown' }} cm
                        </td>
                        <td
                            class="flex border-0 border-gray-300 ps-2 before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Weight"
                        >
                            {{ c.weight ?? 'Unknown' }} gram
                        </td>
                        <td
                            class="flex border-0 border-b border-gray-300 ps-2 text-center before:font-bold md:table-cell md:border dark:border-gray-600"
                            data-title="Action"
                        >
                            <Button as="div" @click="gotoAddEvent(c)">Add Event</Button>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        min-width: 50%;
        text-align: left;
        content: attr(data-title);
    }
}
</style>
