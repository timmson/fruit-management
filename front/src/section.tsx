import React from "react"
import {IMG_PATH} from "./constants"
import {SectionEntity} from "./types"

type SectionProps = {
    key?: number
    value: SectionEntity
}

export default function Section(props: SectionProps) {
    return (
        <div className={'col pt-2 text-center border-top border-bottom '}>
            <a className="av" href={'?section=' + props.value.name}>
                <img src={IMG_PATH + '/admin_' + props.value.name + '.gif'} alt={props.value.name}/>
                <br/>
                {props.value.description}
            </a>
        </div>
    )
}