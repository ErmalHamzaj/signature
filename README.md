# Digital Agreement Form

A web application for signing and uploading digital agreements.

## Features
- Sign a document on a canvas.
- Generate a signed PDF with name, signature, and date.
- Upload the signed PDF to a server.
- Log the user's name and IP address.

## Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/ErmalHamzaj/signature.git


## 1. Overview
This project allows users to:

Sign a digital agreement form on a canvas.
Generate a signed PDF with their name, signature, and date.
Upload the signed PDF to a server.
Log the user's IP address and name for tracking purposes.
The solution consists of two main components:

Frontend (HTML + JavaScript):
Handles user interactions (e.g., signing the document, entering their name).
Generates the signed PDF using the pdf-lib library.
Sends the signed PDF to the server via a fetch request.
Backend (PHP):
Receives the uploaded file and processes it.
Saves the signed PDF in a designated directory (uploads).
Logs the user's name and IP address in a separate directory (logs).


## 2. Frontend Code
HTML Structure
The HTML file contains:

A terms and conditions section.
Input fields for the user's name and surname.
A canvas for the user to sign.
Buttons for downloading, sending, and clearing the signature.


## 3. Backend Code
PHP Script (upload.php)
This script handles the file upload and logs the user's name and IP address.
