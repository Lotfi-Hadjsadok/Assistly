import { embeddings, model } from "../utils/models.js";
import {
  mainPrompt,
  notFoundMessage,
  standalonePrompt,
  translatePrompt,
} from "../utils/prompts.js";
import { PromptTemplate } from "@langchain/core/prompts";
import { RunnableSequence } from "@langchain/core/runnables";
import { StringOutputParser } from "@langchain/core/output_parsers";
import { sendResponse, sendError } from "../utils/sendResponse.js";

export const getEmbedding = async (req, res) => {
  try {
    const { query } = req.body;
    const embedding = await embeddings.embedQuery(query);
    sendResponse(res, embedding, "Success", 200);
  } catch (error) {
    sendError(res, error);
  }
};

export const getResponse = async (req, res) => {
  try {
    const { query, vectors, language } = req.body;

    const context = vectors.map((v) => v).join("\n");

    const promptTemplate = PromptTemplate.fromTemplate(mainPrompt);

    const standalonePromptTemplate =
      PromptTemplate.fromTemplate(standalonePrompt);

    const standaloneChain = RunnableSequence.from([
      standalonePromptTemplate,
      model,
      new StringOutputParser(),
    ]);

    const translatePromptTemplate =
      PromptTemplate.fromTemplate(translatePrompt);

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
      notFoundMessage: notFoundMessage,
      context,
      language,
    });

    sendResponse(res, response, "Success", 200);
  } catch (error) {
    console.log(error);
    sendError(res, error);
  }
};
