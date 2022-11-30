import React from "react"
import {TITLE, VERSION} from "./constants"
import Sections from "./sections"

export default function Header() {
    const sections = [
        {"name": "home", "description": "Главная"},
        {"name": "task", "description": "Проекты"},
        {"name": "agile", "description": "Agile"},
        {"name": "plan", "description": "Планирование"},
        {"name": "user", "description": "Пользователи"},
        {"name": "export", "description": "Выгрузка"}
    ]

    return (
        <>
            <div className="row">
                <div className="col-3 text-center border rounded-start">
                    <h2 className="mb-0">{TITLE}&nbsp;{VERSION}</h2>
                    <p style={{fontSize: "9pt", fontStyle: "italic"}}>
                        &quot;Walking on water and developing software from a specification are easy if both are frozen&quot;
                    </p>
                </div>
                <Sections value={sections}/>
            </div>
        </>
    )
}