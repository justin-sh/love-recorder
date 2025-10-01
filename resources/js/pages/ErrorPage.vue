<script setup>
import { computed } from 'vue';

const props = defineProps({ status: Number });

const title = computed(() => {
    return {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Page Not Found',
        403: '403: Forbidden'
    }[props.status];
});

const description = computed(() => {
    return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you are forbidden from accessing this page.'
    }[props.status];
});
</script>

<template>
    <div class="flex items-center min-h-screen min-w-full justify-center">

        <div class="flex flex-col items-center">
            <div class="font-bold text-2xl">{{ title }}</div>
            <div class="font-medium text-xl text-gray-600 mt-4 dark:text-gray-400">{{ description }}</div>
            <div class="font-medium mt-6 text-xl ">
                <a href="/" class="p-4 bg-gray-600 rounded-xl text-white"> &lt;- Back to Home</a>
            </div>
        </div>
    </div>
</template>
