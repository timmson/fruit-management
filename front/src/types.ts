export type State = {
    logonState: LogonState
    user?: {
        fio: string,
        samaccountname: string
    }
    section?: SectionEntity
}

export type Action = {
    name: ActionName
    data?: any
}

export enum LogonState {
    UNDEFINED = 0,
    IS_LOGGED_OUT = 1,
    IS_LOGGED_IN = 2
}

export enum ActionName {
    LOG_IN = 1,
    LOG_OUT = 2,
    CHANGE_SECTION = 3
}

export enum SectionName {
    HOME = "home",
    PROJECT = "project"
}

export type SectionEntity = {
    name: string,
    description: string
    new_front?: boolean
}

export const SECTIONS = [
	{"name": SectionName.HOME, "description": "Главная", "new_front": true},
	{"name": SectionName.PROJECT, "description": "Проекты", "new_front": true},
	{"name": "task", "description": "Задачи"},
	{"name": "agile", "description": "Agile"},
	{"name": "plan", "description": "Планирование"},
	{"name": "user", "description": "Пользователи"},
	{"name": "export", "description": "Выгрузка"}
]
