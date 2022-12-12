import "bootstrap"
import "./index.scss"

import React from "react"
import {createRoot} from "react-dom/client"

import App from "./app"
import {IMG_PATH, TITLE, VERSION} from "./constants"

const favicon = document.createElement("link")
favicon.rel = "shortcut icon"
favicon.href = `${IMG_PATH}/admin_logo.ico`
document.head.appendChild(favicon)

const searchParams = new URL(window.location.href).searchParams

createRoot(document.getElementById("app")).render(<App query={searchParams}/>)
