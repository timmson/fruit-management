import React, {useEffect, useState} from "react"
import {CORE_SERVICE, IMG_PATH, TITLE, VERSION} from "./constants"

function Sections() {

    const sections = [
        {"name": "home", "description": "Главная"},
        {"name": "task", "description": "Проекты"},
        {"name": "agile", "description": "Agile"},
        {"name": "plan", "description": "Планирование"},
        {"name": "user", "description": "Пользователи"},
        {"name": "export", "description": "Выгрузка"}
    ]

    const sectionsMap = sections.map((section, i) => (
            <div key={i} className={'col pt-2 text-center border-top border-bottom ' + (i == sections.length - 1 ? 'rounded-end border-end' : "")}>
                <a className="av" href={'?section=' + section.name}>
                    <img src={IMG_PATH + '/admin_' + section.name + '.gif'} alt={section.name}/>
                    <br/>
                    {section.description}
                </a>
            </div>
        )
    )

    return (
        <>
            <div className="row">
                <div className="col-3 text-center border rounded-start">
                    <h2 className="mb-0">{TITLE}&nbsp;{VERSION}</h2>
                    <p style={{fontSize: "9pt", fontStyle: "italic"}}>
                        &quot;Walking on water and developing software from a specification are easy if both are frozen&quot;
                    </p>
                </div>
                {sectionsMap}
            </div>
        </>
    )
}

export default function Home() {

    const [state, setState] = useState({page: ""})

    useEffect(() => {
        fetch(CORE_SERVICE + "?section=home").then((resp) => {
            if (resp.ok) {
                resp.text().then((text) => {
                    //setState({...state, page: text})
                })
            }
        })
    }, [])

    return (
        <>
            <div className="container">
                <Sections/>
                <div className="row border p-5 mt-2" style={{borderRight: "dashed 1px", borderLeft: "dashed"}}>
                    <div id="pagecontainer" className="col" dangerouslySetInnerHTML={{__html: state.page}}>

                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col text-end text-dark" style={{fontSize: "8pt"}}>
                        loadTimes&nbsp;&copy;const.copyright&nbsp;const.developedBy
                    </div>
                </div>
            </div>
        </>
    )
}