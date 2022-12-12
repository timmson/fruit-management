import React, {useContext} from "react"
import {IMG_PATH} from "./constants"
import {ActionName, SectionEntity} from "./types"
import Context from "./context"

type SectionProps = {
    key?: number
    value: SectionEntity
}

export default function Section(props: SectionProps) {

	const [_, dispatch] = useContext(Context)

	const changeSection = (sectionName: string) => {
		dispatch({name: ActionName.CHANGE_SECTION, data: sectionName})
	}

	return (
		<td className="pt-2 text-center align-bottom" style={{width: "15%"}} onClick={() => changeSection(props.value.name)}>
			<p className="av">
				<img src={IMG_PATH + "/admin_" + props.value.name + ".gif"} alt={props.value.name}/>
				<br/>
				{props.value.description}
			</p>
		</td>
	)
}