import { test, expect } from "../../../fixtures/test";
import { CheckoutPage } from "../../../pages/shop/CheckoutPage";
import { SuccessPage } from "../../../pages/shop/SuccessPage";
import { MockGatewayPage } from "../../../pages/shop/myfatoorah/MockGatewayPage";
import { mock } from "../../../utils/mock";
import { rememberOrder } from "../../../utils/runState";

test.describe("Shop — myfatoorah › Google Pay and card form", () => {
    test.beforeEach(async ({ page, storefront }) => {
        await mock.walletOutcome("pay");

        await storefront.addToCart();

        await new CheckoutPage(page).goToPayment(
            `embedded+${Date.now()}@example.com`,
        );
    });

    test("pays with Google Pay through the MyFatoorah session", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);

        await checkout.chooseMyfatoorahMethod("gp");

        await expect(checkout.placeOrderButton).toHaveCount(0);

        await checkout.walletButton("gp").click();

        await new SuccessPage(page).waitUntilOpen();

        const invoice = await mock.latestInvoice();

        expect(invoice.source).toBe("session");
        expect(invoice.methodCode).toBe("gp");
    });

    test("pays with a card in the embedded form after 3-D Secure", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);

        await checkout.chooseMyfatoorahMethod("vm");

        await checkout.placeOrderButton.click();

        await expect(checkout.cardNumberInput).toBeVisible();

        await checkout.cardNumberInput.fill("5123450000000008");
        await checkout.payNowButton.click();

        const gateway = new MockGatewayPage(page);

        await gateway.waitUntilOpen();

        const invoice = await mock.latestInvoice();

        expect(invoice.source).toBe("session");
        expect(invoice.methodCode).toBe("vm");

        await gateway.complete("pay");

        await new SuccessPage(page).waitUntilOpen();

        rememberOrder("card", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("keeps the card form open and explains a missing card number", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);
        const before = await mock.countRequests("ExecutePayment");

        await checkout.chooseMyfatoorahMethod("vm");
        await checkout.placeOrderButton.click();

        await expect(checkout.cardNumberInput).toBeVisible();

        await checkout.payNowButton.click();

        await expect(page.getByText("Card number is required.")).toBeVisible();
        await expect(checkout.cardNumberInput).toBeVisible();
        await expect(checkout.payNowButton).toBeEnabled();

        expect(await mock.countRequests("ExecutePayment")).toBe(before);
    });

    test("closes the card form without starting a payment", async ({
        page,
    }) => {
        const checkout = new CheckoutPage(page);
        const before = await mock.countRequests("ExecutePayment");

        await checkout.chooseMyfatoorahMethod("vm");
        await checkout.placeOrderButton.click();

        await expect(checkout.cardNumberInput).toBeVisible();

        await checkout.cancelCardButton.click();

        await expect(checkout.cardNumberInput).toBeHidden();

        expect(await mock.countRequests("ExecutePayment")).toBe(before);
    });
});
