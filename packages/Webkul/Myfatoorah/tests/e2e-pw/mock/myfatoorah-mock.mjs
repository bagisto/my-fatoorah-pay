import crypto from "node:crypto";
import http from "node:http";
import { URL } from "node:url";

const HOST = process.env.MYFATOORAH_MOCK_HOST || "127.0.0.1";
const PORT = Number(process.env.MYFATOORAH_MOCK_PORT || 4010);
const API_KEY = process.env.MYFATOORAH_MOCK_API_KEY || "mf-e2e-sandbox-key";
const ORIGIN = `http://${HOST}:${PORT}`;

const DISPLAY_LABELS = { KWD: "KD", SAR: "SR", BHD: "BD", QAR: "QR" };
const DECIMALS = { KWD: 3, BHD: 3, OMR: 3, JOD: 3 };
const KUWAIT_OFFSET_MS = 3 * 60 * 60 * 1000;

const CURRENCY_RATES = [
    { Text: "KWD", Value: "1" },
    { Text: "USD", Value: "3.25" },
    { Text: "SAR", Value: "12.2" },
    { Text: "AED", Value: "11.9" },
    { Text: "QAR", Value: "11.8" },
    { Text: "BHD", Value: "1.22" },
    { Text: "OMR", Value: "1.25" },
    { Text: "JOD", Value: "2.3" },
    { Text: "EGP", Value: "155" },
    { Text: "EUR", Value: "3.0" },
];

const PAYMENT_METHODS = [
    {
        id: 1,
        code: "kn",
        en: "KNET",
        ar: "كي نت",
        embedded: false,
        direct: false,
        charge: 0,
    },
    {
        id: 2,
        code: "vm",
        en: "VISA/MASTER",
        ar: "فيزا / ماستر",
        embedded: true,
        direct: true,
        charge: 0.25,
    },
    {
        id: 11,
        code: "ap",
        en: "Apple Pay",
        ar: "أبل باي",
        embedded: true,
        direct: false,
        charge: 0,
    },
    {
        id: 32,
        code: "gp",
        en: "Google Pay",
        ar: "جوجل باي",
        embedded: true,
        direct: false,
        charge: 0,
    },
    {
        id: 20,
        code: "vmd",
        en: "Visa/Master Direct",
        ar: "فيزا مباشر",
        embedded: false,
        direct: true,
        charge: 0,
    },
];

const state = {
    invoices: new Map(),
    payments: new Map(),
    sessions: new Map(),
    refunds: [],
    domains: [],
    requests: [],
    failures: [],
    walletOutcome: "pay",
    nextInvoiceId: 600000 + Math.floor(Math.random() * 300000),
};

function sendJson(response, status, body) {
    const payload = JSON.stringify(body);

    response.writeHead(status, {
        "Content-Type": "application/json; charset=utf-8",
        "Content-Length": Buffer.byteLength(payload),
        "Access-Control-Allow-Origin": "*",
    });
    response.end(payload);
}

function sendHtml(response, status, html) {
    response.writeHead(status, { "Content-Type": "text/html; charset=utf-8" });
    response.end(html);
}

function sendScript(response, script) {
    response.writeHead(200, {
        "Content-Type": "application/javascript; charset=utf-8",
        "Cache-Control": "no-store",
    });
    response.end(script);
}

function redirect(response, location) {
    response.writeHead(302, { Location: location });
    response.end();
}

function success(data, message = "") {
    return {
        IsSuccess: true,
        Message: message,
        ValidationErrors: null,
        Data: data,
    };
}

function failure(message, errors = null) {
    return {
        IsSuccess: false,
        Message: message,
        ValidationErrors: errors,
        Data: null,
    };
}

function readBody(request) {
    return new Promise((resolve) => {
        let raw = "";

        request.on("data", (chunk) => {
            raw += chunk;
        });

        request.on("end", () => {
            if (!raw) {
                resolve({});

                return;
            }

            if (
                (request.headers["content-type"] || "").includes(
                    "application/x-www-form-urlencoded",
                )
            ) {
                resolve(Object.fromEntries(new URLSearchParams(raw)));

                return;
            }

            try {
                resolve(JSON.parse(raw) ?? {});
            } catch {
                resolve({ __invalid: raw });
            }
        });
    });
}

