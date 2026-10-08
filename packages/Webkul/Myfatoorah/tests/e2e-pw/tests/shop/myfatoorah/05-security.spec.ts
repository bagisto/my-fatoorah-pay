import { test, expect } from "../../../fixtures/test";
import { SuccessPage } from "../../../pages/shop/SuccessPage";
import { ErrorPage } from "../../../pages/shop/myfatoorah/ErrorPage";
import { MockGatewayPage } from "../../../pages/shop/myfatoorah/MockGatewayPage";
import { PaymentMethodsPage } from "../../../pages/shop/myfatoorah/PaymentMethodsPage";
import { mock } from "../../../utils/mock";
import { startGatewayPayment } from "../../../utils/payment";
import { rememberOrder } from "../../../utils/runState";

const GENERIC_ERROR = "Error Occurred While Processing Your Request.";

test.describe("Shop — myfatoorah › security", () => {
    test("refuses a malformed payment id without calling MyFatoorah", async ({
        page,
    }) => {
        const before = await mock.countRequests("GetPaymentStatus");

        await page.goto(
            "myfatoorah/callback?paymentId=%3Cscript%3Ealert(1)%3C%2Fscript%3E",
        );

        await expect(new ErrorPage(page).message(GENERIC_ERROR)).toBeVisible();
        expect(await page.content()).not.toContain("<script>alert(1)");
        expect(await mock.countRequests("GetPaymentStatus")).toBe(before);
    });

    test("refuses a payment id MyFatoorah does not know", async ({ page }) => {
        await page.goto("myfatoorah/callback?paymentId=070799999999999");

        await expect(new ErrorPage(page).message(GENERIC_ERROR)).toBeVisible();
    });

    test("refuses a malformed session id without creating an invoice", async ({
        page,
        storefront,
    }) => {
        await storefront.checkoutWithMyfatoorah();

        const before = await mock.countRequests("ExecutePayment");

        await page.goto("myfatoorah?sessionId=..%2F..%2Fadmin");

        await expect(new ErrorPage(page).message(GENERIC_ERROR)).toBeVisible();
        expect(await mock.countRequests("ExecutePayment")).toBe(before);
    });

    test("does not complete an order when the paid amount differs", async ({
        page,
        storefront,
    }) => {
        const invoice = await startGatewayPayment(storefront);

        await mock.overrideDisplayValue(invoice.id, "1.000");

        const { paymentId } = await mock.settle(invoice.id, "pay");

        await page.goto(`myfatoorah/callback?paymentId=${paymentId}`);

        await expect(new ErrorPage(page).message(GENERIC_ERROR)).toBeVisible();

        const cart = await (
            await page.request.get("api/checkout/onepage/summary")
        ).json();

        expect(cart.data.items.length).toBeGreaterThan(0);

        rememberOrder("amount-mismatch", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("shows no order details to someone else opening the return link", async ({
        page,
        storefront,
        browser,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        await new PaymentMethodsPage(page).gateway("KNET").click();

        const gateway = new MockGatewayPage(page);

        await gateway.waitUntilOpen();

        const callbackUrl = await gateway.complete("pay");

        await new SuccessPage(page).waitUntilOpen();

        const stranger = await browser.newContext();
        const strangerPage = await stranger.newPage();

        await strangerPage.goto(callbackUrl);

        expect(strangerPage.url()).toContain("/checkout/cart");
        expect(await strangerPage.content()).not.toContain("Your order id is");

        await stranger.close();
    });

    test("needs a cart before listing payment methods", async ({
        playwright,
        env,
    }) => {
        const anonymous = await playwright.request.newContext({
            baseURL: `${env.baseUrl}/`,
        });

        const response = await anonymous.get("myfatoorah/getMethods", {
            headers: { Accept: "application/json" },
        });

        expect(response.status()).toBe(500);
        expect((await response.json()).success).toBe(false);

        await anonymous.dispose();
    });
});
