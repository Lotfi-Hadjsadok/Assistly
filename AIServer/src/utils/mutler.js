import multer from "multer";

const upload = multer({ dest: "storage/uploads" });

export default upload;
