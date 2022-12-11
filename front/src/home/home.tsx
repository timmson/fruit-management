import React, {useEffect, useState} from "react"
import {CORE_SERVICE} from "../constants"

import HomeTask from "./home-task"
import HomeActivity from "./home-activity"
import HomeSubscription from "./home-subscription"
import HomeCalendar from "./home-calendar"
import HomeTeamActivity from "./home-team-activity"

export default function Home() {

    const [state, setState] = useState(
        {
            tasks: [],
            activities: [],
            subscriptions: [],
            month: [],
            plans: [],
            teamActivities: []
        }
    )

    useEffect(() => {
        fetch(CORE_SERVICE + "?section=home").then((resp) => {
            if (resp.ok) {
                resp.json().then((json) => {
                    setState({
                            ...state,
                            tasks: json.tasks,
                            activities: json.timesheet,
                            subscriptions: json.subcribe_tasks,
                            month: json.monthcal,
                            plans: json.plantasks
                        }
                    )
                })
            }
        })
    }, [])

    return (
        <>
            <div className="row">
                <div className="col-6">
                    <HomeActivity activities={state.activities}/>
                    <br/>
                    <HomeSubscription subscriptions={state.subscriptions}/>
                </div>
                <div className="col-6">
                    <HomeTask tasks={state.tasks}/>
                </div>
            </div>
            <div className="row mt-3">
                <div className="col">
                    <HomeCalendar month={state.month} plans={state.plans}/>
                </div>
            </div>
            <div className="row mt-3">
                <div className="col">
                    <HomeTeamActivity/>
                </div>
            </div>
        </>
    )
}