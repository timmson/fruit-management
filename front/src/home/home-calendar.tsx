import React from "react"

type HomeCalendar = {
    month: any[]
    plans: any[]
}

export default function HomeCalendar(props: HomeCalendar) {

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

	const month = props.month.map((d, i) => (
		<th key={i} style={d.isweekend ? {color: "#f66"} : {}}>
			{d.day}
		</th>
	))

	const plans = props.plans.map((p, i) => (
		<tr key={i}>
			<td className="text-start">
				<a href={"?section=task&task=" + p.id}>
					{p.fm_name}&nbsp;{p.fm_code}.{p.fm_descr}
				</a>
			</td>
			<td>
				{Math.floor((p.fm_plan_hour - p.fm_all_hour) / 8)}д
                &nbsp;
				{Math.floor((p.fm_plan_hour - p.fm_all_hour) % 8)}ч
			</td>
			{props.month.map((d, i) => (
				<td key={i} style={{backgroundColor: getColor(p, d)}}>
                    &nbsp;
				</td>
			))}
		</tr>
	))

	return (
		<>
			<h3>Календарь</h3>
			<table className="basic w-100">
				<thead>
					<tr>
						<th rowSpan="2">Задача</th>
						<th rowSpan="2">Длина</th>
						<th colSpan={props.month.length}>
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
		</>
	)
}