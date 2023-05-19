import React, {useEffect, useState} from "react"
import {CORE_SERVICE, IMG_PATH} from "../constants"

export default function Plan() {

	const initialState = {
		relId: 0,
		releases: [],
		month: [],
		plans: [],
		tasks: []
	}

	const [state, setState] = useState(initialState)

	useEffect(() => {
		fetch(CORE_SERVICE + "?section=plan").then((resp) => {
			if (resp.ok) {
				resp.json().then((json) => {
					setState({
						...state,
						relId: json.relid,
						releases: json.release,
						month: json.monthcal,
						plans: json.plantasks,
						tasks: json.structtasks
					}
					)
				})
			}
		})

	}, [])

	const releases = state.releases.map((r, i) => (
		<a key={i} id="{r.id}" href={"?section=plan&release=" + r.id} className={"rellink " + (r.id === state.relId ? "fw-bold" : "")}>
			{r.fm_code}.{r.fm_descr}
		</a>
	)
	)

	const getColor = (plan, day) => {
		if (day.day >= plan.fm_plan_start && day.day <= plan.fm_plan_end) {
			switch (plan.fm_priotiy) {
			case 2:
				return "#8f8"
			case 3:
				return "#dfd"
			default:
				return "#0f0"
			}
		}
	}

	const month = state.month.map((d, i) => (
		<th key={i} style={d.isweekend ? {color: "#f66"} : {}}>
			{d.day}
		</th>
	))

	const plans = state.plans.map((p, i) => (
		<tr key={i}>
			<td>
				<a href={"?section=user&user=" + p.fm_user}>{p.fm_user}</a>
			</td>
			<td>
				{Math.floor((p.fm_plan_hour - p.fm_all_hour) / 8)}д
				&nbsp;
				{Math.floor((p.fm_plan_hour - p.fm_all_hour) % 8)}ч
			</td>
			{state.month.map((d, i) => (
				<td key={i} style={{backgroundColor: getColor(p, d)}}>
					&nbsp;
				</td>
			))}
		</tr>
	))

	const tasks = state.tasks.map((t) => {

		const parentTask = (
			<td className="text-start align-text-top" rowSpan={t.child.length}>
				<a href={"?section=task&task=" + t.id} style={{fontSize: "8pt"}}>
					{t.fm_name}&nbsp;{t.fm_code}.{t.fm_descr}
				</a>
			</td>
		)

		return t.child.map((c, i) => {

			return (
				<tr key={i}>
					{i === 0 ? parentTask : ""}
					<td className="text-start">
						<a href={"?section=task&task=" + c.id} style={{fontSize: "8pt"}}>
							{c.fm_name}&nbsp;{c.fm_code}.{c.fm_descr}
						</a>
					</td>
					<td>
						<a href={"?section=user&user=" + c.fm_user}>{c.fm_user}</a>
					</td>
					<td>
						{c.fm_all_hour * 100.0 / c.fm_plan_hour}
					</td>
					<td>
						<img src={IMG_PATH + "/priority_" + c.fm_priority_name + ".gif"} alt={c.fm_priority_name} title={c.fm_priority_name}/>
					</td>
					<td>
						<img src={IMG_PATH + "/state_" + c.fm_state_name + ".gif"} alt={c.fm_state_name} title={c.fm_state}/>
					</td>
				</tr>
			)
		}
		)
	}
	)

	return (
		<>
			Релизы: {releases}
			<br/>

			<div style={{float: "right"}}>
				<a href="?section=agile">Гибкое&nbsp;планирование</a>
			</div>
			<br/>

			<h3>Календарное планирование</h3>
			<table className="basic w-100">
				<thead>
					<tr>
						<th rowSpan="2">Пользователь</th>
						<th rowSpan="2">Длина</th>
						<th colSpan={state.month.length}>
							{new Date().getMonth() + 1}
						</th>
					</tr>
					<tr>
						{month}
					</tr>
				</thead>
				<tbody>
					{plans}
				</tbody>
			</table>
			<br/>

			<h3>Структура</h3>
			<table className="basic w-100">
				<thead>
					<tr>
						<th style={{width: "15%"}}>Запрос</th>
						<th style={{width: "40%"}}>Задача</th>
						<th>Исполнитель</th>
						<th>%</th>
						<th>Приоритет</th>
						<th>Статус</th>
					</tr>
				</thead>
				<tbody>
					{tasks}
				</tbody>
			</table>
		</>
	)
}
