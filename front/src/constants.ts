const currentDate = new Date()
const originYear = 2007
const currentYear = currentDate.getFullYear()
const currentMonth = currentDate.getMonth() + 1

export const TITLE = "Fruit Management"
export const AUTHOR = "timmson"
export const VERSION = `${currentYear-originYear}.${currentMonth}`
export const COPYRIGHT = `${originYear}-${currentYear} ${AUTHOR}`

export const IMG_PATH = "img"

export const CORE_SERVICE = "old.php"
export const AUTH_SERVICE = "auth.php"