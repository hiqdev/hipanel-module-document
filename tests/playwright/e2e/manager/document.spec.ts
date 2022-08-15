import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";

test("Test the Document page is work @hipanel-module-document @manager @document", async ({ managerPage }) => {
  await managerPage.goto("/document/document/index");
  await expect(managerPage.locator(".content-header > h1")).toContainText("Documents");
});
