import type { Locator, Page } from "@playwright/test";
import { BasePage } from "../../BasePage";

export class ErrorPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    get title(): Locator {
        return this.page.getByText("Payment Error", { exact: true }).first();
    }

    message(text: string | RegExp): Locator {
        return this.page.getByText(text).first();
    }

    get backToCart(): Locator {
        return this.page.getByRole("link", { name: "Back to Cart" });
    }
}
