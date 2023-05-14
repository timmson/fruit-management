import React from "react"
import renderer from "react-test-renderer"
import Context from "../../src/context"
import {okAndJson} from "../../utils/mockResponses"
import Project from "../../src/project/project"

global.fetch = jest.fn(() => okAndJson({}))

describe("Project should", () => {

	test("return project form", () => {
		const context = []

		const component = renderer.create(
			<Context.Provider value={context}>
				<Project/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})