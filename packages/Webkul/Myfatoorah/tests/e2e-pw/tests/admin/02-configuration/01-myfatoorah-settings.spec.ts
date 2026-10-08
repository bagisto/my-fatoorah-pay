import { test, expect } from "../../../fixtures/test";
import { MyfatoorahConfigurationPage } from "../../../pages/admin/configuration/MyfatoorahConfigurationPage";

test.describe("Admin — configuration › MyFatoorah", () => {
    test("keeps every setting of the v2.1.2 module", async ({ page }) => {
        const config = new MyfatoorahConfigurationPage(page);

        await config.open();

        for (const field of [
            "status",
            "test_mode",
            "save_card",
            "is_webhook_enabled",
            "register_apple_pay",
        ] as const) {
            await expect(config.toggle(field)).toHaveCount(1);
        }

        await expect(config.field("description")).toBeAttached();
        await expect(config.field("logo")).toBeAttached();
        await expect(config.secret("api_key")).toHaveCount(1);
        await expect(config.secret("webhook_secret_key")).toHaveCount(1);

        await expect(config.countrySelect.locator("option")).toContainText([
            "Kuwait",
            "Saudi Arabia",
            "United Arab Emirates",
            "Qatar",
            "Bahrain",
            "Oman",
            "Jordan",
            "Egypt",
        ]);
    });

    test("keeps the stored Jordan value of earlier versions", async ({
        page,
    }) => {
        const config = new MyfatoorahConfigurationPage(page);

        await config.open();

        await expect(
            config.countrySelect.locator('option[value="JOD"]'),
        ).toHaveCount(1);
    });

    test("masks the API key and the webhook secret key", async ({ page }) => {
        const config = new MyfatoorahConfigurationPage(page);

        await config.open();

        await expect(config.secret("api_key")).toHaveAttribute(
            "type",
            "password",
        );
        await expect(config.secret("webhook_secret_key")).toHaveAttribute(
            "type",
            "password",
        );
    });

    test("saves the test-mode configuration", async ({ page, env }) => {
        const config = new MyfatoorahConfigurationPage(page);

        await config.open();

        await config.setToggle("status", true);
        await config.setToggle("test_mode", true);
        await config.countrySelect.selectOption("KWT");
        await config.secret("api_key").fill(env.mockApiKey);
        await config.setToggle("is_webhook_enabled", true);
        await config.secret("webhook_secret_key").fill(env.webhookSecret);
        await config.setToggle("register_apple_pay", true);
        await config.setToggle("save_card", false);

        await config.save();

        await config.open();

        await expect(config.toggle("status")).toBeChecked();
        await expect(config.toggle("test_mode")).toBeChecked();
        await expect(config.toggle("is_webhook_enabled")).toBeChecked();
        await expect(config.toggle("register_apple_pay")).toBeChecked();
        await expect(config.countrySelect).toHaveValue("KWT");
        await expect(config.secret("api_key")).toHaveValue(env.mockApiKey);
        await expect(config.secret("webhook_secret_key")).toHaveValue(
            env.webhookSecret,
        );
    });

    test("shows the webhook endpoint to enter in MyFatoorah", async ({
        page,
        env,
    }) => {
        const config = new MyfatoorahConfigurationPage(page);

        await config.open();

        await expect(config.webhookUrlHint).toContainText(
            `${env.baseUrl}/myfatoorah/webhook`,
        );
    });
});
