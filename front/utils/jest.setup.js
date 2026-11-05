// Компоненты рендерят дату/месяц/версию из текущего времени, из-за чего
// снапшоты "протухали" каждый месяц. Замораживаем Date на фиксированном
// моменте, чтобы снимки были воспроизводимы в любой день.
jest.useFakeTimers({
    now: new Date("2026-10-15T12:00:00Z"),
    doNotFake: [
        "hrtime",
        "performance",
        "queueMicrotask",
        "requestAnimationFrame",
        "cancelAnimationFrame",
        "requestIdleCallback",
        "cancelIdleCallback",
        "setImmediate",
        "clearImmediate",
        "setTimeout",
        "clearTimeout",
        "setInterval",
        "clearInterval",
        "nextTick"
    ]
})
