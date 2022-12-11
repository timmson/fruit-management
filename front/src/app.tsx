import React, {useEffect, useReducer} from "react"
import Context from "./context"
import Reducer from "./reducer"
import Login from "./login"
import {AUTH_SERVICE, CORE_SERVICE, SECTIONS} from "./constants"
import Layout from "./layout"
import {ActionName, LogonState, State} from "./types"
import Loader from "./loader";

const searchParams = new URL(window.location.href).searchParams

const getSection = () => searchParams.get("section") || "home"

const isOldFront = (sectionName: string) =>
    SECTIONS.filter((s) =>
        (s.name === sectionName) && s.new_front).length == 0

export default function App() {

    const initialState: State = {
        logonState: LogonState.UNDEFINED,
        user: undefined,
        section: getSection()
    }

    const [state, dispatch] = useReducer(Reducer, initialState)
    const context = [state, dispatch]

    useEffect(() => {
        fetch(AUTH_SERVICE).then((resp) => {
            if (resp.ok) {
                resp.json().then((user) => {
                    dispatch({name: ActionName.LOG_IN, data: user})
                })
            } else {
                dispatch({name: ActionName.LOG_OUT})
            }
        })
    }, [])

    let ret = <Loader/>

    switch (state.logonState) {
        case LogonState.IS_LOGGED_OUT:
            ret = <Context.Provider value={context}><Login/></Context.Provider>
            break

        case LogonState.IS_LOGGED_IN:
            if (isOldFront(state.section)) {
                window.location.href = `${CORE_SERVICE}?${searchParams.toString()}`
            } else {
                ret = <Context.Provider value={context}><Layout/></Context.Provider>
            }
            break
    }

    return ret

}
