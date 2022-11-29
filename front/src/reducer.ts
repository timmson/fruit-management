import {Actions, State} from "./constants"

export default function Reducer(state: State, action: Actions) {
    switch (action) {
        case Actions.LOGIN:
            return {...state, isLoggedOn: true}

        case Actions.LOGOUT:
            return {...state, isLoggedOn: false}

        default:
            return {...state}
    }
}