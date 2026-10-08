import fs from "fs";
import path from "path";
import fixture from "../data/myfatoorah/fixture.json";
import { STATE_DIR_PATH, ensureStateDir } from "./paths";

export type CustomerIdentity = {
    firstName: string;
    lastName: string;
    email: string;
    password: string;
};

export type RunState = {
    runId: string;
    customers: Record<string, CustomerIdentity>;
    orders: Record<string, { orderId: string; incrementId: string }>;
};

const STATE_PATH = path.join(STATE_DIR_PATH, "myfatoorah-run.json");

export function startRun(): RunState {
    const state: RunState = {
        runId: Date.now().toString(36),
        customers: {},
        orders: {},
    };

    ensureStateDir();
    fs.writeFileSync(STATE_PATH, JSON.stringify(state, null, 4));

    return state;
}

export function readRun(): RunState {
    if (!fs.existsSync(STATE_PATH)) {
        throw new Error(
            `[e2e-pw] Missing ${STATE_PATH}. The admin-setup project must run first.`,
        );
    }

    return JSON.parse(fs.readFileSync(STATE_PATH, "utf-8")) as RunState;
}

function writeRun(state: RunState): void {
    ensureStateDir();
    fs.writeFileSync(STATE_PATH, JSON.stringify(state, null, 4));
}

export function customer(role: string): CustomerIdentity {
    const state = readRun();

    if (!state.customers[role]) {
        const [localPart, domain] = fixture.customer.email.split("@");

        state.customers[role] = {
            ...fixture.customer,
            email: `${localPart}+${role}-${state.runId}@${domain}`,
        };

        writeRun(state);
    }

    return state.customers[role];
}

export function rememberOrder(
    key: string,
    order: { orderId: string; incrementId: string },
): void {
    const state = readRun();

    state.orders[key] = order;

    writeRun(state);
}

export function rememberedOrder(key: string): {
    orderId: string;
    incrementId: string;
} {
    const order = readRun().orders[key];

    if (!order) {
        throw new Error(`[e2e-pw] No order was remembered under "${key}".`);
    }

    return order;
}
