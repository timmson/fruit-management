import React from "react"
import renderer from "react-test-renderer"
import Context from "../../src/context"
import {okAndJson} from "../../utils/mockResponses"
import Home from "../../src/home/home"

global.fetch = jest.fn(() => okAndJson({}))

describe("Plan should", () => {

	test("return plan form", () => {
		const context = []

		const component = renderer.create(
			<Context.Provider value={context}>
				<Home/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})