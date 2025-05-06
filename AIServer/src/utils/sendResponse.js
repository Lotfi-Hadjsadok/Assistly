export const sendResponse = (res, data, message = "Success", status = 200) => {
  res.status(status).json({
    success: true,
    message,
    data,
  });
};

export const sendError = (res, error, status = 500) => {
  res.status(status).json({
    success: false,
    message: error.message || "Internal Server Error",
  });
};
