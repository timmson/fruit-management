import React from "react"
import Section from "./section"
import {SECTIONS} from "./constants"

type SectionsProps = {
    //value: SectionEntity[]
}

export default function Sections(props: SectionsProps) {
    const sections = SECTIONS.map((entity, i) => <Section key={i} value={entity}/>)

    return (
        <table className="plain">
            <tbody>
            <tr>
                {sections}
            </tr>
            </tbody>
        </table>
    )
}