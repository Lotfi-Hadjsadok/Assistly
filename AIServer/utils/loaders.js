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
      requestHandler: async ({ page, request, enqueueLinks }) => {
        console.log("Processing:", request.url);
        const content = await page.locator("body").innerText();
        docs.push({
          // pageContent: content.replace(/\s+/g, " ").trim(),
          metadata: {
            source: request.url,
          },
        });
        await enqueueLinks({
          strategy: "all",
        });
      },
    },
    new Configuration({ persistStorage: false })
  );

  await loader.run([url]);
  return docs;
};
