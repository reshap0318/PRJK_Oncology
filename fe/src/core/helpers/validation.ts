const defaultErrorMessages = {
    required: 'required',
    moreThanStartDate: 'Oops! Start date must be earlier than end date',
    moreThanStartTime: 'Oops! End time cannot be below start time',
    email: 'data must be format valid email'
}

export function getErrorMessages(vuelidateState: any, customErrorMessages = {}) {
    try {
        const result: string[] = []
        if (!vuelidateState.$dirty) {
            return result
        }

        const errorMessages = { ...defaultErrorMessages, ...customErrorMessages }

        const error = vuelidateState.$errors[0]

        if (error) {
            const msg = errorMessages[error.$validator] ?? error.$message
            result.push(msg)
        }
        return result
    } catch (error) {
        return []
    }
}

export function isError(vuelidateState: any): boolean {
    return getErrorMessages(vuelidateState).length > 0
}
