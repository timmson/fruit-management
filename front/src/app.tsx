import React, {useEffect, useReducer} from "react"
import Context from "./context"
import Reducer from "./reducer"
import Login from "./login"
import {AUTH_SERVICE, CORE_SERVICE} from "./constants"
import Layout from "./layout"
import {Actions, State} from "./types"

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
            {(state.isLoggedOn) ? <Layout/> : <Login/>}
        </Context.Provider>
    )

}
