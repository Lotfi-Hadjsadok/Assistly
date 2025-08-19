import { PDFLoader } from "@langchain/community/document_loaders/fs/pdf";
import { DocxLoader } from "@langchain/community/document_loaders/fs/docx";
import { CSVLoader } from "@langchain/community/document_loaders/fs/csv";
import { TextLoader } from "langchain/document_loaders/fs/text";
import fs from "fs/promises";
import { embeddings } from "../utils/models.js";
import { splitter, shouldSplit } from "../utils/splitter.js";
import { sendResponse, sendError } from "../utils/sendResponse.js";
import dotenv from "dotenv";
import { normalizeEmbedding } from "../utils/normalizer.js";
dotenv.config();
export const embedDocument = async (req, res) => {
  try {
    const file = req.file;
    let loader;
    const { knowledgeCredits } = req.body;
    const ext = file.originalname.split(".").pop().toLowerCase();
    switch (ext) {
      case "pdf":
        loader = new PDFLoader(file.path);
        break;
      case "doc":
      case "docx":
        loader = new DocxLoader(file.path, {
          type: ext === "doc" ? "doc" : "docx",
        });
        break;
      case "csv":
        loader = new CSVLoader(file.path);
        break;
      case "txt":
        loader = new TextLoader(file.path);
        break;
      default:
        await fs.unlink(file.path);
        return sendError(res, "Unsupported file type", 400);
    }

    const docs = await loader.load();
    await fs.unlink(file.path);

    const chunks = shouldSplit(docs, ext)
      ? await splitter.splitDocuments(docs)
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
    const vectors = await Promise.all(
      chunks.map(async (chunk) => {
        const embedding = await embeddings.embedQuery(chunk.pageContent);
        return {
          content: chunk.pageContent,
          metadata: chunk.metadata,
          source: file.originalname,
          embedding: normalizeEmbedding(embedding),
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
    await fs.unlink(file.path);
    sendError(res, error, 500);
    console.log(error);
  }
};