function money(value, currency) {
    return Number(value).toFixed(DECIMALS[currency] ?? 2);
}

function expiry(invoice) {
    const date = new Date(invoice.expiresAt + KUWAIT_OFFSET_MS);
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];

    return {
        ExpiryDate: `${months[date.getUTCMonth()]} ${date.getUTCDate()}, ${date.getUTCFullYear()}`,
        ExpiryTime: date.toISOString().substring(11, 23),
    };
}

function paymentStatus(invoice) {
    return {
        InvoiceId: invoice.id,
        InvoiceStatus: invoice.status,
        InvoiceReference: `2026${invoice.id}`,
        CustomerReference: invoice.customerReference,
        CreatedDate: invoice.createdAt,
        ...expiry(invoice),
        InvoiceValue: Number(money(invoice.value, invoice.currency)),
        Comments: null,
        CustomerName: invoice.customerName,
        CustomerMobile: invoice.customerMobile,
        CustomerEmail: invoice.customerEmail,
        UserDefinedField: invoice.userDefinedField,
        InvoiceDisplayValue: `${invoice.displayOverride ?? money(invoice.value, invoice.currency)} ${DISPLAY_LABELS[invoice.currency] ?? invoice.currency}`,
        DueDeposit: 0,
        DepositStatus: "Not Deposited",
        InvoiceItems: [],
        InvoiceTransactions: invoice.transactions,
        Suppliers: [],
    };
}

function takeFailure(operation) {
    const index = state.failures.findIndex(
        (entry) =>
            entry.operations.length === 0 ||
            entry.operations.includes(operation),
    );

    if (index === -1) {
        return null;
    }

    const entry = state.failures[index];

    entry.times -= 1;

    if (entry.times <= 0) {
        state.failures.splice(index, 1);
    }

    return entry.mode;
}

function createInvoice(body, methodCode, source) {
    const id = state.nextInvoiceId++;
    const now = Date.now();

    const invoice = {
        id,
        value: Number(body.InvoiceValue),
        currency: body.DisplayCurrencyIso || "KWD",
        customerReference:
            body.CustomerReference == null
                ? null
                : String(body.CustomerReference),
        userDefinedField: body.UserDefinedField ?? null,
        callBackUrl: body.CallBackUrl,
        errorUrl: body.ErrorUrl,
        customerName: body.CustomerName ?? "",
        customerEmail: body.CustomerEmail ?? "",
        customerMobile: body.CustomerMobile ?? "",
        language: body.Language ?? null,
        methodCode,
        source,
        sessionId: body.SessionId ?? null,
        status: "Pending",
        transactions: [],
        refunded: 0,
        displayOverride: null,
        createdAt: new Date(now).toISOString(),
        expiresAt: now + 60 * 60 * 1000,
    };

    state.invoices.set(id, invoice);

    return invoice;
}

function addTransaction(invoice, outcome) {
    const paymentId = `0707${invoice.id}${String(invoice.transactions.length + 1).padStart(4, "0")}${Math.floor(Math.random() * 9000 + 1000)}`;
    const method =
        PAYMENT_METHODS.find((entry) => entry.code === invoice.methodCode) ??
        PAYMENT_METHODS[0];

    const statuses = {
        pay: "Succss",
        decline: "Failed",
        cancel: "Failed",
        pending: "InProgress",
    };

    invoice.transactions.push({
        TransactionDate: new Date().toISOString(),
        PaymentGateway: method.en,
        ReferenceId: String(Math.floor(Math.random() * 1e12)),
        TrackId: String(Math.floor(Math.random() * 1e8)),
        TransactionId: String(
            Math.floor(Math.random() * 9e8) + 1e8 + invoice.transactions.length,
        ),
        PaymentId: paymentId,
        AuthorizationId:
            outcome === "pay" ? String(Math.floor(Math.random() * 1e6)) : null,
        TransactionStatus: statuses[outcome],
        TransationValue: money(invoice.value, invoice.currency),
        CustomerServiceCharge: "0.000",
        DueValue: money(invoice.value, invoice.currency),
        PaidCurrency: DISPLAY_LABELS[invoice.currency] ?? invoice.currency,
        PaidCurrencyValue: money(invoice.value, invoice.currency),
        Currency: DISPLAY_LABELS[invoice.currency] ?? invoice.currency,
        Error:
            outcome === "decline"
                ? "Declined by the issuing bank"
                : outcome === "cancel"
                  ? "Cancelled by the customer"
                  : "",
        ErrorCode: outcome === "decline" ? "MF020" : "",
        CardNumber: "450875xxxxxx1019",
    });

    if (outcome === "pay") {
        invoice.status = "Paid";
    }

    state.payments.set(paymentId, invoice.id);

    return paymentId;
}

