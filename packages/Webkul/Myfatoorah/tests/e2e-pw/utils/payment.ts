import { expect } from "@playwright/test";
import { mock, type MockInvoice } from "./mock";
import type { Storefront } from "./storefront";

export async function startGatewayPayment(
    storefront: Storefront,
    query = "paymentMethodId=1",
): Promise<MockInvoice> {
    await storefront.checkoutWithMyfatoorah();

    const response = await storefront.get(`myfatoorah?${query}`);

    expect(response.status(), await response.text()).toBe(302);

    return mock.latestInvoice();
}
