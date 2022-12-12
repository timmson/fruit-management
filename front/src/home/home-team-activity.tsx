import React, {useEffect, useState} from "react"
import {CORE_SERVICE} from "../constants"
import HomeTeamActivityItem from "./home-team-activity-item"

type HomeTeamActivityProps = {
    /* teamActivities: any[]*/
}
export default function HomeTeamActivity(props: HomeTeamActivityProps) {

    const [state, setState] = useState({teamActivities: []})

    useEffect(() => {
        fetch(CORE_SERVICE + "?section=home&mode=async").then((resp) => {
            if (resp.ok) {
                resp.json().then((json) => {
                    setState({
                            ...state,
                            teamActivities: json.activity
                        }
                    )
                })
            }
        })

    }, [])


    const teamActivities = state.teamActivities.map((teamActivity, i) => <HomeTeamActivityItem key={i} teamActivity={teamActivity}/>)

    return (
        <>
            <h3>Активность команды</h3>
            <table className="basic">
                <tbody>
                {teamActivities.length > 0 ? teamActivities : <tr>
                    <td className="text-start">Пока здесь пусто;(</td>
                </tr>}
                </tbody>
            </table>
        </>
    )
}