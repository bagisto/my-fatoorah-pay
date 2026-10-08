import type { Page } from "@playwright/test";

export async function emulateApplePayDevice(page: Page): Promise<void> {
    await page.addInitScript(() => {
        Object.defineProperty(window, "ApplePaySession", {
            configurable: true,
            value: { canMakePayments: () => true },
        });
    });
}

export type WalletInit = {
    method: string;
    sessionId: string;
    amount?: string;
    currencyCode?: string;
    countryCode?: string;
};

export async function walletInits(page: Page): Promise<WalletInit[]> {
    return page.evaluate(
        () =>
            (
                window as unknown as {
                    __myfatoorahMock?: { inits: WalletInit[] };
                }
            ).__myfatoorahMock?.inits ?? [],
    );
}
