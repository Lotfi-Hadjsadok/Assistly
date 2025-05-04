import { RecursiveCharacterTextSplitter } from "@langchain/textsplitters";

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
