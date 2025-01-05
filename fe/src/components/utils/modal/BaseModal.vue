<template>
    <Teleport to="body">
        <div
            class="modal fade"
            :id="`modal_${modalId}`"
            tabindex="-1"
            aria-hidden="true"
            ref="modalRef"
        >
            <div class="modal-dialog modal-dialog-centered" :class="width">
                <div class="modal-content rounded">
                    <div
                        class="modal-header justify-content-between border-0 pt-4 pb-2 bg-light-primary"
                    >
                        <h4 class="ps-2 mb-0">
                            <slot name="title"></slot>
                        </h4>
                        <div class="btn btn-sm btn-icon btn-active-color-danger" @click="hide">
                            <KTIcon icon-name="cross" icon-class="fs-1" />
                        </div>
                    </div>
                    <div class="modal-body pt-4 pb-5 px-10">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script lang="ts" setup>
import { Modal } from 'bootstrap'
import { hideModal } from '@/core/helpers/dom'
import { ref } from 'vue'

const prop = defineProps({
    modalId: {
        type: String,
        default: 'default'
    },
    width: {
        type: String,
        default: 'mw-800px'
    }
})

const modalRef = ref()

function show() {
    const modal = new Modal(document.getElementById(`modal_${prop.modalId}`) as Element)
    modal.show()
}

function hide() {
    hideModal(modalRef.value)
}

defineExpose({
    show,
    hide
})
</script>
