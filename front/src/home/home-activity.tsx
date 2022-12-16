import React from "react"

const dayOfWeekFields = [
	"task_spent_mon",
	"task_spent_tue",
	"task_spent_wen",
	"task_spent_th",
	"task_spent_fr"
]

type HomeActivityProps = {
	activities: any[]
}

export default function HomeActivity(props: HomeActivityProps) {
	const initialValueOfSummary = {}
	dayOfWeekFields.map((f) => initialValueOfSummary[f] = 0)

	const summary = props.activities.reduce((c, a) => {
		dayOfWeekFields.forEach((f) => {
			c[f] += parseInt(a[f], 10)
		})
		return c
	}, initialValueOfSummary
	)

	const toTable = (a: any) => dayOfWeekFields.map((f, i) => (<td key={i} className="text-center">{a[f]}</td>))

	const activities = props.activities.map((a, i) => {
		return (
			<tr key={i}>
				<td>
					<a href={"?section=task&task=" + a.task_id}>
						{a.project_name}-{a.task_id}&nbsp;{a.task_name}.{a.task_descr}
					</a>
				</td>
				<td>
					{a.task_state}
				</td>
				{toTable(a)}
			</tr>
		)
	})

	return (
		<>
			<h3>Моя активность</h3>
			<table className="basic w-100">
				<thead>
					<tr className="fw-bold">
						<th>Задача</th>
						<th>Статус</th>
						<th>ПН</th>
						<th>ВТ</th>
						<th>СР</th>
						<th>ЧТ</th>
						<th>ПТ</th>
					</tr>
				</thead>
				<tbody>
					{activities}
					<tr className="fw-bold">
						<td colSpan="2" className="text-end">
						Итого
						</td>
						{toTable(summary)}
					</tr>
				</tbody>
			</table>
		</>
	)
}