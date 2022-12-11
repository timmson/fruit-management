import React from "react"
import renderer from "react-test-renderer"
import Login from "../src/login"
import Context from "../src/context"

describe("Login should", () => {

	test("return login form", () => {
		const context = []

		const component = renderer.create(
			<Context.Provider value={context}>
				<Login/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})