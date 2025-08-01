import { loadUrl } from "../utils/loaders.js";
import { splitter, shouldSplit, htmlTransformer } from "../utils/splitter.js";
import { embeddings } from "../utils/models.js";
import { sendResponse, sendError } from "../utils/sendResponse.js";
import dotenv from "dotenv";
dotenv.config();
export const embedWebsite = async (req, res) => {
  try {
    const { urls, knowledgeCredits } = req.body;
    const docs = await loadUrl(urls);

    const chunks = shouldSplit(docs)
      ? await htmlTransformer.pipe(splitter).invoke(docs)
      : docs;

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
          embedding,
        };
      })
    );
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
