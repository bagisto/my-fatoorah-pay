import type { Locator, Page, Response } from "@playwright/test";
import { BasePage } from "../../BasePage";

export class MapApplePayPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async open(): Promise<Response | null> {
        return this.visit("admin/myfatoorah/map-apple-pay");
    }

    get heading(): Locator {
        return this.page.getByText("Map Apple Pay", { exact: true }).first();
    }

    get menuLink(): Locator {
        return this.page
            .locator('a[href$="/admin/myfatoorah/map-apple-pay"]')
            .first();
    }

    get domainInput(): Locator {
        return this.page.locator('input[name="domain"]');
    }

    async register(domain: string): Promise<void> {
        await this.domainInput.fill(domain);

        await this.page.getByRole("button", { name: "Save" }).click();
    }
}
