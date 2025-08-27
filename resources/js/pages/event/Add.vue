<script setup lang="ts">

import { BreadcrumbItem, Child } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head, usePage } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Heading from '@/components/Heading.vue';
import { DatePicker } from '@/components/ui/datepicker';
import { Select } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Add new child event',
        href: '/event/add'
    }
];

function getDateTimeLocalString(d: Date) {
    d.setSeconds(0, 0);
    return new Date(d.getTime() - d.getTimezoneOffset() * 60000).toISOString().substring(0, 16);
}

const page = usePage();
const children = page.props.children as Child[];
const defaultChild = (page.props.defaultChild as Child) ?? { key: '' };
const evtTypes = page.props.type;

const evtFor = ref(defaultChild);
const evtType = ref({ key: '' });

const defaultTime = getDateTimeLocalString(new Date());
const evtAt = ref(defaultTime)
const evtEnd = ref('')
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Add Child Event" />

        <div class="px-4 py-6">
            <Heading title="Add Child Event" description="Add a new child event" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <Form
                        method="post"
                        :action="route('event.add')"
                        v-slot="{ errors, processing }"
                        class="flex flex-col gap-6"
                    >
                        <div class="grid gap-6">

                            <div class="grid gap-2 w-60">
                                <Label for="eventAt">Event At</Label>
                                <div class="flex">
                                    <DatePicker type="datetime-local" name="event_at" id="eventAt"
                                                v-model="evtAt"/>
                                    <Button type="button" class="ms-1" @click="evtAt = getDateTimeLocalString(new Date())">Now</Button>
                                </div>
                            </div>

                            <div class="grid gap-2 w-60">
                                <Label for="eventFor">Event For</Label>
                                <Select id="eventFor" :options="children" :default-value="defaultChild" v-model="evtFor"
                                        placeholder="event for" />
                                <input type="hidden" name="event_child_id" v-model="evtFor.key" />
                            </div>

                            <div class="grid gap-2 w-60">
                                <Label for="eventType">Event Type</Label>
                                <Select id='eventType' :options="evtTypes" v-model="evtType" placeholder="event type" />
                                <input type="hidden" name="type" v-model="evtType.key" />
                            </div>

                            <div class="grid gap-2 w-60">
                                <Label for="eventEnd">Event End</Label>
                                <div class="flex">
                                    <DatePicker type="datetime-local" name="event_end" id="eventEnd" v-model="evtEnd"/>
                                    <Button type="button" class="ms-1" @click="evtEnd = getDateTimeLocalString(new Date())">Now</Button>
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="note">Notes</Label>
                                <Textarea id="note" name="note" placeholder="event note" />

                                <InputError :message="errors.name" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="submit" tabindex="5" :disabled="processing">
                                    <LoaderCircle v-if="processing" class="w-4 h-4 animate-spin" />
                                    Add child event
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
