const express = require('express');
const multer = require('multer');
const path = require('path');
const cors = require('cors'); // Import the cors package
const app = express();
const port = 3000;


// Configure multer to handle file uploads
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads'); // Upload directory
    },
    filename: (req, file, cb) => {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, uniqueSuffix + path.extname(file.originalname)); // Use a unique filename
    }
});
const upload = multer({ storage: storage });

// Serve static files
app.use(express.static('public'));
app.use(cors());
// Handle file upload
app.post('/upload', upload.single('file'), (req, res) => {
    console.log('File uploaded:', req.file);
    res.send(req.file.filename);
});

// Start the server
app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
