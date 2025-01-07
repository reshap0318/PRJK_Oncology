<template>
    <BaseModal modalId="maintenance" ref="modal" :width="width">
        <div class="d-flex flex-column align-items-center" style="margin-top: 95px">
            <img :src="getAssetPath('images/loading/v1.webp')" alt="" />
            <h1 style="font-size: 55px" class="text-uppercase">Under Maintenance</h1>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import { getAssetPath } from '@/core/helpers/assets'
import { ref } from 'vue'

const modal = ref()

defineProps({
    width: {
        type: String,
        default: 'modal-fullscreen'
    }
})

function show() {
    modal.value.show()
}

defineExpose({
    show
})
</script>
