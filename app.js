const express = require('express');
const multer = require('multer');
const path = require('path');
const cors = require('cors');
const app = express();
const port = 3000;

const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads');
    },
    filename: (req, file, cb) => {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, uniqueSuffix + path.extname(file.originalname));
    }
});


const fileFilter = (req, file, cb) => {
    if (file.mimetype === 'image/jpeg' || file.mimetype === 'image/png') {
        cb(null, true); 
    } else {
        cb(new Error('Invalid file type. Only JPEG and PNG files are allowed.'), false);
    }
};

const upload = multer({ storage: storage, fileFilter: fileFilter });

app.use(express.static('public'));
app.use(cors());

app.post('/upload', upload.single('file'), (req, res) => {
    console.log('File uploaded:', req.file);
    res.send(req.file.filename);
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
