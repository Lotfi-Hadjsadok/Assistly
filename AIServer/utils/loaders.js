import { PlaywrightCrawler, Configuration } from "crawlee";

export const loadUrl = async (url) => {
  let docs = [];

  const loader = new PlaywrightCrawler(
    {
      launchContext: {
        launchOptions: {
          args: ["--no-sandbox", "--disable-setuid-sandbox"],
          executablePath: process.env.CHROMIUM_PATH,
        },
      },
      maxRequestsPerCrawl: 10,
      requestHandler: async ({ page, request }) => {
        const content = await page.locator("body").innerHTML();
        docs.push({
          pageContent: content,
          metadata: {
            source: request.url,
          },
        });
      },
    },
    new Configuration({ persistStorage: false })
  );

  await loader.run([url]);

  return docs;
};
