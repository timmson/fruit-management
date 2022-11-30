import React, {useEffect, useState} from "react"
import {CORE_SERVICE} from "../constants"
import HomeTasks from "./taks"

export default function Home() {

    const [state, setState] = useState({tasks: []})

    useEffect(() => {
        fetch(CORE_SERVICE + "?section=home").then((resp) => {
            if (resp.ok) {
                resp.json().then((json) => {
                    setState({...state, tasks: json.tasks})
                })
            }
        })
    }, [])

    return (
        <>
            <div className="col-6">
                <h3>Моя активность</h3>
            </div>
            <div className="col-6">
                <HomeTasks tasks={state.tasks}/>
            </div>
        </>
    )
}