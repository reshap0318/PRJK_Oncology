<template>
    <div class="input-group input-group-lg">
        <input
            class="form-control"
            autocomplete="off"
            :tabindex="tabindex"
            :class="className"
            :type="showPassword ? 'text' : 'password'"
            :placeholder="placeholder"
            v-model="value"
        />
        <button
            type="button"
            class="btn btn-icon btn-primary"
            @click="showPassword = !showPassword"
        >
            <i class="fa fs-4" :class="[showPassword ? 'fa-eye' : 'fa-eye-slash']"></i>
        </button>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue'
const showPassword = ref<boolean>(false)
const prop = defineProps({
    modelValue: {
        type: [String, null],
        required: true
    },
    className: {
        type: String
    },
    placeholder: {
        type: String,
        default: '***********'
    },
    tabindex: {
        type: Number,
        default: 1
    }
})

const emit = defineEmits(['update:modelValue'])

const value = computed({
    get() {
        return prop.modelValue
    },
    set(newValue) {
        emit('update:modelValue', newValue)
    }
})
</script>
