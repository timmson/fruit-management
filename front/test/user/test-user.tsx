import React from "react"
import renderer from "react-test-renderer"
import User from "../../src/user/user"
import Context from "../../src/context"
import {okAndJson} from "../../utils/mockResponses"

global.fetch = jest.fn(() => okAndJson({}))

describe("User should", () => {

	test("return user form", () => {
		const context = [{user: {samaccountname: "user"}}]

		const component = renderer.create(
			<Context.Provider value={context}>
				<User/>
			</Context.Provider>
		)

		expect(component.toJSON()).toMatchSnapshot()

		component.unmount()
	})

})
