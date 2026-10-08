import { test, expect } from "../../../fixtures/test";
import { CheckoutPage } from "../../../pages/shop/CheckoutPage";
import { SuccessPage } from "../../../pages/shop/SuccessPage";
import { ErrorPage } from "../../../pages/shop/myfatoorah/ErrorPage";
import { emulateApplePayDevice } from "../../../utils/applePay";
import { mock } from "../../../utils/mock";
import { rememberOrder } from "../../../utils/runState";

test.describe("Shop — myfatoorah › Apple Pay", () => {
    test.beforeEach(async ({ page, storefront }) => {
        await mock.walletOutcome("pay");

        await emulateApplePayDevice(page);

        await storefront.addToCart();

        await new CheckoutPage(page).goToPayment(
            `apple-pay+${Date.now()}@example.com`,
        );
    });

    test.afterEach(async () => {
        await mock.walletOutcome("pay");
    });

    test("pays with Apple Pay through the MyFatoorah session", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);

        await checkout.chooseMyfatoorahMethod("ap");

        const returned = page.waitForRequest(
            (request) =>
                request.isNavigationRequest() &&
                new URL(request.url()).pathname === "/myfatoorah/callback",
        );

        await checkout.walletButton("ap").click();

        const callbackUrl = (await returned).url();

        const success = new SuccessPage(page);

        await success.waitUntilOpen();
        await expect(success.heading).toBeVisible();

        const invoice = await mock.latestInvoice();
        const [execute] = (await mock.requests("ExecutePayment")).slice(-1);

        expect(invoice.source).toBe("session");
        expect(invoice.methodCode).toBe("ap");
        expect(execute.body.SessionId).toBeTruthy();
        expect(execute.body.PaymentMethodId).toBeUndefined();
        expect(String(execute.body.CustomerReference)).toBe(
            invoice.customerReference,
        );
        expect(invoice.transactions[0].PaymentGateway).toBe("Apple Pay");

        await page.goto(callbackUrl);
        await success.waitUntilOpen();

        rememberOrder("apple-pay", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("a declined Apple Pay payment explains why and keeps the cart", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);

        await mock.walletOutcome("decline");

        await checkout.chooseMyfatoorahMethod("ap");
        await checkout.walletButton("ap").click();

        await page.waitForURL("**/myfatoorah/error**");

        await expect(
            new ErrorPage(page).message(
                "Invoice is not paid due to Declined by the issuing bank.",
            ),
        ).toBeVisible();

        const cart = await (
            await page.request.get("api/checkout/onepage/summary")
        ).json();

        expect(cart.data.items.length).toBeGreaterThan(0);
    });

    test("a cancelled Apple Pay payment shows the reason", async ({ page }) => {
        const checkout = new CheckoutPage(page);

        await mock.walletOutcome("cancel");

        await checkout.chooseMyfatoorahMethod("ap");
        await checkout.walletButton("ap").click();

        await page.waitForURL("**/myfatoorah/error**");

        await expect(
            new ErrorPage(page).message(
                "Invoice is not paid due to Cancelled by the customer.",
            ),
        ).toBeVisible();
    });

    test("pressing Apple Pay twice starts one payment", async ({ page }) => {
        const checkout = new CheckoutPage(page);
        const before = await mock.countRequests("ExecutePayment");

        await checkout.chooseMyfatoorahMethod("ap");

        await checkout.walletButton("ap").dblclick();

        await new SuccessPage(page).waitUntilOpen();

        expect(await mock.countRequests("ExecutePayment")).toBe(before + 1);
    });
});
