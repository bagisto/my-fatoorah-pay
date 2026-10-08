import fixture from "../../../data/myfatoorah/fixture.json";
import { test, expect } from "../../../fixtures/test";
import { SuccessPage } from "../../../pages/shop/SuccessPage";
import { ErrorPage } from "../../../pages/shop/myfatoorah/ErrorPage";
import { MockGatewayPage } from "../../../pages/shop/myfatoorah/MockGatewayPage";
import { PaymentMethodsPage } from "../../../pages/shop/myfatoorah/PaymentMethodsPage";
import { mock } from "../../../utils/mock";
import { rememberOrder } from "../../../utils/runState";

test.describe("Shop — myfatoorah › MyFatoorah payment page", () => {
    test("pays with KNET from the MyFatoorah payment page", async ({
        page,
        storefront,
    }) => {
        const redirectUrl = await storefront.checkoutWithMyfatoorah();

        expect(new URL(redirectUrl).pathname).toBe("/myfatoorah/checkout");

        await page.goto(redirectUrl);

        const methods = new PaymentMethodsPage(page);

        await expect(methods.gateway("KNET")).toBeVisible();

        await methods.gateway("KNET").click();

        const gateway = new MockGatewayPage(page);

        await gateway.waitUntilOpen();

        const invoice = await mock.latestInvoice();

        expect(invoice.source).toBe("gateway");
        expect(invoice.methodCode).toBe("kn");

        await gateway.complete("pay");

        const success = new SuccessPage(page);

        await success.waitUntilOpen();
        await expect(success.heading).toBeVisible();

        rememberOrder("knet", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("sends the order as the invoice reference with the order amount", async ({
        page,
        storefront,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        await new PaymentMethodsPage(page).gateway("KNET").click();
        await new MockGatewayPage(page).waitUntilOpen();

        const [request] = (await mock.requests("ExecutePayment")).slice(-1);
        const cart = await (
            await page.request.get("api/checkout/onepage/summary")
        ).json();

        expect(Number(request.body.CustomerReference)).toBeGreaterThan(0);
        expect(Number(request.body.InvoiceValue)).toBeCloseTo(
            Number(cart.data.grand_total),
            2,
        );
        expect(request.body.DisplayCurrencyIso).toBe(fixture.currency);
        expect(request.body.Language).toBe("en");
        expect(request.body.PaymentMethodId).toBe("1");
    });

    test("offers a way back to the cart", async ({ page, storefront }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        const methods = new PaymentMethodsPage(page);

        await expect(methods.backToCart).toHaveAttribute(
            "href",
            /\/checkout\/cart$/,
        );
    });

    test("a declined payment explains why and keeps the cart for a retry", async ({
        page,
        storefront,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        await new PaymentMethodsPage(page).gateway("KNET").click();

        const gateway = new MockGatewayPage(page);

        await gateway.waitUntilOpen();

        const returnUrl = await gateway.complete("decline");

        expect(new URL(returnUrl).pathname).toBe("/myfatoorah/error");

        const error = new ErrorPage(page);

        await expect(error.title).toBeVisible();
        await expect(
            error.message(
                "Invoice is not paid due to Declined by the issuing bank.",
            ),
        ).toBeVisible();

        const cart = await (
            await page.request.get("api/checkout/onepage/summary")
        ).json();

        expect(cart.data.items.length).toBeGreaterThan(0);

        await page.goto(await storefront.placeOrder());

        await new PaymentMethodsPage(page).gateway("KNET").click();
        await gateway.waitUntilOpen();
        await gateway.complete("pay");

        await new SuccessPage(page).waitUntilOpen();

        const invoices = (await mock.state()).invoices.slice(-2);

        expect(invoices[1].customerReference).not.toBe(
            invoices[0].customerReference,
        );

        rememberOrder("declined-then-paid", {
            orderId: String(invoices[0].customerReference),
            incrementId: String(invoices[0].customerReference),
        });
    });

    test("a payment cancelled on MyFatoorah shows the reason", async ({
        page,
        storefront,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        await new PaymentMethodsPage(page).gateway("KNET").click();

        const gateway = new MockGatewayPage(page);

        await gateway.waitUntilOpen();
        await gateway.complete("cancel");

        await expect(
            new ErrorPage(page).message(
                "Invoice is not paid due to Cancelled by the customer.",
            ),
        ).toBeVisible();
    });

    test("a payment still in progress tells the customer to wait", async ({
        page,
        storefront,
    }) => {
        await page.goto(await storefront.checkoutWithMyfatoorah());

        await new PaymentMethodsPage(page).gateway("KNET").click();
        await new MockGatewayPage(page).waitUntilOpen();

        const invoice = await mock.latestInvoice();
        const { paymentId } = await mock.settle(invoice.id, "pending");

        await page.goto(`myfatoorah/callback?paymentId=${paymentId}`);

        await expect(
            new ErrorPage(page).message(
                "Your payment is still being processed. Your order will be updated as soon as MyFatoorah confirms it.",
            ),
        ).toBeVisible();
    });
});
