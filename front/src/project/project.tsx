import React, {useEffect, useState} from "react"
import {CORE_SERVICE} from "../constants"

export default function Project() {

	const [state, setState] = useState({projects: []})

	useEffect(() => {
		fetch(CORE_SERVICE + "?section=project").then((resp) => {
			if (resp.ok) {
				resp.json().then((json) => {
					setState({
						...state,
						projects: json.data
					}
					)
				})
			}
		})

	}, [])

	const projects = state.projects.map((p,i) => (
		<tr key={i}>
			<td>[{p.fm_name}]&nbsp;{p.fm_descr}<br/>
				<a href={CORE_SERVICE + "?section=task&project=" + p.id}>{p.current_tasks}&nbsp;текущих задач</a><br/>
                Всего {p.fm_spent_hours} потрачено часов
			</td>
			<td>
				<img className="topup" width="400" height="150" src={"?project=" + p.id + "&mode=async&oper=gif"} alt={p.name}/>
			</td>
		</tr>
	))

	return (
		<>
			<h2>Проекты</h2>
			<table className="basic">
				<thead>

					<tr>
						<th>Проект</th>
						<th>График</th>
					</tr>
				</thead>
				<tbody>
					{projects}
				</tbody>
			</table>

		</>
	)
}