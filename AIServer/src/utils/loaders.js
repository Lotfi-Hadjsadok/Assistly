import { PlaywrightWebBaseLoader } from "@langchain/community/document_loaders/web/playwright";

export async function loadUrl(urls) {
  const docs = [];
  console.log(urls);
  urls.forEach((url) => {
    console.log(url);
  });

  for (const pageUrl of urls) {
    try {
      const loader = new PlaywrightWebBaseLoader(pageUrl, {
        launchOptions: {
          args: ["--no-sandbox", "--disable-setuid-sandbox"],
          executablePath: process.env.CHROMIUM_PATH,
        },
        evaluate: (page, browser, response) => {
          if (response.status() !== 200) {
            page.close();
            browser.close();
          } else {
            return page.content();
          }
        },
      });

      const loadedDocs = await loader.load();

      for (const doc of loadedDocs) {
        docs.push({
          pageContent: doc.pageContent,
          metadata: {
            source: pageUrl,
          },
        });
      }
    } catch (err) {
      console.warn(`Error loading ${pageUrl}: ${err.message}`);
    }
  }

  return docs;
}
