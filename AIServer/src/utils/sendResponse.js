export const sendResponse = (res, data, message = "Success", status = 200) => {
  res.status(status).json({
    success: true,
    message,
    data,
    timestamp: new Date().toISOString(),
  });
};

export const sendError = (res, error, status = 500) => {
  const errorMessage = error?.message || error || "Internal Server Error";
  const errorDetails = error?.stack ? error.stack.split("\n")[0] : null;

  console.error(`API Error (${status}):`, {
    message: errorMessage,
    details: errorDetails,
    timestamp: new Date().toISOString(),
  });

  res.status(status).json({
    success: false,
    message: errorMessage,
    error: process.env.NODE_ENV === "development" ? errorDetails : undefined,
    timestamp: new Date().toISOString(),
  });
};