function hostedPage(invoice) {
    const amount = `${money(invoice.value, invoice.currency)} ${invoice.currency}`;
    const button = (action, label, style) =>
        `<form method="post" action="/pay/${invoice.id}/${action}"><button id="mf-mock-${action}" type="submit" style="${style}">${label}</button></form>`;

    return `<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MyFatoorah sandbox (mock)</title>
</head>
<body style="font-family: system-ui, sans-serif; max-width: 420px; margin: 48px auto; padding: 0 16px;">
<h1 style="font-size: 20px;">MyFatoorah sandbox (mock)</h1>
<p>Invoice <strong id="mf-mock-invoice">${invoice.id}</strong></p>
<p>Amount <strong id="mf-mock-amount">${amount}</strong></p>
<p>Method <strong id="mf-mock-method">${invoice.methodCode ?? "invoice"}</strong></p>
<p>Status <strong id="mf-mock-status">${invoice.status}</strong></p>
<div style="display: grid; gap: 8px;">
${button("pay", "Pay", "padding: 12px; background: #0041ff; color: #fff; border: 0; width: 100%;")}
${button("decline", "Decline", "padding: 12px; width: 100%;")}
${button("cancel", "Cancel", "padding: 12px; width: 100%;")}
${button("pending", "Leave pending", "padding: 12px; width: 100%;")}
</div>
</body>
</html>`;
}

function methodImage(code) {
    return `<svg xmlns="http://www.w3.org/2000/svg" width="64" height="40" viewBox="0 0 64 40"><rect width="64" height="40" rx="6" fill="#0041ff"/><text x="32" y="25" font-family="Arial" font-size="13" font-weight="700" fill="#fff" text-anchor="middle">${code.toUpperCase()}</text></svg>`;
}

function walletScript(globalName, code, label) {
    return `(function () {
    window.__myfatoorahMock = window.__myfatoorahMock || { inits: [], amounts: [] };

    window.${globalName} = {
        init: function (config) {
            window.__myfatoorahMock.inits.push({ method: "${code}", sessionId: config.sessionId, amount: String(config.amount), currencyCode: config.currencyCode, countryCode: config.countryCode });

            var container = document.getElementById(config.cardViewId);

            if (! container) {
                return;
            }

            var button = document.createElement("button");

            button.type = "button";
            button.id = "mf-mock-${code}-button";
            button.textContent = "${label}";
            button.style.cssText = "width:100%;height:40px;border:0;border-radius:8px;background:#000;color:#fff;font:600 15px system-ui;cursor:pointer";

            button.addEventListener("click", function () {
                navigator.sendBeacon("${ORIGIN}/__mock/sessions/" + encodeURIComponent(config.sessionId) + "/method/${code}");

                config.callback({ sessionId: config.sessionId, cardBrand: "${label}" });
            });

            container.innerHTML = "";
            container.appendChild(button);
        },

        updateAmount: function (amount) {
            window.__myfatoorahMock.amounts.push(String(amount));
        },
    };
})();
`;
}

function cardViewScript() {
    return `(function () {
    window.__myfatoorahMock = window.__myfatoorahMock || { inits: [], amounts: [] };

    var current = null;

    window.myFatoorah = {
        init: function (config) {
            current = config;

            window.__myfatoorahMock.inits.push({ method: "vm", sessionId: config.sessionId, countryCode: config.countryCode });

            var container = document.getElementById(config.cardViewId);

            if (! container) {
                return;
            }

            container.innerHTML = '<label style="display:grid;gap:4px;font:14px system-ui">Card number<input id="mf-mock-card-number" autocomplete="off" style="height:36px;border:1px solid #c7c7c7;border-radius:8px;padding:0 8px"></label>';
        },

        submit: function () {
            var input = document.getElementById("mf-mock-card-number");

            if (! current || ! input || ! input.value.trim()) {
                return Promise.reject(new Error("Card number is required."));
            }

            navigator.sendBeacon("${ORIGIN}/__mock/sessions/" + encodeURIComponent(current.sessionId) + "/method/vm");

            return Promise.resolve({ sessionId: current.sessionId, cardBrand: "Visa" });
        },
    };
})();
`;
}

