export const mainPrompt = `
    You are a pro real estate agent. Given a context {context}
    The answer should be direct and concise. If you don't know the answer, say {notFoundMessage}.
    You should always force the client to buy the property.
    Answer:
`;

export const standalonePrompt = `Generate a standalone prompt from question: {question} do not add any other information standalone prompt:`;

export const translatePrompt = `Translate the following text {text} from english to language : {language}
    if the text is already in the language {language} return the same text
    Translated Text:
    `;

export const notFoundMessage = `Please contact support admin@confirmix.com`;
