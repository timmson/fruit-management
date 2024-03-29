import React from "react"
import {IMG_PATH} from "../constants"

type HomeTaskProps = {
    tasks: any[]
}

export default function HomeTask(props: HomeTaskProps) {

	const tasks = props.tasks.map((t, i) => {
		return (
			<tr key={i} className="text-start">
				<td>
					<a href={"?section=task&task=" + t.id}>
						{t.fm_name}&nbsp;{t.fm_code}.{t.fm_descr}
					</a>
				</td>
				<td>{t.fm_last_comment}</td>
				<td>
					{t.fm_all_hour * 100.0 / t.fm_plan_hour}
				</td>
				<td>
					<img src={IMG_PATH + "/priority_" + t.fm_priority_name + ".gif"} alt={t.fm_priority_name}/>
				</td>
				<td>
					<img src={IMG_PATH + "/state_" + t.fm_state_name + ".gif"} alt={t.fm_state_name}/>
				</td>
			</tr>
		)
	})

	return (
		<>
			<h3>Мои задачи</h3>
			<table className="basic w-100">
				<thead>
					<tr className="fw-bold">
						<td>Задача</td>
						<td>Состояние</td>
						<td>%</td>
						<td>Приоритет</td>
						<td>Статус</td>
					</tr>
				</thead>
				<tbody>
					{tasks}
				</tbody>
			</table>
		</>
	)
}