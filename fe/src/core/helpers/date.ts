export function convertDateToYMD(dateStr: string): string | null {
    try {
        if (typeof dateStr === 'undefined') null
        const [day, month, year] = dateStr.split('-')
        return `${year}-${month}-${day}`
    } catch (error) {
        return null
    }
}
