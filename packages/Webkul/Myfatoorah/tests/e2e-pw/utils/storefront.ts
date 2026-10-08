import { expect, type APIResponse, type Page } from "@playwright/test";
import fixture from "../data/myfatoorah/fixture.json";

export type CheckoutOptions = {
    productId?: number;
    quantity?: number;
    email?: string;
};

export class Storefront {
    constructor(private readonly page: Page) {}

    async headers(): Promise<Record<string, string>> {
        let cookie = (await this.page.context().cookies()).find(
            (entry) => entry.name === "XSRF-TOKEN",
        );

        if (!cookie) {
            await this.page.goto("");

            cookie = (await this.page.context().cookies()).find(
                (entry) => entry.name === "XSRF-TOKEN",
            );
        }

        if (!cookie) {
            throw new Error(
                "[e2e-pw] The storefront set no XSRF-TOKEN cookie.",
            );
        }

        return {
            "X-XSRF-TOKEN": decodeURIComponent(cookie.value),
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        };
    }

    async post(path: string, data: unknown = {}): Promise<APIResponse> {
        return this.page.request.post(path, {
            headers: await this.headers(),
            data,
        });
    }

    async get(path: string): Promise<APIResponse> {
        return this.page.request.get(path, {
            headers: await this.headers(),
            maxRedirects: 0,
        });
    }

    async addToCart(
        productId = fixture.product.id,
        quantity = 1,
    ): Promise<void> {
        const response = await this.post("api/checkout/cart", {
            product_id: productId,
            quantity,
            is_buy_now: 0,
        });

        expect(response.ok(), await response.text()).toBe(true);
    }

    async fillCheckout(email: string): Promise<void> {
        const address = await this.post("api/checkout/onepage/addresses", {
            billing: { ...fixture.address, email, use_for_shipping: true },
        });

        expect(address.ok(), await address.text()).toBe(true);

        const shipping = await this.post(
            "api/checkout/onepage/shipping-methods",
            { shipping_method: fixture.shippingMethod },
        );

        expect(shipping.ok(), await shipping.text()).toBe(true);

        const payment = await this.post(
            "api/checkout/onepage/payment-methods",
            {
                payment: { method: "myfatoorah" },
            },
        );

        expect(payment.ok(), await payment.text()).toBe(true);
    }

    async placeOrder(): Promise<string> {
        const response = await this.post("api/checkout/onepage/orders");

        expect(response.ok(), await response.text()).toBe(true);

        const body = await response.json();

        expect(body.data.redirect).toBe(true);

        return body.data.redirect_url as string;
    }

    async checkoutWithMyfatoorah(
        options: CheckoutOptions = {},
    ): Promise<string> {
        await this.addToCart(
            options.productId ?? fixture.product.id,
            options.quantity ?? 1,
        );

        await this.fillCheckout(
            options.email ?? `guest+${Date.now().toString(36)}@example.com`,
        );

        return this.placeOrder();
    }
}
