import React from "react"
import Header from "./header"
import Home from "./home/home";

export default function Layout() {

    const page = <Home/>

    return (
        <>
            <div className="container">
                <Header/>
                <div className="row border-top border-bottom rounded p-5 mt-2"
                     style={{borderRight: "dashed 1px #ccc", borderLeft: "dashed 1px #ccc"}}>
                    <div className="col">
                        {page}
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