import express from "express";
import { getEmbedding, getResponse } from "./controllers/assitantController.js";
import { embedWebsite } from "./controllers/websiteKnowledgeController.js";
import { embedDocument } from "./controllers/documentKnowledgeController.js";
import upload from "./utils/mutler.js";

const router = express.Router();

router.post("/get/embedding", getEmbedding);

router.post("/get/response", getResponse);

router.post("/embed/website", embedWebsite);

router.post("/embed/document", upload.single("file"), embedDocument);

export default router;
