import express from "express";
import { loadUrl } from "./utils/loaders.js";
import { splitter } from "./utils/splitter.js";
import { embeddings, model } from "./utils/models.js";
import { PromptTemplate } from "@langchain/core/prompts";
import dotenv from "dotenv";
import {
  RunnablePassthrough,
  RunnableSequence,
} from "@langchain/core/runnables";
import { StringOutputParser } from "@langchain/core/output_parsers";
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

  console.log(vectors);

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

router.post("/embed", async (req, res) => {
  console.log(req.body);
  const { url } = req.body;
  const docs = await loadUrl(url);

  const chunks = await splitter.splitDocuments(docs);

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

app.use(express.json());
app.use("/api/v1", router);
