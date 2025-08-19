# AI Assistant Server

A sophisticated AI assistant server built with Node.js, Express, and LangChain that provides intelligent conversation capabilities with knowledge base integration.

## Features

### 🤖 Enhanced AI Capabilities
- **Intelligent Context Analysis**: Automatically determines if questions need specific context or can be answered with general knowledge
- **Multi-language Support**: Built-in translation capabilities for multiple languages
- **Conversation Memory**: Smart conversation history management with relevance scoring
- **Advanced Prompting**: Sophisticated prompt engineering for better responses

### 📚 Knowledge Management
- **Document Processing**: Support for PDF, DOC, DOCX, CSV, and TXT files
- **Website Crawling**: Intelligent web content extraction with Playwright
- **Text Processing**: Advanced text splitting and cleaning for optimal knowledge storage
- **Credit System**: Character-based credit management for resource control

### 🔧 Technical Improvements
- **Better Error Handling**: Comprehensive error management with detailed logging
- **Input Validation**: Robust validation for all API endpoints
- **Performance Optimization**: Efficient text processing and embedding generation
- **Modular Architecture**: Clean, maintainable code structure

## API Endpoints

### POST `/get/embedding`
Generate embeddings for text queries.

**Request Body:**
```json
{
  "query": "Your text to embed"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Success",
  "data": [0.1, 0.2, ...],
  "timestamp": "2024-01-01T00:00:00.000Z"
}
```

### POST `/get/response`
Get AI responses with context awareness.

**Request Body:**
```json
{
  "query": "Your question",
  "vectors": [
    {
      "content": "Context content",
      "embedding": [0.1, 0.2, ...]
    }
  ],
  "language": "en",
  "memory": [
    {
      "role": "user",
      "content": "Previous message",
      "timestamp": "2024-01-01T00:00:00.000Z"
    }
  ]
}
```

**Response:**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "response": "AI response",
    "memory": [...],
    "analysis": "STANDALONE|NEEDS_CONTEXT|NEEDS_CLARIFICATION",
    "hasContext": true
  },
  "timestamp": "2024-01-01T00:00:00.000Z"
}
```

### POST `/embed/website`
Process and embed website content.

**Request Body:**
```json
{
  "urls": ["https://example.com"],
  "knowledgeCredits": 10000
}
```

### POST `/embed/document`
Process and embed document files.

**Request Body:**
```form-data
file: [PDF/DOC/DOCX/CSV/TXT file]
knowledgeCredits: 10000
```

## Environment Variables

```env
OPENAI_API_KEY=your_openai_api_key
CHROMIUM_PATH=/path/to/chromium
KNOWLEDGE_CHUNK_SIZE=1000
KNOWLEDGE_CHUNK_OVERLAP=200
NODE_ENV=development
```

## Key Improvements Made

### 1. **Enhanced Prompts**
- More sophisticated system prompts with clear guidelines
- Better context handling and conversation flow
- Improved translation prompts for accuracy
- Standalone question analysis for better response routing

### 2. **Improved Model Configuration**
- Multiple specialized models for different tasks
- Optimized temperature settings for each use case
- Better token management and response length control
- Latest model versions for improved performance

### 3. **Advanced Conversation Management**
- Smart conversation history with relevance scoring
- Automatic memory cleanup and validation
- Context-aware conversation flow
- Better message formatting for LangChain

### 4. **Robust Error Handling**
- Comprehensive input validation
- Detailed error logging and reporting
- Graceful failure handling
- Better user feedback

### 5. **Enhanced Text Processing**
- Improved HTML content extraction
- Better text splitting strategies
- Content cleaning and normalization
- Optimized chunk processing

### 6. **Better API Design**
- Consistent response formatting
- Detailed success/error responses
- Timestamp tracking
- Development-friendly error details

## Usage Examples

### Basic Conversation
```javascript
const response = await fetch('/get/response', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    query: "What is machine learning?",
    vectors: [],
    language: "en",
    memory: []
  })
});
```

### Knowledge-Based Question
```javascript
const response = await fetch('/get/response', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    query: "What does the document say about AI?",
    vectors: [/* your knowledge vectors */],
    language: "en",
    memory: [/* conversation history */]
  })
});
```

## Architecture

```
src/
├── controllers/
│   ├── assitantController.js    # Main AI conversation logic
│   ├── documentKnowledgeController.js  # Document processing
│   └── websiteKnowledgeController.js   # Website crawling
├── utils/
│   ├── models.js               # AI model configurations
│   ├── prompts.js              # Prompt templates
│   ├── conversationManager.js   # Conversation handling
│   ├── splitter.js             # Text processing
│   ├── loaders.js              # Document/URL loading
│   └── sendResponse.js         # Response formatting
└── router.js                   # API routing
```

## Performance Optimizations

- **Efficient Text Processing**: Optimized chunking and cleaning
- **Smart Caching**: Conversation history management
- **Parallel Processing**: Concurrent embedding generation
- **Resource Management**: Credit-based processing limits
- **Error Recovery**: Graceful handling of failures

## Security Features

- **Input Validation**: Comprehensive request validation
- **File Type Checking**: Secure document processing
- **Error Sanitization**: Safe error message handling
- **Resource Limits**: Credit-based access control

This improved AI assistant provides a robust, scalable, and intelligent conversation system with advanced knowledge management capabilities. 