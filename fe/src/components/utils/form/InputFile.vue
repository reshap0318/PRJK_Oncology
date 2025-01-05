<template>
    <input
        type="file"
        ref="fileInput"
        :tabindex="tabIndex"
        class="form-control"
        @change="handleChange"
        :accept="accept.join(',')"
    />
</template>
<script lang="ts" setup>
import { defineProps, defineEmits, ref, watch } from 'vue'

const prop = defineProps({
    modelValue: {
        type: [Object, null],
        required: true
    },
    accept: {
        type: Array,
        default: []
    },
    tabIndex: {
        type: Number,
        default: -1
    }
})

const fileInput = ref()
const emits = defineEmits(['update:modelValue'])

function handleChange(event: any) {
    const selectedFile = event.target.files[0]
    emits('update:modelValue', selectedFile)
}

watch(
    () => prop.modelValue,
    (val) => {
        if (val == null) {
            fileInput.value.value = null
        }
    }
)
</script>
