import express from "express";
import { loadUrl } from "./utils/loaders.js";
import { splitter, shouldSplit, htmlTransformer } from "./utils/splitter.js";
import { embeddings, model } from "./utils/models.js";
import { PromptTemplate } from "@langchain/core/prompts";
import dotenv from "dotenv";
import { RunnableSequence } from "@langchain/core/runnables";
import { StringOutputParser } from "@langchain/core/output_parsers";
import { PDFLoader } from "@langchain/community/document_loaders/fs/pdf";
import { DocxLoader } from "@langchain/community/document_loaders/fs/docx";
import { TextLoader } from "langchain/document_loaders/fs/text";
import { CSVLoader } from "@langchain/community/document_loaders/fs/csv";

import fs from "fs/promises";
import multer from "multer";

const upload = multer({ dest: "uploads/" });

dotenv.config();
const app = express();

app.listen(3000, () => {
  console.log("Server is running on port 3000");
});

const router = express.Router();

router.post("/get/embedding", async (req, res) => {
  const { query } = req.body;
  const embedding = await embeddings.embedQuery(query);
  res.json(embedding);
});

router.post("/get/response", async (req, res) => {
  const { query, vectors, language } = req.body;

  const context = vectors.map((v) => v).join("\n");

  const prompt = `You are a helpful assistant. Given a context, answer the following question:
  
  Question: {query}
  Context:
  {context}
  
  The answer should be direct and concise. If you don't know the answer, say {notFoundMessage}.
  
  Answer:
  `;

  const promptTemplate = PromptTemplate.fromTemplate(prompt);

  const standalonePrompt =
    "Generate a standalone prompt from question: {question} do not add any other information standalone prompt:";
  const standalonePromptTemplate =
    PromptTemplate.fromTemplate(standalonePrompt);

  const standaloneChain = standalonePromptTemplate
    .pipe(model)
    .pipe(new StringOutputParser());

  const translatePrompt = `Translate the following text {text} from english to language : {language}
  if the text is already in the language {language} return the same text
  Translated Text:
  `;

  const translatePromptTemplate = PromptTemplate.fromTemplate(translatePrompt);

  const translateChain = RunnableSequence.from([
    translatePromptTemplate,
    model,
    new StringOutputParser(),
  ]);

  const answerChain = RunnableSequence.from([
    promptTemplate,
    model,
    new StringOutputParser(),
  ]);

  const chain = RunnableSequence.from([
    {
      query: standaloneChain,
      context: (input) => input.context,
      notFoundMessage: (input) => input.notFoundMessage,
      language: (input) => input.language,
    },
    {
      text: answerChain,
      language: (input) => input.language,
    },
    async (input) => {
      if (input.language === "en") {
        return input.text;
      } else {
        return translateChain.invoke({
          text: input.text,
          language: input.language,
        });
      }
    },
    new StringOutputParser(),
  ]);

  const response = await chain.invoke({
    question: query,
    notFoundMessage: "Please contact support admin@confirmix.com",
    context,
    language,
  });

  res.json(response);
});

router.post("/embed/website", async (req, res) => {
  const { url } = req.body;
  const docs = await loadUrl(url);

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
  res.json({ vectors });
});

router.post("/embed/document", upload.single("file"), async (req, res) => {
  const file = req.file;
  let loader;

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
      return res.status(400).json({ error: "Unsupported file type" });
  }

  try {
    const docs = await loader.load();
    await fs.unlink(file.path);

    const chunks = shouldSplit(docs, ext)
      ? await splitter.splitDocuments(docs)
      : docs;
    const vectors = await Promise.all(
      chunks.map(async (chunk) => {
        const embedding = await embeddings.embedQuery(chunk.pageContent);
        return {
          content: chunk.pageContent,
          metadata: chunk.metadata,
          source: file.originalname,
          embedding,
        };
      })
    );
    res.json({ vectors });
  } catch (error) {
    await fs.unlink(file.path);
    res.status(500).json({ error: "Failed to process document" });
  }
});

app.use(express.json());
app.use("/api/v1", router);
