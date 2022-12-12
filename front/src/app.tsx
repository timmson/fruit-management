import React, {useEffect, useReducer} from "react"

import Context from "./context"
import Reducer from "./reducer"
import Login from "./login"
import Layout from "./layout"
import Loader from "./loader"

import {AUTH_SERVICE, CORE_SERVICE, TITLE, VERSION} from "./constants"
import {ActionName, LogonState, SectionName, SECTIONS, State} from "./types"

const getSection = (searchParams: URLSearchParams) => {
	const sectionName = searchParams.get("section") || SectionName.HOME
	return SECTIONS.filter((s) => s.name === sectionName)[0]
}

export default function App(props: {query: URLSearchParams}) {

	const initialState: State = {
		logonState: LogonState.UNDEFINED,
		user: undefined,
		section: getSection(props.query)
	}

	const [state, dispatch] = useReducer(Reducer, initialState)

	document.title = `${TITLE} ${VERSION} ${state.section.description}`
	props.query.set("section", state.section.name)
	window.history.replaceState({}, document.title, ".?" + props.query.toString())

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
		ret = <Context.Provider value={[state, dispatch]}><Login/></Context.Provider>
		break

	case LogonState.IS_LOGGED_IN:
		if (state.section.new_front) {
			ret = <Context.Provider value={[state, dispatch]}><Layout/></Context.Provider>
		} else {
			window.location.href = `${CORE_SERVICE}?${props.query.toString()}`
		}
		break
	}

	return ret

}
