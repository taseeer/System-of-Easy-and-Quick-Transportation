document.addEventListener("DOMContentLoaded", function () {
    fetch("php/get_cities.php")
        .then(response => response.json())
        .then(data => {
            let pickingSelect = document.getElementById("picking-point");
            let droppingSelect = document.getElementById("dropping-point");

            // Store city names in lowercase for better recognition
            window.cityList = data.map(city => ({
                id: city.id,
                name: city.name.toLowerCase()
            }));

            // Add cities dynamically to dropdowns
            data.forEach(city => {
                pickingSelect.add(new Option(city.name, city.id));
                droppingSelect.add(new Option(city.name, city.id));
            });

            console.log("✅ City list loaded:", window.cityList);
        })
        .catch(error => console.error("❌ Error fetching cities:", error));
});

// ✅ Speech Recognition Setup
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

if (SpeechRecognition) {
    const recognition = new SpeechRecognition();
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = "en-US"; // Change to "ur-PK" if Urdu is needed

    const micBtn = document.getElementById('micBtn');
    const listeningWaves = document.getElementById('listening');

    micBtn.addEventListener("click", function () {
        console.log("🎤 Microphone activated...");
        recognition.start();
        listeningWaves.style.display = 'flex';
    });

    recognition.onresult = (event) => {
        const spokenText = event.results[0][0].transcript.toLowerCase();
        console.log("🔊 Recognized Speech:", spokenText);

        if (!window.cityList || window.cityList.length === 0) {
            console.warn("⚠️ City list is not loaded yet.");
            return;
        }

        const { fromCity, toCity } = extractCities(spokenText);

        if (fromCity) {
            let matchedCity = findOption(fromCity, "picking-point");
            if (matchedCity) {
                document.getElementById("picking-point").value = matchedCity;
                console.log("✅ From City Detected:", fromCity);
            } else {
                console.warn("⚠️ No match found for From City:", fromCity);
            }
        }

        if (toCity) {
            let matchedCity = findOption(toCity, "dropping-point");
            if (matchedCity) {
                document.getElementById("dropping-point").value = matchedCity;
                console.log("✅ To City Detected:", toCity);
            } else {
                console.warn("⚠️ No match found for To City:", toCity);
            }
        }

        listeningWaves.style.display = 'none';
    };

    recognition.onerror = (event) => {
        console.error("❌ Speech recognition error:", event.error);
        listeningWaves.style.display = 'none';
    };

    recognition.onend = () => {
        console.log("🎤 Microphone stopped listening.");
        listeningWaves.style.display = 'none';
    };
} else {
    console.error("❌ Speech Recognition API is not supported in this browser.");
}

// ✅ Extract 'From' and 'To' Cities from Speech
function extractCities(sentence) {
    let fromCity = "", toCity = "";

    let fromMatch = sentence.match(/from\s+([\w\s]+)/i);
    let toMatch = sentence.match(/to\s+([\w\s]+)/i);

    if (fromMatch) fromCity = bestMatchCity(fromMatch[1].trim());
    if (toMatch) toCity = bestMatchCity(toMatch[1].trim());

    return { fromCity, toCity };
}

// ✅ Improved City Matching Function
function bestMatchCity(spokenCity) {
    let spokenCityLower = spokenCity.toLowerCase();

    // Try exact match first
    let exactMatch = window.cityList.find(city => city.name === spokenCityLower);
    if (exactMatch) return exactMatch.name;

    // Try partial match both ways
    let bestMatch = window.cityList.find(city => city.name.includes(spokenCityLower) || spokenCityLower.includes(city.name));
    if (bestMatch) return bestMatch.name;

    return ""; // If no match is found, return empty string
}

// ✅ Find City ID in Dropdown
function findOption(cityName, selectId) {
    let selectElement = document.getElementById(selectId);
    for (let option of selectElement.options) {
        if (option.text.toLowerCase() === cityName.toLowerCase()) {
            return option.value;
        }
    }
    return null;
}
