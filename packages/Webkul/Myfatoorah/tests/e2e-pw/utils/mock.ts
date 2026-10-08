import { env } from "./env";

export type MockOutcome = "pay" | "decline" | "cancel" | "pending";

export type MockFailure =
    "timeout" | "server-error" | "rejected" | "unauthorized";

export type MockTransaction = {
    PaymentId: string;
    TransactionId: string;
    TransactionStatus: string;
    PaymentGateway: string;
};

export type MockInvoice = {
    id: number;
    value: number;
    currency: string;
    customerReference: string | null;
    methodCode: string | null;
    source: "invoice" | "gateway" | "session";
    sessionId: string | null;
    language: string | null;
    status: string;
    transactions: MockTransaction[];
};

export type MockRequest = {
    operation: string;
    body: Record<string, unknown>;
};

export type MockState = {
    invoices: MockInvoice[];
    sessions: { id: string; method: string | null; used: boolean }[];
    refunds: {
        Key: string;
        Amount: number;
        CurrencyIso: string | null;
    }[];
    domains: string[];
    requests: MockRequest[];
};

async function call<T>(path: string, body: unknown = {}): Promise<T> {
    const response = await fetch(`${env.mockUrl}${path}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
    });

    if (!response.ok) {
        throw new Error(
            `[e2e-pw] MyFatoorah mock ${path} answered ${response.status}.`,
        );
    }

    return (await response.json()) as T;
}

export const mock = {
    reset(): Promise<unknown> {
        return call("/__mock/reset");
    },

    failNext(
        mode: MockFailure,
        operations: string[],
        times = 1,
    ): Promise<unknown> {
        return call("/__mock/failures", { mode, operations, times });
    },

    walletOutcome(outcome: MockOutcome): Promise<unknown> {
        return call("/__mock/wallet-outcome", { outcome });
    },

    state(): Promise<MockState> {
        return call<MockState>("/__mock/state");
    },

    async latestInvoice(): Promise<MockInvoice> {
        const { invoices } = await this.state();

        const invoice = invoices[invoices.length - 1];

        if (!invoice) {
            throw new Error("[e2e-pw] The MyFatoorah mock holds no invoice.");
        }

        return invoice;
    },

    settle(
        invoiceId: number,
        outcome: MockOutcome,
    ): Promise<{ paymentId: string; invoiceId: number }> {
        return call(`/__mock/invoices/${invoiceId}/${outcome}`);
    },

    overrideDisplayValue(invoiceId: number, value: string): Promise<unknown> {
        return call(`/__mock/invoices/${invoiceId}/display`, { value });
    },

    async requests(operation: string): Promise<MockRequest[]> {
        const { requests } = await this.state();

        return requests.filter((request) => request.operation === operation);
    },

    async countRequests(operation: string): Promise<number> {
        return (await this.requests(operation)).length;
    },
};
