import React from "react"
import renderer from "react-test-renderer"
import Context from "../src/context"
import Sections from "../src/sections"

describe("Sections should", () => {

    test("return sections", () => {
        const context = []

        const component = renderer.create(
            <Context.Provider value={context}>
                <Sections/>
            </Context.Provider>
        )

        expect(component.toJSON()).toMatchSnapshot()

        component.unmount()
    })

})