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
    PROJECT = "project",
	PLAN = "plan",
}

export type SectionEntity = {
    name: string,
    description: string
    show: boolean
    new_front?: boolean
}

export const SECTIONS = [
	{"name": SectionName.HOME, "description": "Главная", "show": false,  "new_front": true},
	{"name": SectionName.PROJECT, "description": "Проекты", "show": true, "new_front": true},
	{"name": "task", "description": "Задачи", "show": true},
	{"name": "agile", "description": "Agile", "show": true},
	{"name": SectionName.PLAN, "description": "Планирование", "show": true, "new_front": true},
	{"name": "user", "description": "Пользователи", "show": true},
	{"name": "export", "description": "Выгрузка", "show": true}
]
