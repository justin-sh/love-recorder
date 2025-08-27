<script setup lang="ts">
import {
    ComboboxAnchor,
    ComboboxContent,
    ComboboxEmpty,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxRoot,
    ComboboxRootEmits,
    ComboboxRootProps,
    ComboboxTrigger,
    ComboboxViewport,
    useForwardPropsEmits
} from 'reka-ui';

import { Check, ChevronDown } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<ComboboxRootProps & { options: Array< { key:string, value:object }>, placeholder?:string }>()
const emits = defineEmits<ComboboxRootEmits>()

const delegatedProps = computed(() => {
    const { options: _, placeholder:_1, ...delegated } = props;

    return delegated;
});

const forward = useForwardPropsEmits(delegatedProps, emits)

</script>

<template>
    <ComboboxRoot
        class="relative"
        v-bind="forward"
    >
        <ComboboxAnchor class="min-w-[160px] inline-flex items-center justify-between rounded-lg border px-[15px] text-base leading-none h-[35px] gap-[5px] bg-white text-grass11 hover:bg-stone-50 shadow-sm focus:shadow-[0_0_0_2px] focus:shadow-black data-[placeholder]:text-grass9 outline-none">
            <ComboboxInput
                class="!bg-transparent outline-none text-grass11 h-full selection:bg-grass5 placeholder-stone-400"
                :placeholder="props.placeholder"
                :display-value="(v) => v?.value"
            />
            <ComboboxTrigger>
                <ChevronDown />
            </ComboboxTrigger>
        </ComboboxAnchor>

        <ComboboxContent class="absolute z-10 w-full mt-1 min-w-[160px] bg-white overflow-hidden rounded-lg shadow-sm border will-change-[opacity,transform] data-[side=top]:animate-slideDownAndFade data-[side=right]:animate-slideLeftAndFade data-[side=bottom]:animate-slideUpAndFade data-[side=left]:animate-slideRightAndFade">
            <ComboboxViewport class="p-[5px]">
                <ComboboxEmpty class="text-mauve8 text-base font-medium text-center py-2" />

<!--                <template-->
<!--                    v-for="(group, index) in options"-->
<!--                    :key="group.name"-->
<!--                >-->
<!--                    <ComboboxGroup>-->
<!--                        <ComboboxSeparator-->
<!--                            v-if="index !== 0"-->
<!--                            class="h-[1px] bg-grass6 m-[5px]"-->
<!--                        />-->

<!--                        <ComboboxLabel class="px-[25px] text-xs leading-[25px] text-mauve11">-->
<!--                            {{ group.name }}-->
<!--                        </ComboboxLabel>-->

                        <ComboboxItem
                            v-for="option in props.options"
                            :key="option.key"
                            :value="option"
                            class="text-base leading-none text-grass11 rounded-[3px] flex items-center h-[25px] pr-[35px] pl-[25px] relative select-none data-[disabled]:text-mauve8 data-[disabled]:pointer-events-none data-[highlighted]:outline-none data-[highlighted]:bg-grass9 data-[highlighted]:text-grass1"
                        >
                            <ComboboxItemIndicator
                                class="absolute left-0 w-[25px] inline-flex items-center justify-center"
                            >
                                <Check/>
                            </ComboboxItemIndicator>
                            <span>
                {{ option.value }}
              </span>
                        </ComboboxItem>
<!--                    </ComboboxGroup>-->
<!--                </template>-->
            </ComboboxViewport>
        </ComboboxContent>
    </ComboboxRoot>
</template>
