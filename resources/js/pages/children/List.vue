<script setup lang="ts">
import type { BreadcrumbItem, Child, User } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'List children',
        href: '/children/list'
    }
];

const page = usePage();
const children = page.props.children.data as Child[];

const gotoAddEvent = function(child:Child) {
    router.get('/event/add', {c_id: child.id})
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="List Children" />
        <div class="px-4">
            <table class="table-auto border border-gray-400 dark:border-gray-500 mt-4 w-full">
                <thead class="hidden md:table-header-group">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-600 py-2">Id</th>
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
                <tr v-for="c in children" :key="c.id" class="hover:bg-blue-50 flex flex-col md:table-row">
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2 text-center py-2" data-title="Id">{{ c.id }}</td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Name">{{ c.name }}</td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Gender">{{ c.gender }}</td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Birthday">{{ c.birthday }}</td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Age">
                        <template v-if="c.age?.year">{{ c.age?.year }}ys</template> <template v-if="c.age?.month">{{ c.age?.month }}ms</template> <template v-if="c.age?.day">{{ c.age?.day + 1 }}ds</template>
                    </td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Height">{{ c.height ?? 'Unknown' }} cm</td>
                    <td class="border-0 md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2" data-title="Weight">{{ c.weight ?? 'Unknown' }} gram</td>
                    <td class="border-0 border-b md:border border-gray-300 dark:border-gray-600 before:font-bold flex md:table-cell ps-2 text-center" data-title="Action">
                        <Button as="div" @click="gotoAddEvent(c)">Add Event</Button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<style scoped>
@media (width < 48rem){
    tr{
        padding-top: 2px;
        padding-bottom: 2px;
    }
    td{
        padding-top: 2px;
    }
    td::before{
        min-width: 50%;
        text-align: left;
        content: attr(data-title);
    }
}
</style>
