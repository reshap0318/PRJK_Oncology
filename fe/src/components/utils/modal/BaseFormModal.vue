<template>
    <BaseModal :modalId="modalId" ref="modal" :width="width">
        <template #title><slot name="title"></slot></template>
        <form class="form" @submit.prevent="emit('onSubmit')">
            <slot></slot>
            <div class="text-center pt-5">
                <button type="button" class="btn btn-light me-3" @click="hide">Discard</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import { ref } from 'vue'

const modal = ref()

const emit = defineEmits(['onSubmit'])

defineProps({
    modalId: {
        type: String,
        default: 'default'
    },
    width: {
        type: String,
        default: 'mw-800px'
    }
})

function show() {
    modal.value.show()
}

function hide() {
    modal.value.hide()
}

defineExpose({
    show,
    hide
})
</script>

<style>
.mw-1100px {
    max-width: 1100px;
}

.mw-1200px {
    max-width: 1200px;
}

.mw-1300px {
    max-width: 1300px;
}

.mw-1400px {
    max-width: 1400px;
}

.mw-1500px {
    max-width: 1500px;
}
</style>