async function handleApi(request, response, operation) {
    const body = await readBody(request);

    state.requests.push({
        operation,
        body,
        authorization: request.headers.authorization ?? null,
        at: Date.now(),
    });

    if (request.headers.authorization !== `Bearer ${API_KEY}`) {
        response.writeHead(401);
        response.end();

        return;
    }

    const injected = takeFailure(operation);

    if (injected === "timeout") {
        return;
    }

    if (injected === "server-error") {
        sendHtml(
            response,
            500,
            "<html><body>Internal Server Error</body></html>",
        );

        return;
    }

    if (injected === "rejected") {
        sendJson(
            response,
            400,
            failure("Invalid data", [
                { Name: "InvoiceValue", Error: "Mock rejection" },
            ]),
        );

        return;
    }

    if (injected === "unauthorized") {
        response.writeHead(401);
        response.end();

        return;
    }

    if (body.__invalid) {
        sendJson(response, 400, failure("The request is invalid."));

        return;
    }

    switch (operation) {
        case "GetCurrenciesExchangeList": {
            sendJson(response, 200, CURRENCY_RATES);

            return;
        }

        case "InitiatePayment": {
            sendJson(
                response,
                200,
                success({
                    PaymentMethods: PAYMENT_METHODS.map((method) => ({
                        PaymentMethodId: method.id,
                        PaymentMethodAr: method.ar,
                        PaymentMethodEn: method.en,
                        PaymentMethodCode: method.code,
                        IsDirectPayment: method.direct,
                        ServiceCharge: method.charge,
                        TotalAmount:
                            Number(body.InvoiceAmount || 0) + method.charge,
                        CurrencyIso: body.CurrencyIso || "KWD",
                        ImageUrl: `${ORIGIN}/img/${method.code}.svg`,
                        IsEmbeddedSupported: method.embedded,
                        PaymentCurrencyIso: body.CurrencyIso || "KWD",
                    })),
                }),
            );

            return;
        }

        case "InitiateSession": {
            const sessionId = crypto.randomUUID();

            state.sessions.set(sessionId, {
                id: sessionId,
                customerIdentifier: body.CustomerIdentifier ?? "",
                method: null,
                used: false,
            });

            sendJson(
                response,
                200,
                success({
                    SessionId: sessionId,
                    CountryCode: "KWT",
                    CustomerTokens: [],
                }),
            );

            return;
        }

        case "RegisterApplePayDomain": {
            const domain = String(body.DomainName ?? "");

            if (!domain || domain.includes("unverified")) {
                sendJson(
                    response,
                    400,
                    failure(
                        `The domain verification file /.well-known/apple-developer-merchantid-domain-association is not accessible for ${domain}.`,
                    ),
                );

                return;
            }

            state.domains.push(domain);

            sendJson(response, 200, success(null, "OK"));

            return;
        }

        case "ExecutePayment":
        case "SendPayment": {
            const errors = [];

            if (!(Number(body.InvoiceValue) > 0)) {
                errors.push({
                    Name: "InvoiceValue",
                    Error: "The invoice value must be greater than zero.",
                });
            }

            if (!body.CallBackUrl || !body.ErrorUrl) {
                errors.push({
                    Name: "CallBackUrl",
                    Error: "The callback URLs are required.",
                });
            }

            if (body.Language && !["en", "ar"].includes(body.Language)) {
                errors.push({
                    Name: "Language",
                    Error: "The language must be en or ar.",
                });
            }

            if (String(body.CustomerMobile ?? "").length > 11) {
                errors.push({
                    Name: "CustomerMobile",
                    Error: "The customer mobile must be at most 11 digits.",
                });
            }

            let methodCode = null;
            let source = "invoice";

            if (operation === "ExecutePayment") {
                if (body.PaymentMethodId) {
                    const method = PAYMENT_METHODS.find(
                        (entry) => entry.id === Number(body.PaymentMethodId),
                    );

                    if (!method || (method.direct && !method.embedded)) {
                        errors.push({
                            Name: "PaymentMethodId",
                            Error: "The payment method is not available.",
                        });
                    } else {
                        methodCode = method.code;
                        source = "gateway";
                    }
                } else {
                    const session = state.sessions.get(
                        String(body.SessionId ?? ""),
                    );

                    if (!session || session.used) {
                        errors.push({
                            Name: "SessionId",
                            Error: "The session is invalid or was already used.",
                        });
                    } else {
                        session.used = true;
                        methodCode = session.method ?? "vm";
                        source = "session";
                    }
                }
            }

            if (operation === "SendPayment" && !body.NotificationOption) {
                errors.push({
                    Name: "NotificationOption",
                    Error: "The notification option is required.",
                });
            }

            if (errors.length) {
                sendJson(response, 400, failure("Invalid data", errors));

                return;
            }

            const invoice = createInvoice(body, methodCode, source);
            const url =
                source === "session" && ["ap", "gp"].includes(methodCode)
                    ? `${ORIGIN}/pay/${invoice.id}/wallet`
                    : `${ORIGIN}/pay/${invoice.id}`;

            sendJson(
                response,
                200,
                success(
                    operation === "ExecutePayment"
                        ? {
                              InvoiceId: invoice.id,
                              IsDirectPayment: false,
                              PaymentURL: url,
                              CustomerReference: invoice.customerReference,
                              UserDefinedField: invoice.userDefinedField,
                              RecurringId: "",
                          }
                        : {
                              InvoiceId: invoice.id,
                              InvoiceURL: url,
                              CustomerReference: invoice.customerReference,
                              UserDefinedField: invoice.userDefinedField,
                          },
                ),
            );

            return;
        }

        case "GetPaymentStatus": {
            const key = String(body.Key ?? "");
            const invoiceId =
                body.KeyType === "PaymentId"
                    ? state.payments.get(key)
                    : Number(key);
            const invoice = state.invoices.get(invoiceId);

            if (!invoice) {
                sendJson(
                    response,
                    400,
                    failure("No data match the given key."),
                );

                return;
            }

            sendJson(response, 200, success(paymentStatus(invoice)));

            return;
        }

        case "MakeRefund": {
            const invoice = state.invoices.get(Number(body.Key));
            const amount = Number(body.Amount);

            if (!invoice || invoice.status !== "Paid") {
                sendJson(response, 400, failure("The invoice is not paid."));

                return;
            }

            if (
                !(amount > 0) ||
                amount > invoice.value - invoice.refunded + 0.0001
            ) {
                sendJson(
                    response,
                    400,
                    failure("The refund amount exceeds the paid amount."),
                );

                return;
            }

            invoice.refunded += amount;

            const refund = {
                RefundId: 9000 + state.refunds.length,
                RefundReference: `RF${invoice.id}${state.refunds.length}`,
                Key: String(invoice.id),
                Amount: amount,
                CurrencyIso: body.CurrencyIso ?? null,
                Comment: body.Comment ?? "",
            };

            state.refunds.push(refund);

            sendJson(response, 200, success(refund));

            return;
        }

        default:
            sendJson(
                response,
                404,
                failure(
                    "No HTTP resource was found that matches the request URI.",
                ),
            );
    }
}

