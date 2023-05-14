import {Action, ActionName, LogonState, SECTIONS, State} from "./types"

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

        case ActionName.CHANGE_SECTION:
            return {
                ...state,
                section: SECTIONS.filter((s) => s.name === action.data)[0]
            }
    }
}