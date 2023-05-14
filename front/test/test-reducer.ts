import Reducer from "../src/reducer";
import {ActionName, LogonState, SECTIONS} from "../src/types";

describe("Reducer should", () => {

    test("login", () => {
        let expected = {
            user: "user",
            logonState: LogonState.IS_LOGGED_IN}

        const actual = Reducer(
            {logonState: LogonState.UNDEFINED},
            {data: expected.user, name: ActionName.LOG_IN}
        )

        expect(actual).toEqual(expected)
    })

    test("logout", () => {
        let expected = {
            logonState: LogonState.IS_LOGGED_OUT
        }

        const actual = Reducer(
            {logonState: LogonState.IS_LOGGED_IN},
            {data: "", name: ActionName.LOG_OUT}
        )

        expect(actual).toEqual(expected)
    })

    test("change section", () => {
        let sectionName = "user";
        let expected = {
            section: SECTIONS.filter((it) => it.name == sectionName)[0],
            logonState: LogonState.IS_LOGGED_IN
        }

        const actual = Reducer(
            {logonState: LogonState.IS_LOGGED_IN},
            {data: sectionName, name: ActionName.CHANGE_SECTION}
        )

        expect(actual).toEqual(expected)
    })

})