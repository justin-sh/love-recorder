<script setup lang="ts">

import { router, usePage } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import Listbox from 'primevue/listbox';
import Button from 'primevue/button';
import { onMounted, ref } from 'vue';
import { getTenantId, setTenantId } from '@/lib/utils';

const page = usePage();
const tenant = ref();

const goDashboard = () => {
    router.get(route('dashboard', getTenantId()));
};

onMounted(function() {
    if (page.props.tenant.length === 1) {
        tenant.value = page.props.tenant[0].id;

        setTenantId(page.props.tenantPrefix + tenant.value);
        goDashboard();
    }
});
</script>

<template>

    <Dialog v-if="page.props.tenant.length > 1"  :visible="true" modal header="Choose Tenant" class="w-72 md:w-84" :closable="false"
            :close-on-escape="false">
        <Listbox v-model="tenant" :options="page.props.tenant" optionLabel="name" optionValue="id" checkmark
                 :highlightOnSelect="false"
                 class="w-full min-h-[18rem]" />

        <div class="w-full text-center">
            <Button label="Go" class="mt-2 px-6" @click="goDashboard" />
        </div>
    </Dialog>

</template>
