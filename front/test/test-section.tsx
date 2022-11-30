import React from "react"
import renderer from "react-test-renderer"
import Section from "../src/section"

describe("Section should", () => {

    test("return section", () => {
        const entity = {name: "name", description: "descr"}

        const component = renderer.create(<Section value={entity}/>)

        expect(component.toJSON()).toMatchSnapshot()

        component.unmount()
    })

})