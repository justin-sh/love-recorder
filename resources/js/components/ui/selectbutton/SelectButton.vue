<script setup lang="ts">
import { SelectButton, SelectButtonEmits, SelectButtonProps } from 'primevue';
import { useForwardPropsEmits } from 'reka-ui';
import { computed } from 'vue';

const props = defineProps<SelectButtonProps>();

const delegatedProps = computed(() => {
    // const { modelValue: _, ...delegated } = props;
    const {...delegated } = props;

    return delegated;
});
const forward = useForwardPropsEmits(delegatedProps);
</script>

<template>
    <SelectButton v-bind="forward" @update:model-value="value => $emit('update:modelValue', value)"/>
</template>
