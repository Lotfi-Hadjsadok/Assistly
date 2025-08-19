import { loadUrl } from "../utils/loaders.js";
import { splitter, shouldSplit, htmlTransformer } from "../utils/splitter.js";
import { embeddings } from "../utils/models.js";
import { sendResponse, sendError } from "../utils/sendResponse.js";
import dotenv from "dotenv";
import { normalizeEmbedding } from "../utils/normalizer.js";
dotenv.config();
export const embedWebsite = async (req, res) => {
  try {
    const { urls, knowledgeCredits } = req.body;
    const docs = await loadUrl(urls);

    console.log(docs);
    const chunks = shouldSplit(docs)
      ? await htmlTransformer.pipe(splitter).invoke(docs)
      : docs;
    console.log(chunks);

    // Calculate total characters across all chunks for precise credit calculation
    const totalCharacters = chunks.reduce((total, chunk) => {
      return total + (chunk.pageContent ? chunk.pageContent.length : 0);
    }, 0);

    const leftCredit = knowledgeCredits - totalCharacters;

    if (leftCredit < 0) {
      return sendError(
        res,
        `Not enough credits, you need ${
          totalCharacters - knowledgeCredits
        } more credits (${totalCharacters} characters found)`,
        400
      );
    }
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
          embedding: normalizeEmbedding(embedding),
        };
      })
    );
    if (vectors.length === 0) {
      return sendError(res, "This website cannot be scraped", 400);
    }
    sendResponse(
      res,
      {
        vectors,
        leftCredit,
      },
      "Success",
      200
    );
  } catch (error) {
    sendError(res, error, 500);
  }
};
