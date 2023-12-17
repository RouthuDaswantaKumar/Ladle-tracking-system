import cv2
from ultralytics import YOLO
import pytesseract
from pytesseract import Output
import os
import mysql.connector
import datetime

# Set the PyTesseract OCR engine path
pytesseract.tesseract_cmd = "C:\\Program Files\\Tesseract-OCR\\tesseract.exe"

# Set the TESSDATA_PREFIX environment variable
os.environ['TESSDATA_PREFIX'] = "C:\\Program Files\\Tesseract-OCR\\tessdata"

# Load the YOLOv8 model
model = YOLO(r"E:\5th sem project-20231216T085846Z-001\5th sem project\runs\detect\train4\weights\best.pt")

# Initialize video capture from webcam (0 corresponds to the default webcam)
cap = cv2.VideoCapture(0)

# Set up the database connection
db_config = {
    'host': 'sql12.freesqldatabase.com',  # Host of your online MySQL database
    'user': 'sql12671014',  # Your MySQL username
    'password': '24ANc8Juem',  # Your MySQL password
    'database': 'sql12671014'  # The name of your database
}
# Initialize the database connection
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

# Variable to track if the object was detected previously
object_detected = False

# Variable to store the class name of the detected object
detected_class = None

while True:
    # Read a frame from the webcam
    ret, frame = cap.read()

    # Run YOLOv8 tracking on the frame
    results = model.track(frame, persist=True, verbose=False)  # Suppress performance metrics

    # Initialize an empty list to store the text extracted from the detected objects
    extracted_text = None

    # Flag to check if the object is detected in the current frame
    object_in_frame = False

    # Iterate over the detected objects
    for result in results:
        boxes = result.boxes

        for box in boxes:
            # Get the bounding box coordinates of the detected object
            bbox = box.xyxy[0].int().tolist()  # Convert tensor values to integers

            # Crop the object from the frame
            object_image = frame[bbox[1]:bbox[3], bbox[0]:bbox[2]]

            try:
                # Perform text recognition on the object image
                object_text = pytesseract.image_to_string(object_image, output_type=Output.STRING)

                # Get the class name of the detected object
                detected_class = result.names[int(box.cls)]

                # Check if the object is detected for the first time
                if not object_detected:
                    # Ensure the extracted text is a combination of 8 alphabets and numbers
                    object_text = ''.join(c for c in object_text if c.isalnum())
                    if len(object_text) == 8:
                        print("Object Detected! Extracted Text:", object_text)
                        print("Detected Class:", detected_class)
                        extracted_text = object_text
                        object_detected = True

                    # Set the flag to indicate that the object is in the frame
                    object_in_frame = True
            except pytesseract.TesseractError as e:
                print(f"TesseractError: {e}")

    # If the object is not in the frame, reset the object_detected flag
    if not object_in_frame:
        object_detected = False

    # Send the extracted text and detected class to the database
    if extracted_text and detected_class:
        ladle_position = 'Furnace1'
        now = datetime.datetime.now()

        # Define the SQL query
        sql = "INSERT INTO data (LadleArriveTime, LadleNumber, LadlePosition, LadleType) VALUES (%s, %s, %s, %s)"

        # Define the values to be inserted
        values = (now.strftime("%Y-%m-%d %H:%M:%S"), extracted_text, ladle_position, detected_class)

        cursor.execute(sql, values)
        conn.commit()

        # Wait until the object is not detected again
        while True:
            ret, frame = cap.read()
            results = model.track(frame, persist=True, verbose=False)
            if not any(results):
                break

    # Display the frame
    cv2.imshow("Webcam", frame)

    # If the 'q' key is pressed, break the loop
    if cv2.waitKey(1) & 0xFF == ord("q"):
        break

# Release the webcam and close the display window
cap.release()
cv2.destroyAllWindows()

# Close the cursor and the database connection
cursor.close()
conn.close()