import type { Locator, Page, Response } from "@playwright/test";
import { BasePage } from "../../BasePage";

export type ToggleField =
    | "status"
    | "test_mode"
    | "save_card"
    | "is_webhook_enabled"
    | "register_apple_pay";

export type TextField = "api_key" | "webhook_secret_key";

export class MyfatoorahConfigurationPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async open(): Promise<Response | null> {
        return this.visit("admin/configuration/sales/payment_methods");
    }

    private fieldName(field: string): string {
        return `sales[payment_methods][myfatoorah][${field}]`;
    }

    field(field: string): Locator {
        return this.page.locator(`[name="${this.fieldName(field)}"]`).first();
    }

    get saveButton(): Locator {
        return this.page.getByRole("button", { name: "Save Configuration" });
    }

    toggle(field: ToggleField): Locator {
        return this.page.locator(
            `input[type="checkbox"][name="${this.fieldName(field)}"]`,
        );
    }

    private toggleSwitch(field: ToggleField): Locator {
        return this.page.locator(
            `label:has(input[type="checkbox"][name="${this.fieldName(field)}"])`,
        );
    }

    async setToggle(field: ToggleField, enabled: boolean): Promise<void> {
        if ((await this.toggle(field).isChecked()) !== enabled) {
            await this.toggleSwitch(field).click();
        }
    }

    get countrySelect(): Locator {
        return this.page.locator(
            `select[name="${this.fieldName("country_iso")}"]`,
        );
    }

    secret(field: TextField): Locator {
        return this.page.locator(`input[name="${this.fieldName(field)}"]`);
    }

    get webhookUrlHint(): Locator {
        return this.page.getByText(/\/myfatoorah\/webhook/).first();
    }

    async save(): Promise<void> {
        await Promise.all([
            this.page.waitForResponse(
                (response) =>
                    response.request().method() === "POST" &&
                    response.url().includes("admin/configuration"),
            ),
            this.saveButton.click(),
        ]);

        await this.page.waitForLoadState("domcontentloaded");
    }
}
