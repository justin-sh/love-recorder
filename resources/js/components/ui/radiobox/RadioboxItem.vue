<script setup lang="ts">
import { computed, type HTMLAttributes, ref } from 'vue';
import { cn } from '@/lib/utils';
import type { RadioGroupItemProps } from 'reka-ui';
import { RadioGroupItem, RadioGroupIndicator, useForwardPropsEmits } from 'reka-ui';

const props = defineProps<RadioGroupItemProps & { class?: HTMLAttributes['class'], label: string}>();

const delegatedProps = computed(() => {
    const { class: _, label, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps);
</script>

<template>
    <div :class="cn('flex items-center', props.class)">
        <RadioGroupItem
            v-bind="forwarded"
            class="bg-white w-[1.125rem] h-[1.125rem] rounded-full border data-[active=true]:border-stone-700 data-[active=true]:bg-stone-700 dark:data-[active=true]:bg-white shadow-sm focus:shadow-[0_0_0_2px] focus:shadow-stone-700 outline-none cursor-default"
        >
            <RadioGroupIndicator
                class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-2 after:h-2 after:rounded-[50%] after:bg-black dark:after:bg-stone-700"
            >
            </RadioGroupIndicator>
        </RadioGroupItem>
        <label
            :for="props.id"
            class="text-stone-700 dark:text-white text-sm leading-none pl-[10px]"
        >
            {{ props.label }}
        </label>
    </div>
</template>

<style scoped>

</style>
