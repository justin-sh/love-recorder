<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { SelectButton } from '@/components/ui/selectbutton';
// import { SelectButton } from 'primevue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import axios from '@/lib/axios';
import { getTenantId } from '@/lib/utils';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Tenant settings',
        href: '/settings/tenant'
    }
];

const props = usePage().props;
const processing = ref(false);
const recentlySuccessful = ref(false);
const name = ref(props.tenant.name);
const memberEmail = ref('');
const tenantRole = ref();

const tenantRightUpdate = function(v: string) {
    tenantRole.value = v;
};

function notNullCheck(v: string | null) {
    console.log(v)
    return !(v === null || v.trim().length === 0);
}

function validateEmail(email: string) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

const tenantUpdate = async function() {
    if (!notNullCheck(name.value)) {
        return;
    }
    if (!notNullCheck(memberEmail.value) || !validateEmail(memberEmail.value)) {
        return;
    }
    if (!notNullCheck(tenantRole.value)) {
        return;
    }

    processing.value = true;
    const rv = (await axios.patch(route('tenant.update', getTenantId()), {
        name: name.value,
        email: memberEmail.value,
        role: tenantRole.value
    })).data;

    console.log(rv);
    recentlySuccessful.value = true;
    processing.value = false;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Tenant settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Tenant settings" description="Update your account's tenant settings" />

                <div class="grid gap-2">
                    <Label for="name">Tenant Name</Label>
                    <Input
                        id="name"
                        class="mt-1 block w-full"
                        :default-value="props.tenant.name"
                        v-model="name"
                        required
                        autocomplete="tenant name"
                        placeholder="Tenant name"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="member">Member to Invited</Label>
                    <Input
                        id="member"
                        type="email"
                        v-model="memberEmail"
                        class="mt-1 block w-full"
                        required
                        autocomplete="member email"
                        placeholder="member-email@email.com"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="right">Member Role</Label>
                    <SelectButton id="right"
                                  :options="props.role" option-label="label" option-value="v"
                                  @update:model-value="tenantRightUpdate"
                                  :allow-empty="false" />
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="processing" @click="tenantUpdate">Update</Button>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-show="recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                    </Transition>
                </div>

            </div>
        </SettingsLayout>
    </AppLayout>
</template>
