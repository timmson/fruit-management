import React, {useContext} from "react"
import Header from "./header"
import Home from "./home/home"
import {COPYRIGHT} from "./constants"
import Context from "./context"
import {SectionName} from "./types"
import Project from "./project/project"

export default function Layout() {

	const [state, _] = useContext(Context)

	let page = <Home/>

	switch (state.section.name) {
	case SectionName.PROJECT:
		page = <Project/>
		break
	}

	return (
		<>
			<div className="container mt-4">
				<Header/>
				<div className="row border-top border-bottom rounded p-5 mt-2"
					style={{borderRight: "dashed 1px #ccc", borderLeft: "dashed 1px #ccc"}}>
					<div className="col">
						{page}
					</div>
				</div>
				<div className="row mt-2">
					<div className="col text-end text-dark" style={{fontSize: "8pt"}}>
                        loadTimes&nbsp;&copy;{COPYRIGHT}
					</div>
				</div>
			</div>
		</>
	)
}