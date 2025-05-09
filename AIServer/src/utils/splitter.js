import { RecursiveCharacterTextSplitter } from "@langchain/textsplitters";
import { HtmlToTextTransformer } from "@langchain/community/document_transformers/html_to_text";
export const splitter = new RecursiveCharacterTextSplitter({
  chunkSize: 1000,
  chunkOverlap: 100,
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
