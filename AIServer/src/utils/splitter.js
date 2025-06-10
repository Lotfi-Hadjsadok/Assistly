import { RecursiveCharacterTextSplitter } from "@langchain/textsplitters";
import { HtmlToTextTransformer } from "@langchain/community/document_transformers/html_to_text";
import dotenv from "dotenv";
dotenv.config();

export const splitter = new RecursiveCharacterTextSplitter({
  chunkSize: process.env.KNOWLEDGE_CHUNK_SIZE,
  chunkOverlap: process.env.KNOWLEDGE_CHUNK_OVERLAP,
});

export const shouldSplit = (docs, ext = null) => {
  if (ext === "csv") {
    return false;
  }
  return true;
};

export const htmlTransformer = new HtmlToTextTransformer({
  selectors: [
    {
      selector: "a",
      options: {
        ignoreHref: true,
      },
    },
    {
      selector: "img",
      format: "skip",
      options: {
        ignoreHref: true,
      },
    },
  ],
});
