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

export const SECTIONS = [
    {"name": "home", "description": "Главная", "new_front": true},
    {"name": "task", "description": "Проекты"},
    {"name": "agile", "description": "Agile"},
    {"name": "plan", "description": "Планирование"},
    {"name": "user", "description": "Пользователи"},
    {"name": "export", "description": "Выгрузка"}
]