<template>
    <div class="fv-plugins-message-container" v-if="isError">
        <div class="fv-help-block">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getErrorEachMessages } from '@/core/helpers/validation'
import { useAuthStore } from '@/stores/auth'
import { computed } from 'vue'

const authStore = useAuthStore()
const prop = defineProps({
    err: {
        type: Object
    },
    idx: {
        type: [Number, String],
        default: 0
    },
    code: {
        type: String,
        default: ''
    },
    name: {
        type: String,
        default: ''
    },
    customMessage: {
        type: Object,
        default: function () {
            return {}
        }
    }
})

const errorMessage = computed((): string => {
    const idx = typeof prop.idx === 'string' ? parseInt(prop.idx) : prop.idx
    const beKey = prop.name + '.' + idx + '.' + prop.code
    if (prop.err && getErrorEachMessages(prop.err, idx, prop.code).length != 0)
        return getErrorEachMessages(prop.err, idx, prop.code, prop.customMessage).join(', ')
    else if (prop.name && authStore.formError[beKey]) return authStore.formError[beKey]
    return ''
})

const isError = computed((): boolean => errorMessage.value != '')
</script>
