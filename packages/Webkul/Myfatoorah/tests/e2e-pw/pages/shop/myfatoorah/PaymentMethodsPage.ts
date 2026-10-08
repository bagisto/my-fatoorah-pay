import type { Locator, Page } from "@playwright/test";
import { BasePage } from "../../BasePage";

export class PaymentMethodsPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async waitUntilOpen(): Promise<void> {
        await this.page.waitForURL("**/myfatoorah/checkout");
    }

    get gateways(): Locator {
        return this.page.locator(".mf-card-container");
    }

    gateway(name: string): Locator {
        return this.gateways.filter({ hasText: name }).first();
    }

    get applePayElement(): Locator {
        return this.page.locator("#mf-ap-element");
    }

    get backToCart(): Locator {
        return this.page.locator("a.mf-back-link");
    }
}
