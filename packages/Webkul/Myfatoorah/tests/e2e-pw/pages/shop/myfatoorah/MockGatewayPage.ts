import type { Locator, Page } from "@playwright/test";
import { env } from "../../../utils/env";
import type { MockOutcome } from "../../../utils/mock";
import { BasePage } from "../../BasePage";

export class MockGatewayPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async waitUntilOpen(): Promise<void> {
        await this.page.waitForURL(`${env.mockUrl}/pay/**`);
    }

    get invoiceId(): Locator {
        return this.page.locator("#mf-mock-invoice");
    }

    get amount(): Locator {
        return this.page.locator("#mf-mock-amount");
    }

    async complete(outcome: Exclude<MockOutcome, "pending">): Promise<string> {
        const returned = this.page.waitForRequest(
            (request) =>
                request.isNavigationRequest() &&
                /\/myfatoorah\/(callback|error)$/.test(
                    new URL(request.url()).pathname,
                ),
        );

        await this.page.locator(`#mf-mock-${outcome}`).click();

        const returnUrl = (await returned).url();

        await this.page.waitForURL((url) => !url.href.startsWith(env.mockUrl));
        await this.page.waitForLoadState("domcontentloaded");

        return returnUrl;
    }
}
