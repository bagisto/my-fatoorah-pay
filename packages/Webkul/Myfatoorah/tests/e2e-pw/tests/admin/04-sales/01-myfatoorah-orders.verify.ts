import { test, expect } from "../../../fixtures/test";
import { OrderViewPage } from "../../../pages/admin/sales/OrderViewPage";
import { mock } from "../../../utils/mock";
import { rememberedOrder } from "../../../utils/runState";

async function paidInvoiceOf(orderId: string) {
    const { invoices } = await mock.state();

    const invoice = invoices.find(
        (entry) =>
            entry.customerReference === orderId && entry.status === "Paid",
    );

    if (!invoice) {
        throw new Error(`[e2e-pw] No paid mock invoice for order ${orderId}.`);
    }

    return invoice;
}

test.describe("Admin — sales › MyFatoorah orders", () => {
    for (const [key, label] of [
        ["apple-pay", "Apple Pay"],
        ["knet", "KNET"],
        ["card", "card"],
        ["webhook-v1", "webhook v1"],
        ["webhook-v2", "webhook v2"],
    ] as const) {
        test(`the ${label} order is processing with its invoice`, async ({
            page,
        }) => {
            const view = new OrderViewPage(page);

            await view.open(rememberedOrder(key).orderId);

            await expect(view.text("Processing")).toBeVisible();
            await expect(view.text("Invoices (1)")).toBeVisible();
            await expect(view.text("MyFatoorah")).toBeVisible();
        });
    }

    for (const [key, label] of [
        ["webhook-forged", "forged webhook"],
        ["amount-mismatch", "mismatched amount"],
    ] as const) {
        test(`the ${label} order stays pending`, async ({ page }) => {
            const view = new OrderViewPage(page);

            await view.open(rememberedOrder(key).orderId);

            await expect(view.text("Pending")).toBeVisible();
            await expect(view.text("Invoices (0)")).toBeVisible();
        });
    }

    test("the order of a declined payment is cancelled", async ({ page }) => {
        const view = new OrderViewPage(page);

        await view.open(rememberedOrder("declined-then-paid").orderId);

        await expect(view.text("Canceled")).toBeVisible();
    });

    test("refunds a MyFatoorah order through MyFatoorah", async ({ page }) => {
        const order = rememberedOrder("knet");
        const invoice = await paidInvoiceOf(order.orderId);
        const view = new OrderViewPage(page);

        await view.open(order.orderId);
        await view.refundAll();

        const refund = (await mock.state()).refunds.find(
            (entry) => entry.Key === String(invoice.id),
        );

        expect(refund).toBeDefined();
        expect(refund?.Amount).toBeCloseTo(invoice.value, 2);
        expect(refund?.CurrencyIso).toBe(invoice.currency);

        await view.open(order.orderId);

        await expect(view.text("Closed")).toBeVisible();
    });

    test("does not save a refund MyFatoorah rejects", async ({ page }) => {
        const order = rememberedOrder("card");
        const view = new OrderViewPage(page);
        const before = (await mock.state()).refunds.length;

        await mock.failNext("rejected", ["MakeRefund"]);

        await view.open(order.orderId);
        await view.refundAll();

        expect(await page.content()).toContain("MyFatoorah could not refund");
        expect((await mock.state()).refunds.length).toBe(before);

        await view.open(order.orderId);

        await expect(view.text("Processing")).toBeVisible();
    });
});
