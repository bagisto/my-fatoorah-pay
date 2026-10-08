import { test as setup } from "../../../fixtures/test";
import { AdminDashboardPage } from "../../../pages/admin/DashboardPage";
import { AdminLoginPage } from "../../../pages/admin/LoginPage";
import { mock } from "../../../utils/mock";
import { ADMIN_AUTH_STATE_PATH, ensureStateDir } from "../../../utils/paths";
import { startRun } from "../../../utils/runState";

setup(
    "Admin — authentication › authenticate as admin",
    async ({ page, env }) => {
        startRun();

        await mock.reset();

        const login = new AdminLoginPage(page);
        await login.open();
        await login.submitCredentials(env.adminEmail, env.adminPassword);

        const dashboard = new AdminDashboardPage(page);
        await dashboard.waitUntilLoaded();

        ensureStateDir();
        await page.context().storageState({ path: ADMIN_AUTH_STATE_PATH });
    },
);
