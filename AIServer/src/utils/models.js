import { ChatOpenAI, OpenAIEmbeddings } from "@langchain/openai";

// Main model for conversation and reasoning
export const model = new ChatOpenAI({
  model: "gpt-4.1-nano", // Using the latest and most cost-effective model
  temperature: 0.7, // Balanced creativity and accuracy
  maxTokens: 2000, // Reasonable response length
  apiKey: process.env.OPENAI_API_KEY,
});
// Embeddings model
export const embeddings = new OpenAIEmbeddings({
  model: "text-embedding-3-small", // Using the latest embedding model
  apiKey: process.env.OPENAI_API_KEY,
});