async function handleControl(request, response, path) {
    const body = await readBody(request);

    if (path === "/__mock/reset") {
        state.invoices.clear();
        state.payments.clear();
        state.sessions.clear();
        state.refunds.length = 0;
        state.domains.length = 0;
        state.requests.length = 0;
        state.failures.length = 0;
        state.walletOutcome = "pay";

        sendJson(response, 200, { ok: true });

        return;
    }

    if (path === "/__mock/failures") {
        state.failures.push({
            mode: body.mode,
            operations: body.operations ?? [],
            times: Number(body.times ?? 1),
        });

        sendJson(response, 200, { ok: true });

        return;
    }

    if (path === "/__mock/wallet-outcome") {
        state.walletOutcome = body.outcome ?? "pay";

        sendJson(response, 200, { ok: true });

        return;
    }

    if (path === "/__mock/state") {
        sendJson(response, 200, {
            invoices: [...state.invoices.values()],
            sessions: [...state.sessions.values()],
            refunds: state.refunds,
            domains: state.domains,
            requests: state.requests,
        });

        return;
    }

    const sessionMethod = path.match(
        /^\/__mock\/sessions\/([\w-]+)\/method\/(ap|gp|vm)$/,
    );

    if (sessionMethod) {
        const session = state.sessions.get(sessionMethod[1]);

        if (session && !session.used) {
            session.method = sessionMethod[2];
        }

        sendJson(response, 200, { ok: Boolean(session) });

        return;
    }

    const settle = path.match(
        /^\/__mock\/invoices\/(\d+)\/(pay|decline|cancel|pending)$/,
    );

    if (settle) {
        const invoice = state.invoices.get(Number(settle[1]));

        if (!invoice) {
            sendJson(response, 404, { ok: false });

            return;
        }

        const paymentId = addTransaction(invoice, settle[2]);

        sendJson(response, 200, { ok: true, paymentId, invoiceId: invoice.id });

        return;
    }

    const display = path.match(/^\/__mock\/invoices\/(\d+)\/display$/);

    if (display) {
        const invoice = state.invoices.get(Number(display[1]));

        if (!invoice) {
            sendJson(response, 404, { ok: false });

            return;
        }

        invoice.displayOverride = body.value ?? null;

        sendJson(response, 200, { ok: true });

        return;
    }

    sendJson(response, 404, { ok: false });
}

