import type { Locator, Page, Response } from "@playwright/test";
import { BasePage } from "../../BasePage";

export class OrderViewPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async open(orderId: string): Promise<Response | null> {
        return this.visit(`admin/sales/orders/view/${orderId}`);
    }

    text(content: string): Locator {
        return this.page
            .getByText(content, { exact: true })
            .filter({ visible: true })
            .first();
    }

    async refundAll(): Promise<void> {
        await this.page
            .getByText("Refund", { exact: true })
            .filter({ visible: true })
            .first()
            .click();

        const submit = this.page.getByRole("button", {
            name: "Refund",
            exact: true,
        });

        await submit.waitFor();

        await Promise.all([
            this.page.waitForResponse(
                (response) =>
                    response.request().method() === "POST" &&
                    response.url().includes("/admin/sales/refunds/create/"),
            ),
            submit.click(),
        ]);

        await this.page.waitForLoadState("domcontentloaded");
    }
}
