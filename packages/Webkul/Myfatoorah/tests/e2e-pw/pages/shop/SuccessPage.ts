import type { Locator, Page } from "@playwright/test";
import { BasePage } from "../BasePage";

export class SuccessPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async waitUntilOpen(): Promise<void> {
        await this.page.waitForURL("**/checkout/onepage/success");
    }

    get heading(): Locator {
        return this.page.getByText("Thank you for your order!").first();
    }

    get orderLink(): Locator {
        return this.page.locator('a[href*="customer/account/orders/view/"]');
    }

    async order(): Promise<{ orderId: string; incrementId: string }> {
        const href = (await this.orderLink.getAttribute("href")) ?? "";

        return {
            orderId: href.split("/").pop() ?? "",
            incrementId: (await this.orderLink.innerText()).trim(),
        };
    }
}
