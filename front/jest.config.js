module.exports = {
    collectCoverage: true,
    collectCoverageFrom: ["./src/*"],
    coverageReporters: ["lcov"],
    setupFiles: ["<rootDir>/utils/jest.setup.js"],
    testMatch: ["**/test/**/*.[jt]s?(x)", "**/?(*.)+(spec|test).[jt]s?(x)"]
};