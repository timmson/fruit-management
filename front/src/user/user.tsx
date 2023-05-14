import React from "react"
import HomeTask from "../home/home-task"
import HomeActivity from "../home/home-activity"

export function User() {
	return (
		<>
			<div className="row">
				<div className="col">
					<h2>Пользователь</h2>
				</div>
			</div>
			<div className="row mt-2">
				<div className="col">
					<HomeTask tasks={[]}/>
				</div>
			</div>
			<div className="row mt-2">
				<div className="col">
					<HomeActivity activities={[]}/>
				</div>
			</div>
		</>
	)
}