function settleAndReturn(response, invoice, outcome) {
    const paymentId = addTransaction(invoice, outcome);
    const target = new URL(
        outcome === "pay" ? invoice.callBackUrl : invoice.errorUrl,
    );

    target.searchParams.set("paymentId", paymentId);
    target.searchParams.set("Id", paymentId);

    redirect(response, target.toString());
}

const server = http.createServer(async (request, response) => {
    const url = new URL(request.url, ORIGIN);
    const path = url.pathname;

    try {
        if (path === "/health") {
            sendJson(response, 200, { ok: true });

            return;
        }

        if (path.startsWith("/__mock/")) {
            await handleControl(request, response, path);

            return;
        }

        const api = path.match(/^\/v2\/(\w+)$/i);

        if (api && ["POST", "GET"].includes(request.method)) {
            await handleApi(request, response, api[1]);

            return;
        }

        if (/^\/applepay\/v\d\/applepay\.js$/.test(path)) {
            sendScript(
                response,
                walletScript("myFatoorahAP", "ap", "Apple Pay (mock)"),
            );

            return;
        }

        if (/^\/googlepay\/v\d\/googlepay\.js$/.test(path)) {
            sendScript(
                response,
                walletScript("myFatoorahGP", "gp", "Google Pay (mock)"),
            );

            return;
        }

        if (/^\/cardview\/v\d\/session\.js$/.test(path)) {
            sendScript(response, cardViewScript());

            return;
        }

        const image = path.match(/^\/img\/(\w+)\.svg$/);

        if (image) {
            response.writeHead(200, { "Content-Type": "image/svg+xml" });
            response.end(methodImage(image[1]));

            return;
        }

        const wallet = path.match(/^\/pay\/(\d+)\/wallet$/);

        if (wallet) {
            const invoice = state.invoices.get(Number(wallet[1]));

            if (!invoice) {
                sendHtml(response, 404, "<h1>Invoice not found</h1>");

                return;
            }

            settleAndReturn(response, invoice, state.walletOutcome);

            return;
        }

        const page = path.match(/^\/pay\/(\d+)$/);

        if (page) {
            const invoice = state.invoices.get(Number(page[1]));

            sendHtml(
                response,
                invoice ? 200 : 404,
                invoice ? hostedPage(invoice) : "<h1>Invoice not found</h1>",
            );

            return;
        }

        const action = path.match(
            /^\/pay\/(\d+)\/(pay|decline|cancel|pending)$/,
        );

        if (action && request.method === "POST") {
            const invoice = state.invoices.get(Number(action[1]));

            if (!invoice) {
                sendHtml(response, 404, "<h1>Invoice not found</h1>");

                return;
            }

            if (action[2] === "pending") {
                addTransaction(invoice, "pending");

                sendHtml(response, 200, hostedPage(invoice));

                return;
            }

            settleAndReturn(response, invoice, action[2]);

            return;
        }

        sendJson(response, 404, failure("Not found."));
    } catch (error) {
        sendJson(response, 500, failure(String(error)));
    }
});

server.listen(PORT, HOST, () => {
    process.stdout.write(`MyFatoorah mock listening on ${ORIGIN}\n`);
});
