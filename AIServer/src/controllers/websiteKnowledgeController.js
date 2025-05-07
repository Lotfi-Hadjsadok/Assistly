import { loadUrl } from "../utils/loaders.js";
import { splitter, shouldSplit, htmlTransformer } from "../utils/splitter.js";
import { embeddings } from "../utils/models.js";
import { sendResponse, sendError } from "../utils/sendResponse.js";

export const embedWebsite = async (req, res) => {
  try {
    const { urls } = req.body;
    console.log(urls);
    const docs = await loadUrl(urls);

    const chunks = shouldSplit(docs)
      ? await htmlTransformer.pipe(splitter).invoke(docs)
      : docs;

    chunks.map((chunk) => {
      chunk.pageContent = chunk.pageContent.replace(/\s+/g, " ").trim();
    });

    const vectors = await Promise.all(
      chunks.map(async (chunk) => {
        const embedding = await embeddings.embedQuery(chunk.pageContent);
        return {
          content: chunk.pageContent,
          metadata: chunk.metadata,
          source: chunk.metadata.source,
          embedding,
        };
      })
    );
    sendResponse(res, vectors, "Success", 200);
  } catch (error) {
    sendError(res, error, 500);
  }
};
