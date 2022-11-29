export const TITLE = "Fruit Management"
export const VERSION = "13.11"

export const IMG_PATH = "img"

export const CORE_SERVICE = "core.php"
export const AUTH_SERVICE = "auth.php"

export type State = {
    isLoggedOn: boolean
}

export enum Actions {
    LOGIN = 1,
    LOGOUT = 2
}