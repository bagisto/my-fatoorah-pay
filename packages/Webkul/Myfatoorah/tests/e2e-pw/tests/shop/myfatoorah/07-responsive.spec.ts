import { test, expect } from "../../../fixtures/test";
import { ErrorPage } from "../../../pages/shop/myfatoorah/ErrorPage";
import { PaymentMethodsPage } from "../../../pages/shop/myfatoorah/PaymentMethodsPage";

async function hasNoSidewaysScroll(page: import("@playwright/test").Page) {
    return page.evaluate(
        () =>
            document.documentElement.scrollWidth <=
            document.documentElement.clientWidth + 1,
    );
}

test.describe("Shop — myfatoorah › small screens", () => {
    test.use({ viewport: { width: 375, height: 740 } });

    test("fits the MyFatoorah payment page on a phone", async ({
        page,
        storefront,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        const methods = new PaymentMethodsPage(page);

        await expect(methods.gateway("KNET")).toBeVisible();

        expect(await hasNoSidewaysScroll(page)).toBe(true);
    });

    test("fits the payment error page on a phone", async ({ page }) => {
        await page.goto("myfatoorah/callback?paymentId=070799999999999");

        await expect(new ErrorPage(page).title).toBeVisible();

        expect(await hasNoSidewaysScroll(page)).toBe(true);
    });
});
