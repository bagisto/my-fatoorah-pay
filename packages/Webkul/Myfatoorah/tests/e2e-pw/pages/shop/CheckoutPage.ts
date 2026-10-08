import {
    expect,
    type Locator,
    type Page,
    type Response,
} from "@playwright/test";
import fixture from "../../data/myfatoorah/fixture.json";
import { BasePage } from "../BasePage";

export type MyfatoorahMethod = "ap" | "gp" | "vm";

export class CheckoutPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async open(): Promise<Response | null> {
        return this.visit("checkout/onepage");
    }

    private input(name: string): Locator {
        return this.page.locator(`[name="billing.${name}"]`);
    }

    paymentRadio(method: string): Locator {
        return this.page.locator(
            `input[name="payment[method]"][id="${method}"]`,
        );
    }

    paymentCard(method: string): Locator {
        return this.page.locator(`label[for="${method}"]`).last();
    }

    myfatoorahMethod(code: MyfatoorahMethod): Locator {
        return this.page.locator(`label[for="myfatoorah_${code}"]`).last();
    }

    walletButton(code: "ap" | "gp"): Locator {
        return this.page.locator(`#mf-mock-${code}-button`);
    }

    get cardNumberInput(): Locator {
        return this.page.locator("#mf-mock-card-number");
    }

    get payNowButton(): Locator {
        return this.page.getByRole("button", { name: "Pay Now" });
    }

    get cancelCardButton(): Locator {
        return this.page.getByRole("button", { name: "Cancel", exact: true });
    }

    get placeOrderButton(): Locator {
        return this.page.getByRole("button", { name: "Place Order" });
    }

    async fillAddress(email: string): Promise<void> {
        await this.input("first_name").fill(fixture.address.first_name);
        await this.input("last_name").fill(fixture.address.last_name);
        await this.input("email").fill(email);
        await this.input("address.[0]").fill(fixture.address.address[0]);
        await this.input("country").selectOption(fixture.address.country);
        await this.input("state").fill(fixture.address.state);
        await this.input("city").fill(fixture.address.city);
        await this.input("postcode").fill(fixture.address.postcode);
        await this.input("phone").fill(fixture.address.phone);

        const useForShipping = this.input("use_for_shipping");

        if (!(await useForShipping.isChecked())) {
            await this.page
                .locator('label[for="use_for_shipping"]')
                .first()
                .click();
        }

        await this.page.getByRole("button", { name: "Proceed" }).click();
    }

    async chooseShipping(method = fixture.shippingMethod): Promise<void> {
        const card = this.page.locator(`label[for="${method}"]`).last();

        await card.waitFor();

        const stored = this.page.waitForResponse(
            (response) =>
                response.url().includes("checkout/onepage/shipping-methods") &&
                response.request().method() === "POST",
        );

        await card.click();

        expect((await stored).ok()).toBe(true);
    }

    async chooseMyfatoorah(): Promise<void> {
        await this.paymentCard("myfatoorah").waitFor();

        const stored = this.page.waitForResponse(
            (response) =>
                response.url().includes("checkout/onepage/payment-methods") &&
                response.request().method() === "POST",
        );

        await this.paymentCard("myfatoorah").click();

        expect((await stored).ok()).toBe(true);

        await expect(this.paymentRadio("myfatoorah")).toBeChecked();
    }

    async goToPayment(email: string): Promise<void> {
        await this.open();
        await this.fillAddress(email);
        await this.chooseShipping();
    }

    async chooseMyfatoorahMethod(code: MyfatoorahMethod): Promise<void> {
        await this.myfatoorahMethod(code).waitFor();

        const stored = this.page.waitForResponse(
            (response) =>
                response.url().includes("checkout/onepage/payment-methods") &&
                response.request().method() === "POST",
        );

        await this.myfatoorahMethod(code).click();

        expect((await stored).ok()).toBe(true);
    }
}
