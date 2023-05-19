import React from "react"
import renderer from "react-test-renderer"
import Context from "../../src/context"
import {okAndJson} from "../../utils/mockResponses"
import Kanban from "../../src/kanban/kanban"

global.fetch = jest.fn(() => okAndJson({}))

describe("Kanban should", () => {

    test("return plan form", () => {
        const context = []

        const component = renderer.create(
            <Context.Provider value={context}>
                <Kanban/>
            </Context.Provider>
        )

        expect(component.toJSON()).toMatchSnapshot()

        component.unmount()
    })

})
