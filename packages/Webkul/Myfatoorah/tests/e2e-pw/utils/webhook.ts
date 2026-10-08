import crypto from "crypto";

export type WebhookV1Event = {
    EventType: number;
    Event: string;
    DateTime: string;
    CountryIsoCode: string;
    Data: Record<string, string | number | null>;
};

export type WebhookV2Event = {
    Event: { Code: number; Name: string; Reference: string };
    Data: {
        Invoice: { Id: string; Status: string; ExternalIdentifier: string };
        Transaction: { Status: string; PaymentId: string };
    };
};

function sign(fields: string[], secret: string): string {
    return crypto
        .createHmac("sha256", secret)
        .update(fields.join(","))
        .digest("base64");
}

export function transactionStatusChangedV1(
    invoiceId: number,
    paymentId: string,
    customerReference: string,
): WebhookV1Event {
    return {
        EventType: 1,
        Event: "TransactionsStatusChanged",
        DateTime: "07102026120000",
        CountryIsoCode: "KWT",
        Data: {
            InvoiceId: invoiceId,
            InvoiceReference: `2026${invoiceId}`,
            CreatedDate: "07102026115900",
            CustomerReference: customerReference,
            PaymentId: paymentId,
            TransactionStatus: "SUCCESS",
            PaymentMethod: "KNET",
            UserDefinedField: null,
        },
    };
}

export function signV1(event: WebhookV1Event, secret: string): string {
    const keys = Object.keys(event.Data).sort((a, b) =>
        a.toLowerCase().localeCompare(b.toLowerCase()),
    );

    return sign(
        keys.map((key) => `${key}=${event.Data[key] ?? ""}`),
        secret,
    );
}

export function paymentStatusChangedV2(
    invoiceId: number,
    paymentId: string,
    externalIdentifier: string,
): WebhookV2Event {
    return {
        Event: {
            Code: 1,
            Name: "PAYMENT_STATUS_CHANGED",
            Reference: `WH-${invoiceId}-${Date.now()}`,
        },
        Data: {
            Invoice: {
                Id: String(invoiceId),
                Status: "PAID",
                ExternalIdentifier: externalIdentifier,
            },
            Transaction: { Status: "SUCCESS", PaymentId: paymentId },
        },
    };
}

export function signV2(event: WebhookV2Event, secret: string): string {
    const { Invoice, Transaction } = event.Data;

    return sign(
        [
            `Invoice.Id=${Invoice.Id}`,
            `Invoice.Status=${Invoice.Status}`,
            `Transaction.Status=${Transaction.Status}`,
            `Transaction.PaymentId=${Transaction.PaymentId}`,
            `Invoice.ExternalIdentifier=${Invoice.ExternalIdentifier}`,
        ],
        secret,
    );
}
