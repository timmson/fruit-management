import React, {useEffect, useReducer} from "react"
import Context from "./context"
import Reducer from "./reducer"
import Login from "./login"
import {Actions, AUTH_SERVICE, CORE_SERVICE, State} from "./constants"
import Home from "./home";


export default function App() {

    const initialState: State = {
        isLoggedOn: false
    }

    const [state, dispatch] = useReducer(Reducer, initialState)

    useEffect(() => {
        fetch(AUTH_SERVICE).then((resp) => {
            if (resp.ok) {
                dispatch(Actions.LOGIN)
            }
        })
    }, [])

    if (state.isLoggedOn) {
        window.location.href = CORE_SERVICE
    }

    return (
        <Context.Provider value={dispatch}>
            {(state.isLoggedOn) ? <Home/> : <Login/>}
        </Context.Provider>
    )

}
