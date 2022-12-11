import React from "react"
import {IMG_PATH} from "./constants"
import {SectionEntity} from "./types"

type SectionProps = {
    key?: number
    value: SectionEntity
}

export default function Section(props: SectionProps) {
    return (
        <td className="pt-2 text-center align-bottom" style={{width: "15%"}}>
            <a className="av" style={{fontSize: "12pt"}} href={'?section=' + props.value.name}>
                <img src={IMG_PATH + '/admin_' + props.value.name + '.gif'} alt={props.value.name}/>
                <br/>
                {props.value.description}
            </a>
        </td>
    )
}