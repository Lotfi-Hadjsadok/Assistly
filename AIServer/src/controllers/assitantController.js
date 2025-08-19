import { embeddings, model } from "../utils/models.js";
import {
  chatTemplate,
  contextChatTemplate,
  standaloneChatTemplate,
} from "../utils/prompts.js";
import { RunnableSequence } from "@langchain/core/runnables";
import { StringOutputParser } from "@langchain/core/output_parsers";
import { sendResponse, sendError } from "../utils/sendResponse.js";

export const getEmbedding = async (req, res) => {
  try {
    const { query } = req.body;

    if (!query || typeof query !== "string") {
      return sendError(res, "Query is required and must be a string", 400);
    }

    const embedding = await embeddings.embedQuery(query);
    sendResponse(res, embedding, "Success", 200);
  } catch (error) {
    console.error("Embedding error:", error);
    sendError(res, "Failed to generate embedding", 500);
  }
};

export const getResponse = async (req, res) => {
  try {
    const { query, chatbot, vectors, language = "en", memory = [] } = req.body;

    // Determine if context is needed based on vectors presence and content
    let hasContext = true;

    let response;

    const standaloneSequence = RunnableSequence.from([
      standaloneChatTemplate,
      model,
      new StringOutputParser(),
    ]);

    const standaloneResponse = await standaloneSequence.invoke({
      query,
      memory,
    });

    if (standaloneResponse === "NEEDS_CONTEXT") {
      hasContext = true;
    } else {
      hasContext = false;
    }

    if (hasContext) {
      // Use context template when vectors are provided
      const contextSequence = RunnableSequence.from([
        contextChatTemplate,
        model,
        new StringOutputParser(),
      ]);
      response = await contextSequence.invoke({
        query,
        memory,
        context: vectors.join("\n\n"),
        name: chatbot?.name || "Assistant",
        not_found: "Contact support.",
      });
    } else {
      // Use regular template when no context is provided
      const regularSequence = RunnableSequence.from([
        chatTemplate,
        model,
        new StringOutputParser(),
      ]);

      response = await regularSequence.invoke({
        query,
        memory,
        name: chatbot?.name || "Assistant",
        not_found: "Contact support.",
      });
    }

    sendResponse(res, response, "Success", 200);
  } catch (error) {
    console.error("Response generation error:", error);
    sendError(res, "Failed to generate response", 500);
  }
};
