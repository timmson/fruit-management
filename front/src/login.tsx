import React, {useContext, useState} from "react"
import {AUTH_SERVICE, IMG_PATH, TITLE} from "./constants"
import Context from "./context"
import {ActionName} from "./types"

type LoginData = {
    login: string,
    pass: string,
    message?: string
}

export default function Login() {

    const defaultState: LoginData = {login: "", pass: ""}
    const [state, setState] = useState(defaultState)
    const [_, dispatch] = useContext(Context)

    const change = (element) => {
        state[element.name] = element.value
        setState({...state})
    }

    const submit = async (event) => {
        event.preventDefault()
        try {
            const formData = new FormData()
            formData.append("login", state.login)
            formData.append("pass", state.pass)

            const response = await fetch(AUTH_SERVICE, {method: "POST", body: formData})
            if (response.ok) {
                const user = await response.json()
                dispatch({name: ActionName.LOG_IN, data: user})
            } else {
                change({"name": "message", "value": "Логин и/или пароль не верны"})
            }

        } catch (error) {
            change({"name": "message", "value": "Произошла ошибка ;("})
            console.log(error)
        }
    }

    return (
        <div className="container">
            <div className="row">
                <div className="col text-center">
                    <img src={IMG_PATH + "/logo.gif"} alt={TITLE}/>
                </div>
            </div>
            <div className="row mt-4">
                <div className="col text-center">
                    <h1>{TITLE}</h1>
                    <p style={{color: "#FF0000"}}>{state.message}</p>
                </div>
            </div>
            <form id="loginForm" onSubmit={(event) => submit(event)}>
                <div className="row mt-4">
                    <div className="col-5 text-end">
                        <label htmlFor="login" className="col-form-label">Логин:</label>
                    </div>
                    <div className="col-2 text-start">
                        <input id="login" name="login" type="text" value={state.login} placeholder="fruit" className="form-control"
                               onChange={(event) => change(event.target)}/>
                    </div>
                    <div className="col-5 text-end">
                        &nbsp;
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-5 text-end">
                        <label htmlFor="pass" className="col-form-label">Пароль:</label>
                    </div>
                    <div className="col-2 text-start">
                        <input id="pass" name="pass" type="password" value={state.pass} placeholder="*****" className="form-control"
                               onChange={(event) => change(event.target)}/>
                    </div>
                    <div className="col-5 text-end">
                        &nbsp;
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col text-center">
                        <input id="sub" name="sub" value="Войти" className="btn btn-primary corp" type="submit"/>
                    </div>
                </div>
            </form>
            <div className="row mt-4">
                <div className="col-3">
                    &nbsp;
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;xhtml" src={IMG_PATH + "/xhtml.png"}/>
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;css" src={IMG_PATH + "/css.png"}/>
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;php" src={IMG_PATH + "/php.png"}/>
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;smarty" src={IMG_PATH + "/smarty.png"}/>
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;ajax" src={IMG_PATH + "/ajax.png"}/>
                </div>
                <div className="col-1">
                    <img alt="powered&nbsp;by&nbsp;natali" src={IMG_PATH + "/natali.png"}/>
                </div>
                <div className="col-3">
                    &nbsp;
                </div>
            </div>
        </div>
    )
}