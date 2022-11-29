import "bootstrap"
import "./index.scss"

import React from "react"
import {createRoot} from "react-dom/client"
import Login from "./login"

import {AUTH_SERVICE, CORE_SERVICE, IMG_PATH, TITLE} from "./constants"


const setPageDefaults = () => {
    document.title = TITLE

    const favicon = document.createElement("link")
    favicon.rel = "shortcut icon"
    favicon.href = `${IMG_PATH}/admin_logo.ico`
    document.head.appendChild(favicon)
}

const render = async () => {
    try {
        const resp = await fetch(AUTH_SERVICE)
        if (resp.ok) {
            window.location.href = CORE_SERVICE
        } else {
            createRoot(document.getElementById("app")).render(<Login/>)
            setPageDefaults()
        }
    } catch (error) {
        console.error(error)
    }
}

render()


