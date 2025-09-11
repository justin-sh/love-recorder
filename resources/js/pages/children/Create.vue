<script setup lang="ts">

import { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Radiobox } from '@/components/ui/radiobox';
import RadioboxItem from '@/components/ui/radiobox/RadioboxItem.vue';
import Heading from '@/components/Heading.vue';
import { DatePicker } from '@/components/ui/datepicker';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Add new child',
        href: '/children/add'
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Add Child" />

        <div class="px-4 py-6">
            <Heading title="Add Child" description="Add a new child" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <Form
                        method="post"
                        :action="route('children.store')"
                        :reset-on-success="['password', 'password_confirmation']"
                        v-slot="{ errors, processing }"
                        class="flex flex-col gap-6"
                    >
                        <div class="grid gap-6">
                            <div class="grid gap-2">
                                <Label for="name">Name</Label>
                                <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name"
                                       name="name" placeholder="Full name" />
                                <InputError :message="errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="gender">Gender</Label>
                                <Radiobox id="gender">
                                    <RadioboxItem label="Male" name="gender" value="male" id="male" />
                                    <RadioboxItem label="Female" name="gender" class="px-3" id="female"
                                                  value="female" />
                                </Radiobox>
                            </div>

                            <div class="grid gap-2">
                                <Label for="bod">Birthday</Label>
                                <DatePicker name="birthday" type="date"/>
                            </div>

                            <div class="grid gap-2">
                                <Label for="height">Height (cm, when born)</Label>
                                <Input id="height" type="number" :tabindex="3" min="1"
                                       name="height" placeholder="Height" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="weight">Weight (gram, when born)</Label>
                                <Input id="weight" type="number" :tabindex="4" min="1"
                                       name="weight" placeholder="Weight" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="submit" tabindex="5" :disabled="processing">
                                    <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />
                                    Add child
                                </Button>
                            </div>
                        </div>
                    </Form>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
