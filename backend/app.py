from flask import Flask, request, jsonify
from flask_cors import CORS
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, GlobalAveragePooling2D, Dropout
from tensorflow.keras.applications import EfficientNetB2
from tensorflow.keras.applications.efficientnet import preprocess_input
from PIL import Image
import numpy as np
import io

app = Flask(__name__)
CORS(app)

# Bangun ulang arsitektur model (persis seperti waktu training)
base = EfficientNetB2(weights=None, include_top=False, input_shape=(260, 260, 3))
model = Sequential([
    base,
    GlobalAveragePooling2D(),
    Dense(256, activation='relu'),
    Dropout(0.3),
    Dense(6, activation='softmax')
])

# Load weights hasil training
model.load_weights("nail_disease_weights.weights.h5")

class_names = ['Acral_Lentiginous_Melanoma', 'Healthy_Nail', 'Onychogryphosis',
               'blue_finger', 'clubbing', 'pitting']

@app.route("/")
def home():
    return jsonify({"status": "API aktif", "endpoint": "/predict"})

@app.route("/predict", methods=["POST"])
def predict():
    try:
        file = request.files["image"]
        img = Image.open(io.BytesIO(file.read())).convert("RGB").resize((260, 260))
        img_array = np.expand_dims(np.array(img), axis=0)
        img_array = preprocess_input(img_array)
        pred = model.predict(img_array)
        idx = int(np.argmax(pred, axis=1)[0])
        return jsonify({
            "label": class_names[idx],
            "confidence": round(float(pred[0][idx] * 100), 2),
            "all_probs": {class_names[i]: round(float(pred[0][i]*100), 2) for i in range(len(class_names))}
        })
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=7860)
