import ceklis from '@/assets/icons/icon_checklist_green.svg'
import silang from '@/assets/icons/icon_silang_red.svg'

type TbtnActionItem = {
    isCan: boolean
    icon: string
    color?: string
}

type TBtnAction = {
    [key: string]: TbtnActionItem
}

export function btnAction(action: TBtnAction, payload: string | number): string {
    return btnActionText(action, payload)
}

export function btnActionText(action: TBtnAction, payload: string | number): string {
    let result = ``
    Object.keys(action).forEach((key: string) => {
        const item: TbtnActionItem = action[key]
        const color: string = item.color ?? 'btn-primary'
        if (key == 'edit' && item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn btn-sm mt-1 btn-primary btn-edit" style="padding: 5px 13px">
                    edit
                </button>
            `
        } else if (key == 'delete' && item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn btn-sm mt-1 btn-danger btn-delete" style="padding: 5px 13px">
                    delete
                </button>
            `
        } else if (item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn btn-sm mt-1 ${color} btn-${key}" style="padding: 5px 13px">
                    ${key}
                </button>
            `
        }
    })
    return result
}

export function btnActionIcon(action: TBtnAction, payload: string | number): string {
    let result = ``
    Object.keys(action).forEach((key: string) => {
        const item: TbtnActionItem = action[key]
        const color: string = item.color ?? 'btn-primary'
        if (key == 'edit' && item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn btn-icon btn-active-light-primary w-30px h-30px btn-edit" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="edit" title="edit" data-bs-placement="top">
                    <i class="fa fa-edit" style="margin-right: 0px"></i>
                </button>
            `
        } else if (key == 'delete' && item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn btn-icon btn-active-light-danger w-30px h-30px btn-delete" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="delete" title="delete" data-bs-placement="top">
                    <i class="fa fa-trash" style="margin-right: 0px"></i>
                </button>
            `
        } else if (item.isCan) {
            result += `
                <button type="button" data-id="${payload}" class="btn ${color} w-30px h-30px btn-${key}">
                    <i class="fa ${item.icon}" style="margin-right: 0px"></i> &ensp;${key}
                </button>
            `
        }
    })
    return result
}

export function active(data: boolean): string {
    let img = silang
    if (data) img = ceklis
    return `<img src="${img}" alt="status" style="width: 20px">`
}

export function labelDetail(label: string, id: number): string {
    return `<a href="javascript:void(0)" data-id="${id}" class="btn-detail">${label}</a>`
}
