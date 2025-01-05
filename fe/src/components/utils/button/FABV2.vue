<template>
    <div class="fab-container">
        <div class="fab shadow">
            <div class="fab-content">
                <span class="fa fa-gear"></span>
            </div>
        </div>
        <template v-for="item in itemWithPermission">
            <div class="sub-button shadow" :style="{ 'background-color': item.color }">
                <a
                    href="javascript:void(0)"
                    @click.prevent="
                        () => {
                            if (typeof item.callback === 'function') item.callback
                        }
                    "
                >
                    <span class="fa" :class="[item.icon]"></span>
                </a>
            </div>
        </template>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'

type TItem = {
    icon: string
    color: string
    permission?: boolean
    callback?: (payload: any) => any
}
const prop = defineProps({
    items: {
        type: Array<TItem>
    }
})

const itemWithPermission = computed(() => {
    return prop.items?.filter(
        (item) => typeof item.permission === 'undefined' || item.permission == true
    )
})
</script>

<style lang="scss">
$primary: #3e97ff;
.fab-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    user-select: none;
    position: absolute;
    bottom: 30px;
    right: 30px;
    &:hover {
        height: 100%;
        .sub-button:nth-child(2) {
            transform: translateY(-40px);
            background-color: #d32f2f;
        }
        .sub-button:nth-child(3) {
            transform: translateY(-75px);
            background-color: #50cd89;
        }
        .sub-button:nth-child(4) {
            transform: translateY(-110px);
            background-color: #ffc700;
        }
        .sub-button:nth-child(5) {
            transform: translateY(-145px);
            background-color: #5014d0;
        }
        .sub-button:nth-child(6) {
            transform: translateY(-180px);
            background-color: #d32f2f;
        }
    }
    .fab {
        position: relative;
        height: 44px;
        width: 44px;
        background-color: $primary;
        border-radius: 50%;
        z-index: 2;
        &::before {
            content: ' ';
            position: absolute;
            bottom: 0;
            right: 0;
            height: 20px;
            width: 20px;
            background-color: inherit;
            border-radius: 0 0 10px 0;
            z-index: -1;
        }
        .fab-content {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            border-radius: 50%;
            .fa {
                color: white;
                font-size: 23px;
            }
        }
    }
    .sub-button {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        bottom: 10px;
        right: 7px;
        height: 30px;
        width: 30px;
        background-color: $primary;
        border-radius: 50%;
        transition: all 0.3s ease;
        &:hover {
            cursor: pointer;
        }
        .fa {
            color: white;
            padding-top: 4px;
        }
    }
}
</style>
