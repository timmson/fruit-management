export type State = {
    logonState: LogonState
    user?: {
        fio: string,
        samaccountname: string
    }
    section?: string
}

export enum LogonState {
    UNDEFINED = 0,
    IS_LOGGED_OUT = 1,
    IS_LOGGED_IN = 2
}

export enum ActionName {
    LOG_IN = 1,
    LOG_OUT = 2
}

export type SectionEntity = {
    name: string
    description: string
}