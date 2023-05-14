import React from "react"
import renderer from "react-test-renderer"
import Context from "../src/context"
import Header from "../src/header"

describe("Header should", () => {

	test("return header", () => {
		const context = [{user: {fio: "user"}}]

		const component = renderer.create(
			<Context.Provider value={context}>
				<Header/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})