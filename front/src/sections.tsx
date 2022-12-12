import React from "react"
import Section from "./section"
import {SECTIONS} from "./types"

export default function Sections() {
	const sections = SECTIONS.map((entity, i) => <Section key={i} value={entity}/>)

	return (
		<table className="plain">
			<tbody>
				<tr>
					{sections}
				</tr>
			</tbody>
		</table>
	)
}