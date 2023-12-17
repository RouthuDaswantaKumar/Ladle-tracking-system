# Running the Ladel tracking System

This system utilizes YOLOv8 for object detection, Tesseract OCR for text extraction, and MySQL for data storage.

## Setup Instructions:

1. **Download the Dataset:**
   - Clone or download the dataset from [Kaggle](#insert-link).

2. **Upload to Kaggle:**
   - Upload the dataset to Kaggle.

3. **Run the Code:**
   - Open the provided Python script (`your_script.py`) in Kaggle Notebooks.

4. **Install Dependencies:**
   - Make sure to install the required dependencies by running the following cells:
     ```python
     !pip install opencv-python
     !pip install pytesseract
     !pip install mysql-connector-python
     ```

5. **Run the Script:**
   - Execute the script to start the object detection and OCR system.
   - Adjust any parameters or configurations if needed.

6. **View Output:**
   - The script will display the webcam feed with object detection and extracted text.
   - Press 'q' to exit the application.

7. **Check the Database:**
   - View the MySQL database to verify the stored data.

8. **Note:**
   - Ensure that the YOLOv8 weights (`best.pt`), Tesseract OCR engine, and MySQL Connector files are correctly placed in the `/input` directory.

