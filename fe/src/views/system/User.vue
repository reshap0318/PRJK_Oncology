<template>
    <div class="card card-border-outline mb-5 mb-xl-8">
        <div class="d-flex align-items-center justify-content-end mx-12 mt-5">
            <div class="m-0">
                <!--begin::Menu-->
                <button
                    type="button"
                    class="btn btn-sm btn-flex btn-secondary fw-bold show menu-dropdown me-n3"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end"
                    data-kt-menu-flip="top-end"
                >
                    <KTIcon icon-name="filter" icon-class="fs-3 text-muted me-2" />
                    Filter
                </button>

                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semobold py-4 w-300px fs-6"
                    data-kt-menu="true"
                >
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                    </div>

                    <div class="separator border-gray-200"></div>

                    <div class="px-7 py-5">
                        <div class="mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Roles:</label>
                            <Multiselect
                                class="multiselect-form-control"
                                placeholder="Select roles"
                                mode="single"
                                v-model="filterTable.role"
                                :options="selectStore.roles"
                                :clear-on-selected="false"
                            />
                        </div>

                        <div class="mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Search:</label>
                            <input
                                class="form-control"
                                type="search"
                                autocomplete="off"
                                placeholder="search"
                                v-model="filterTable.search"
                            />
                        </div>

                        <div class="d-flex justify-content-end">
                            <button
                                type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true"
                                @click="resetFilter"
                            >
                                Reset
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true"
                                @click="applyFilter"
                            >
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
        </div>
        <div class="card-body pt-2 hide-search-bar">
            <DataTable
                ref="table"
                :url="userStore.datatableLink"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB @click="formModal.show()" v-if="StrgService.hasPermission('user.create')" />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import Swal from 'sweetalert2'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import Multiselect from '@vueform/multiselect'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/user/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { useSelectStore } from '@/stores/global/select'
import { useUserStore } from '@/stores/system/user'
import { btnAction } from '@/core/helpers/datatable'
import { ref } from 'vue'

const userStore = useUserStore()
const selectStore = useSelectStore()
const table = ref()
const formModal = ref()

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        name: 'users.id',
        className: 'text-center w-10',
        title: 'ID'
    },
    {
        data: 'name',
        name: 'users.name',
        title: 'Name',
        className: 'min-w-300px',
        render(data: string, type, row: any, meta) {
            return `
                <div class="d-flex align-items-center">
                    <div>
                        <img src="${row.avatar_url}" alt="avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                    </div>
                    <div class="d-flex flex-column" style="margin-left: 10px">
                        <div style="font-size: 18px;">${data}</div>
                        <span style="font-size: 12px">${row.email} - ${row.username}</span>
                    </div>
                </div>
            `
        }
    },
    {
        data: 'no_telp',
        name: 'users.no_telp',
        title: 'No Telp',
        className: 'text-start min-w-150px',
        defaultContent: '-'
    },
    {
        data: 'role_names',
        name: 'r.id',
        title: 'Role',
        render(data: string) {
            let result = ``
            const chunk = 3
            const datas = data.split(',')
            datas.slice(0, chunk).forEach((d: string) => {
                result += ` <span class="badge badge-info my-1" style="color:white; padding: 4px 8px">${d}</span> `
            })

            if (datas.length >= chunk) {
                result += ` <span class="badge badge-info my-1" style="color:white; padding: 4px 8px">+${
                    datas.length - chunk
                } More</span> `
            }
            return result
        }
    },
    {
        data: 'last_login',
        name: 'users.last_login',
        title: 'Last Login',
        className: 'min-w-200px'
    },
    {
        data: 'status',
        name: 'users.is_active',
        title: 'Status',
        render(data) {
            if (data == 'active')
                return `<span class="badge badge-success my-2" style="padding: 4px 8px">${data}</span>`
            return `<span class="badge badge-danger my-2" style="padding: 4px 8px">${data}</span>`
        }
    },
    {
        data: 'action',
        title: '',
        orderable: false,
        searchable: false,
        render(data: any, type, row: any, meta) {
            return btnAction(data, row.id)
        }
    },
    {
        data: 'username',
        name: 'users.username',
        visible: false
    },
    {
        data: 'email',
        name: 'users.email',
        visible: false
    }
])
const options = ref<Config>({
    order: [[0, 'asc']],
    lengthChange: false,
    searching: true
})
const filterTable = ref({
    search: '',
    role: 0
})

function handleBtnEdit(row: any): void {
    const payload = {
        id: row.id,
        name: row.name,
        email: row.email,
        username: row.username,
        no_telp: row.no_telp,
        password: null,
        confirm_password: null,
        alamat: row.alamat,
        avatar: null,
        is_active: row.status == 'active',
        roles: row.role_ids.split(','),
        avatar_url: row.avatar_url
    }
    formModal.value.show(payload)
}

function handleBtnDelete(id: number): void {
    userStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    let result = new Promise((resolve) => resolve({ message: 'Success' }))
    if (data.editId == 0) {
        result = userStore.create(data.form)
    } else {
        result = userStore.update(data.editId, data.form)
    }
    result.then((res: any) => {
        Swal.fire({
            title: 'Success!',
            text: res.message,
            icon: 'success'
        }).then(() => {
            formModal.value.hide()
            table.value.reload()
        })
    })
}

function applyFilter(): void {
    const dt = table.value.getDT()
    if (filterTable.value.role != 0) dt.column(3).search(filterTable.value.role, true)
    if (filterTable.value.search != '') dt.search(filterTable.value.search)
    dt.table().draw()
}

function resetFilter(): void {
    filterTable.value.role = 0
    filterTable.value.search = ''
    const dt = table.value.getDT()
    dt.search('').columns().search('').draw()
}
</script>

<style>
.hide-search-bar .dt-search {
    visibility: hidden;
    display: none;
}
</style>
