import React from "react"
import renderer from "react-test-renderer"
import Section from "../src/section"
import Context from "../src/context"

describe("Section should", () => {

	test("return section", () => {
		const entity = {name: "name", description: "descr"}

		const context = []

		const component = renderer.create(
			<Context.Provider value={context}>
				<Section value={entity}/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})