export type State = {
    isLoggedOn: boolean
}

export enum Actions {
    LOGIN = 1,
    LOGOUT = 2
}

export type SectionEntity = {
    name: string
    description: string
}