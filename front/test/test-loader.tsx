import React from "react"
import renderer from "react-test-renderer"
import Loader from "../src/loader"

describe("Loader should", () => {

    test("return loader", () => {
        const component = renderer.create(<Loader/>)

        expect(component.toJSON()).toMatchSnapshot()

        component.unmount()
    })

})