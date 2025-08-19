export const normalizeEmbedding = (embedding) => {
  const magnitude = Math.sqrt(
    embedding.reduce((sum, val) => sum + val * val, 0)
  );

  const normalizedEmbedding = embedding.map((val) => val / magnitude);

  return normalizedEmbedding;
};
