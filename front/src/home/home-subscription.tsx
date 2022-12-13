import React from "react"
import {IMG_PATH} from "../constants"

type HomeSubscriptionProps = {
    subscriptions: any[]
}

export default function HomeSubscription(props: HomeSubscriptionProps) {

	const subscriptions = props.subscriptions.map((s, i) => (
		<tr key={i}>
			<td className="text-start">
				<a href={"?section=task&task=" + s.id}>
					{s.fm_name}&nbsp;{s.fm_code}.{s.fm_descr}
				</a>
			</td>
			<td className="text-start">{s.fm_user}</td>
			<td>
				{s.fm_all_hour * 100.0 / s.fm_plan_hour}
			</td>
			<td>
				<img src={IMG_PATH + "/state_" + s.fm_state_name + ".gif"} alt={s.fm_state_name} title={s.fm_state}/>
			</td>
		</tr>
	)
	)

	return (
		<>
			<h3>Мои подписки</h3>
			<table className="basic w-100">
				<thead>
					<tr className="fw-bold">
						<td>Задача</td>
						<td>Пользователь</td>
						<td>%</td>
						<td>Статус</td>
					</tr>
				</thead>
				<tbody>
					{subscriptions}
				</tbody>
			</table>
		</>
	)
}