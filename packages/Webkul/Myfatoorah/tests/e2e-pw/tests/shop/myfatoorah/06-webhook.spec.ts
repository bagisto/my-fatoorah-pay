import type { APIRequestContext } from "@playwright/test";
import { test, expect } from "../../../fixtures/test";
import { mock } from "../../../utils/mock";
import { startGatewayPayment } from "../../../utils/payment";
import { rememberOrder } from "../../../utils/runState";
import {
    paymentStatusChangedV2,
    signV1,
    signV2,
    transactionStatusChangedV1,
} from "../../../utils/webhook";

function deliver(
    request: APIRequestContext,
    body: unknown,
    headers: Record<string, string>,
) {
    return request.post("myfatoorah/webhook", {
        data: body,
        headers: { Accept: "application/json", ...headers },
    });
}

test.describe("Shop — myfatoorah › webhook", () => {
    test("completes a paid order from a signed version 2 webhook", async ({
        request,
        storefront,
        env,
    }) => {
        const invoice = await startGatewayPayment(storefront);
        const { paymentId } = await mock.settle(invoice.id, "pay");
        const event = paymentStatusChangedV2(
            invoice.id,
            paymentId,
            String(invoice.customerReference),
        );

        const response = await deliver(request, event, {
            "MyFatoorah-Signature": signV2(event, env.webhookSecret),
            "MyFatoorah-Webhook-Version": "v2",
        });

        expect(response.status(), await response.text()).toBe(200);
        expect((await response.json()).success).toBe(true);

        const replay = await deliver(request, event, {
            "MyFatoorah-Signature": signV2(event, env.webhookSecret),
            "MyFatoorah-Webhook-Version": "v2",
        });

        expect(replay.status()).toBe(200);

        rememberOrder("webhook-v2", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("completes a paid order from a signed version 1 webhook", async ({
        request,
        storefront,
        env,
    }) => {
        const invoice = await startGatewayPayment(storefront);
        const { paymentId } = await mock.settle(invoice.id, "pay");
        const event = transactionStatusChangedV1(
            invoice.id,
            paymentId,
            String(invoice.customerReference),
        );

        const response = await deliver(request, event, {
            "MyFatoorah-Signature": signV1(event, env.webhookSecret),
            "MyFatoorah-Webhook-Version": "v1",
        });

        expect(response.status(), await response.text()).toBe(200);
        expect((await response.json()).success).toBe(true);

        rememberOrder("webhook-v1", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("ignores a webhook signed with another secret", async ({
        request,
        storefront,
    }) => {
        const invoice = await startGatewayPayment(storefront);
        const { paymentId } = await mock.settle(invoice.id, "pay");
        const event = paymentStatusChangedV2(
            invoice.id,
            paymentId,
            String(invoice.customerReference),
        );
        const before = await mock.countRequests("GetPaymentStatus");

        const response = await deliver(request, event, {
            "MyFatoorah-Signature": signV2(event, "not-the-secret"),
            "MyFatoorah-Webhook-Version": "v2",
        });

        expect(response.status()).toBe(404);
        expect(await mock.countRequests("GetPaymentStatus")).toBe(before);

        rememberOrder("webhook-forged", {
            orderId: String(invoice.customerReference),
            incrementId: String(invoice.customerReference),
        });
    });

    test("ignores an unsigned webhook", async ({ request }) => {
        const response = await deliver(
            request,
            paymentStatusChangedV2(1, "1", "1"),
            {},
        );

        expect(response.status()).toBe(404);
    });

    test("rejects a webhook without data", async ({ request }) => {
        const response = await deliver(
            request,
            { Event: { Code: 1 } },
            { "MyFatoorah-Signature": "x" },
        );

        expect(response.status()).toBe(400);
    });
});
