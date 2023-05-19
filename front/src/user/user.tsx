import React, {useContext, useEffect, useState} from "react"
import HomeTask from "../home/home-task"
import HomeActivity from "../home/home-activity"
import {CORE_SERVICE} from "../constants"
import Context from "../context"

export default function User() {

	const [globalState] = useContext(Context)

	const [state, setState] = useState(
		{
			user: globalState.user.samaccountname,
			tasks: [],
			activities: []
		}
	)

	useEffect(() => {
		update().then()
	}, [])

	const update = async () => {
		try {
			const resp = await fetch(CORE_SERVICE + `?section=user&user=${state.user}`)
			if (resp.ok) {
				const json = await resp.json()
				setState({
					...state,
					tasks: json.tasks,
					activities: json.timesheet,
				}
				)
			}
		} catch (e) {
			console.error(e)
		}
	}

	const change = (value: string) => {
		//add autocomplete this callback to ?section=user&mode=async&user=%user%
		setState({...state, user: value})
	}

	return (
		<>
			<div className="row">
				<div className="col">
					<h3>
                        Пользователь
					</h3>
				</div>
			</div>
			<div className="row">
				<div className="col">
					<input type="text" name="user" value={state.user} onChange={(e) => change(e.target.value)} onBlur={() => update()}/>
				</div>
			</div>
			<div className="row mt-3">
				<div className="col">
					<HomeTask tasks={state.tasks}/>
				</div>
			</div>
			<div className="row mt-3">
				<div className="col">
					<HomeActivity activities={state.activities}/>
				</div>
			</div>
		</>
	)
}
