import type { Locator, Page, Response } from "@playwright/test";
import { BasePage } from "../BasePage";

export type CustomerCredentials = {
    firstName: string;
    lastName: string;
    email: string;
    password: string;
};

export class AuthPage extends BasePage {
    constructor(page: Page) {
        super(page);
    }

    async openLogin(): Promise<Response | null> {
        return this.visit("customer/login");
    }

    async openRegister(): Promise<Response | null> {
        return this.visit("customer/register");
    }

    private get firstNameInput(): Locator {
        return this.page.getByPlaceholder("First Name");
    }

    private get lastNameInput(): Locator {
        return this.page.getByPlaceholder("Last Name");
    }

    private get emailInput(): Locator {
        return this.page.getByPlaceholder("email@example.com");
    }

    private get passwordInput(): Locator {
        return this.page.getByPlaceholder("Password", { exact: true });
    }

    private get confirmPasswordInput(): Locator {
        return this.page.getByPlaceholder("Confirm Password");
    }

    private get agreementCheckbox(): Locator {
        return this.page.locator("#agreement");
    }

    private get registerButton(): Locator {
        return this.page.getByRole("button", { name: "Register" });
    }

    private get signInButton(): Locator {
        return this.page.getByRole("button", { name: "Sign In" });
    }

    async isAuthenticated(): Promise<boolean> {
        await this.openLogin();

        return !this.page.url().includes("customer/login");
    }

    async ensureLoggedIn(credentials: CustomerCredentials): Promise<void> {
        if (await this.isAuthenticated()) {
            return;
        }

        await this.submitLogin(credentials.email, credentials.password);

        if (!this.page.url().includes("customer/login")) {
            return;
        }

        await this.register(credentials);
        await this.openLogin();
        await this.submitLogin(credentials.email, credentials.password);
        await this.page.waitForURL((url) => !url.pathname.endsWith("login"));
    }

    private async submitLogin(email: string, password: string): Promise<void> {
        await this.emailInput.fill(email);
        await this.passwordInput.fill(password);
        await this.signInButton.click();
        await this.page.waitForLoadState("networkidle");
    }

    private async register(credentials: CustomerCredentials): Promise<void> {
        await this.openRegister();
        await this.firstNameInput.fill(credentials.firstName);
        await this.lastNameInput.fill(credentials.lastName);
        await this.emailInput.fill(credentials.email);
        await this.passwordInput.fill(credentials.password);
        await this.confirmPasswordInput.fill(credentials.password);
        await this.acceptAgreementIfPresent();
        await this.registerButton.click();
        await this.page.waitForLoadState("networkidle");
    }

    private async acceptAgreementIfPresent(): Promise<void> {
        const agreement = this.agreementCheckbox.first();

        if ((await agreement.count()) === 0) {
            return;
        }

        if (!(await agreement.isChecked())) {
            await agreement.check({ force: true });
        }
    }
}
