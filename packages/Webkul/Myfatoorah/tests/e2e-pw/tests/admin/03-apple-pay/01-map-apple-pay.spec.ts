import { test, expect } from "../../../fixtures/test";
import { MapApplePayPage } from "../../../pages/admin/settings/MapApplePayPage";
import { mock } from "../../../utils/mock";

test.describe("Admin — Apple Pay › map Apple Pay domain", () => {
    test("is listed in the admin menu while Apple Pay registration is on", async ({
        page,
    }) => {
        const mapApplePay = new MapApplePayPage(page);

        await page.goto("admin/dashboard");

        await expect(mapApplePay.menuLink).toBeAttached();
    });

    test("registers the store domain with MyFatoorah", async ({ page }) => {
        const mapApplePay = new MapApplePayPage(page);

        await mapApplePay.open();

        await expect(mapApplePay.heading).toBeVisible();

        await mapApplePay.register("shop.example.com");

        await page.waitForLoadState("domcontentloaded");

        expect((await mock.state()).domains).toContain("shop.example.com");

        expect(await page.content()).toContain("OK");
    });

    test("shows MyFatoorah's reason when the domain is not verified", async ({
        page,
    }) => {
        const mapApplePay = new MapApplePayPage(page);

        await mapApplePay.open();

        await mapApplePay.register("unverified.example.com");

        await page.waitForLoadState("domcontentloaded");

        expect(await page.content()).toContain(
            "apple-developer-merchantid-domain-association",
        );
    });

    test("rejects a malformed domain before calling MyFatoorah", async ({
        page,
    }) => {
        const mapApplePay = new MapApplePayPage(page);
        const before = await mock.countRequests("RegisterApplePayDomain");

        await mapApplePay.open();

        await mapApplePay.register("not a domain/../x");

        await page.waitForLoadState("domcontentloaded");

        expect(await mock.countRequests("RegisterApplePayDomain")).toBe(before);
    });
});
