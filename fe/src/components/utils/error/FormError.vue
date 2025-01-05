<template>
    <div class="fv-plugins-message-container" v-if="isError">
        <div class="fv-help-block">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getErrorMessages } from '@/core/helpers/validation'
import { useAuthStore } from '@/stores/auth'
import { computed } from 'vue'

const authStore = useAuthStore()
const prop = defineProps({
    err: {
        type: Object
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
    if (prop.err && getErrorMessages(prop.err).length != 0)
        return getErrorMessages(prop.err, prop.customMessage).join(', ')
    else if (prop.name && authStore.formError[prop.name]) return authStore.formError[prop.name]
    return ''
})

const isError = computed((): boolean => errorMessage.value != '')
</script>
