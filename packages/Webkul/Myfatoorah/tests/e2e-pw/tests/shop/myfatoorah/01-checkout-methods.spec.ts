import fixture from "../../../data/myfatoorah/fixture.json";
import { test, expect } from "../../../fixtures/test";
import { CheckoutPage } from "../../../pages/shop/CheckoutPage";
import { emulateApplePayDevice, walletInits } from "../../../utils/applePay";
import { mock } from "../../../utils/mock";

test.describe("Shop — myfatoorah › checkout payment methods", () => {
    test.beforeEach(async () => {
        await mock.walletOutcome("pay");
    });

    test("lists MyFatoorah with its VISA/MASTER and Google Pay options", async ({
        page,
        storefront,
    }) => {
        const checkout = new CheckoutPage(page);

        await storefront.addToCart();
        await checkout.goToPayment(`methods+${Date.now()}@example.com`);

        await expect(checkout.paymentCard("myfatoorah")).toBeVisible();
        await expect(checkout.myfatoorahMethod("vm")).toBeVisible();
        await expect(checkout.myfatoorahMethod("gp")).toBeVisible();
    });

    test("hides Apple Pay on a browser without Apple Pay", async ({
        page,
        storefront,
    }) => {
        const checkout = new CheckoutPage(page);

        await storefront.addToCart();
        await checkout.goToPayment(`no-ap+${Date.now()}@example.com`);

        await expect(checkout.myfatoorahMethod("gp")).toBeVisible();
        await expect(checkout.myfatoorahMethod("ap")).toHaveCount(0);
    });

    test("offers Apple Pay on a device that supports it", async ({
        page,
        storefront,
    }) => {
        await emulateApplePayDevice(page);

        const checkout = new CheckoutPage(page);

        await storefront.addToCart();
        await checkout.goToPayment(`ap+${Date.now()}@example.com`);

        await expect(checkout.myfatoorahMethod("ap")).toBeVisible();
    });

    test("replaces Place Order with the Apple Pay button for the cart total", async ({
        page,
        storefront,
    }) => {
        await emulateApplePayDevice(page);

        const checkout = new CheckoutPage(page);

        await storefront.addToCart();
        await checkout.goToPayment(`ap-button+${Date.now()}@example.com`);

        const methods = page.waitForResponse((response) =>
            response.url().includes("myfatoorah/getMethods"),
        );

        await checkout.chooseMyfatoorahMethod("ap");

        await expect(checkout.walletButton("ap")).toBeVisible();
        await expect(checkout.placeOrderButton).toHaveCount(0);

        const session = (await (await methods).json()).paymentSession;
        const [init] = await walletInits(page);
        const cart = await (
            await page.request.get("api/checkout/onepage/summary")
        ).json();

        expect(init.method).toBe("ap");
        expect(init.sessionId).toBe(session.SessionId);
        expect(Number(init.amount)).toBeCloseTo(
            Number(cart.data.grand_total),
            2,
        );
        expect(init.currencyCode).toBe(fixture.currency);
    });

    test("brings Place Order back when another payment method is chosen", async ({
        page,
        storefront,
    }) => {
        await emulateApplePayDevice(page);

        const checkout = new CheckoutPage(page);

        await storefront.addToCart();
        await checkout.goToPayment(`switch+${Date.now()}@example.com`);

        await checkout.chooseMyfatoorahMethod("ap");
        await expect(checkout.walletButton("ap")).toBeVisible();

        const stored = page.waitForResponse(
            (response) =>
                response.url().includes("checkout/onepage/payment-methods") &&
                response.request().method() === "POST",
        );

        await checkout.paymentCard("cashondelivery").click();
        await stored;

        await expect(checkout.placeOrderButton).toBeVisible();
        await expect(checkout.walletButton("ap")).toHaveCount(0);
    });
});
