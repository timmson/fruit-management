import React from "react"
import {SectionEntity} from "./types"
import Section from "./section"

type SectionsProps = {
    value: SectionEntity[]
}

export default function Sections(props: SectionsProps) {
    return props.value.map((entity, i) => (
            <Section key={i} value={entity}/>
        )
    )
}