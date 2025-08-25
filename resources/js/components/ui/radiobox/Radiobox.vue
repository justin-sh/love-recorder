<script setup lang="ts">
import { computed, type HTMLAttributes, ref } from 'vue';
import { cn } from '@/lib/utils';
import type { RadioGroupRootEmits, RadioGroupRootProps } from 'reka-ui';
import { RadioGroupRoot, RadioGroupItem, RadioGroupIndicator, useForwardPropsEmits } from 'reka-ui';

const props = defineProps<RadioGroupRootProps & { class?: HTMLAttributes['class'] }>();
const emits = defineEmits<RadioGroupRootEmits>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <RadioGroupRoot
        :class="cn('inline-flex gap-2.5', props.class)"
        v-bind="forwarded">
        <slot></slot>
    </RadioGroupRoot>
</template>

<style scoped>

</style>
