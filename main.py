import cv2
import json
import time
import imutils
import threading

# Camera sources
cameras = [0, 1]  # Adjust camera indices accordingly
zone_counts = {'zone1': 0, 'zone2': 0}
lock = threading.Lock()

# Initialize background subtractors
bg_subtractors = [cv2.createBackgroundSubtractorMOG2() for _ in cameras]

def process_camera(camera_index, zone_id):
    global zone_counts
    video = cv2.VideoCapture(camera_index)

    if not video.isOpened():
        print(f"Error: Could not open camera {camera_index}.")
        return

    while True:
        ret, frame = video.read()
        if not ret:
            print(f"Error: Could not read frame from camera {camera_index}.")
            break

        frame = imutils.resize(frame, width=min(800, frame.shape[1]))
        fg_mask = bg_subtractors[camera_index].apply(frame)
        _, thresh = cv2.threshold(fg_mask, 127, 255, cv2.THRESH_BINARY)
        contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        current_count = sum(1 for contour in contours if cv2.contourArea(contour) >= 1000)
        
        # Draw bounding boxes around detected people
        for contour in contours:
            if cv2.contourArea(contour) < 1000:
                continue
            x, y, w, h = cv2.boundingRect(contour)
            cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)

        with lock:
            zone_counts[zone_id] = current_count

        # Display the video feed with bounding boxes
        cv2.putText(frame, f"Count: {current_count}", (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0, 0, 255), 2)
        cv2.imshow(f"Camera {camera_index} - {zone_id}", frame)

        if cv2.waitKey(1) == ord("q"):
            break

    video.release()
    cv2.destroyAllWindows()

def write_count_to_json():
    global zone_counts
    while True:
        time.sleep(30)
        with lock:
            data = {"timestamp": time.time(), "zone1": zone_counts['zone1'], "zone2": zone_counts['zone2']}
            with open("people_count.json", "w") as f:
                json.dump(data, f)

threads = []
for i, zone in enumerate(zone_counts.keys()):
    t = threading.Thread(target=process_camera, args=(i, zone))
    t.start()
    threads.append(t)

json_writer_thread = threading.Thread(target=write_count_to_json)
json_writer_thread.start()

for t in threads:
    t.join()
json_writer_thread.join()
