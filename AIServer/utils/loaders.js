import { PuppeteerWebBaseLoader } from "@langchain/community/document_loaders/web/puppeteer";

export const loadUrl = async (url) => {
  const loader = new PuppeteerWebBaseLoader(url, {
    evaluate: async (page) => {
      return await page.evaluate(() => {
        return document.body.innerText.replace(/\s+/g, " ").trim();
      });
    },
    launchOptions: {
      executablePath: process.env.CHROMIUM_PATH,
      args: ["--no-sandbox", "--disable-setuid-sandbox"],
    },
  });
  const docs = await loader.load();
  return docs;
};
