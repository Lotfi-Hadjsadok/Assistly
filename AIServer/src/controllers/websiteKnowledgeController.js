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

    const leftCredit =
      knowledgeCredits -
      chunks.length * parseInt(process.env.KNOWLEDGE_CHUNK_SIZE);

    console.log(leftCredit);
    if (leftCredit < 0) {
      return sendError(
        res,
        `Not enough credits, you need ${
          chunks.length * parseInt(process.env.KNOWLEDGE_CHUNK_SIZE) -
          knowledgeCredits
        } more credits`,
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
