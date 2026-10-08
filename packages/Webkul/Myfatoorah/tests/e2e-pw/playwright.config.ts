import { defineConfig, devices } from "@playwright/test";
import { env } from "./utils/env";
import { ADMIN_AUTH_STATE_PATH } from "./utils/paths";

const mockUrl = new URL(env.mockUrl);

export default defineConfig({
    testDir: "./tests",

    timeout: 90_000,

    expect: { timeout: 10_000 },

    outputDir: "./test-results",

    fullyParallel: false,

    workers: 1,

    forbidOnly: !!process.env.CI,

    reporter: [
        ["list"],
        [
            "html",
            {
                outputFolder: "./playwright-report",
                open: "never",
            },
        ],
    ],

    webServer: {
        command: "node mock/myfatoorah-mock.mjs",
        url: `${env.mockUrl}/health`,
        reuseExistingServer: true,
        timeout: 15_000,
        env: {
            MYFATOORAH_MOCK_HOST: mockUrl.hostname,
            MYFATOORAH_MOCK_PORT: mockUrl.port || "80",
            MYFATOORAH_MOCK_API_KEY: env.mockApiKey,
        },
    },

    use: {
        ...devices["Desktop Chrome"],
        baseURL: `${env.baseUrl}/`,
        actionTimeout: env.actionTimeout,
        navigationTimeout: env.navigationTimeout,
        headless: !env.headed,
        screenshot: { mode: "only-on-failure", fullPage: true },
        trace: "retain-on-failure",
    },

    projects: [
        {
            name: "admin-setup",
            testMatch: "admin/**/*.setup.ts",
        },
        {
            name: "admin",
            testMatch: "admin/**/*.spec.ts",
            dependencies: ["admin-setup"],
            use: {
                storageState: ADMIN_AUTH_STATE_PATH,
            },
        },
        {
            name: "shop",
            testMatch: "shop/**/*.spec.ts",
            dependencies: ["admin"],
        },
        {
            name: "admin-verify",
            testMatch: "admin/**/*.verify.ts",
            dependencies: ["shop"],
            use: {
                storageState: ADMIN_AUTH_STATE_PATH,
            },
        },
    ],
});
