import {ActionName, LogonState, State} from "./types"

type Action = {
    name: ActionName
    data?: any
}

export default function Reducer(state: State, action: Action) {

    switch (action.name) {
        case ActionName.LOG_IN:
            return {
                ...state,
                user: action.data,
                logonState: LogonState.IS_LOGGED_IN
            }

        case ActionName.LOG_OUT:
            return {
                ...state,
                user: undefined,
                logonState: LogonState.IS_LOGGED_OUT
            }

        default:
            return {...state}
    }
}