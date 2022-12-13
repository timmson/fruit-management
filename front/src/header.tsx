import React, {useContext} from "react"
import {AUTH_SERVICE, TITLE, VERSION} from "./constants"
import Sections from "./sections"
import Context from "./context"
import {ActionName, SectionName} from "./types"

export default function Header() {

	const [state, dispatch] = useContext(Context)

	const goHome = () => dispatch({name: ActionName.CHANGE_SECTION, data: SectionName.HOME})

	return (
		<>
			<div className="row">
				<div className="col-4 text-start">
					Вы известны как
					{"\u00A0"}
					<span className="font-italic fw-bold">
						{state.user.fio || ""}
					</span>
					{"\u00A0"}
					<a href={AUTH_SERVICE + "?logout"} className="av">
						[Выход]
					</a>
				</div>
				<div className="col-4">

				</div>
				<div className="col-4 text-end">
					<a href="https://ru.wikipedia.org">
						Информационный портал
						<sup className="text-danger">new</sup>
					</a>
				</div>
			</div>
			<div className="row">
				<div className="col-3 text-center border rounded-start pt-3" style={{minWidth: "350px", cursor: "pointer"}} onClick={() => goHome()}>
					<h2 className="mb-1">{TITLE}&nbsp;{VERSION}</h2>
					<p className="font-italic" style={{fontSize: "9pt"}}>
						&quot;Walking on water and developing software from a specification are easy if both are frozen&quot;
					</p>
				</div>
				<div className="col text-center border-top border-bottom border-end rounded-end">
					<Sections/>
				</div>
			</div>
		</>
	)
}