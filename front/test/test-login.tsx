import React from "react"
import renderer from "react-test-renderer"
import Login from "../src/login";

describe("Login should", () => {

    test("return login form", () => {
        const component = renderer.create(<Login/>)

        expect(component.toJSON()).toMatchSnapshot()

        component.unmount()
    })

})