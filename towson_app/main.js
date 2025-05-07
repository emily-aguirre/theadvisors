const API_KEY = "AIzaSyA2h-HyHs2y6YwWrqrD5qo-0Ee4m7zAUOE";
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;
import { GoogleGenerativeAI } from "@google/generative-ai";
const towsonCSInfo = `

Towson University – B.S. in Computer Science

Tracks:
- Software Engineering
- Cybersecurity (NSA/DHS certified)
- General

Languages taught: Java, Python, C/C++, JavaScript (varies by course)

Support:
- Academic advising each semester
- Contact: csadvising@towson.edu

Graduate programs: M.S. in Computer Science and Applied IT

Resources:
- Labs, tutoring, ACM chapter, career services

Internships:
- Not required but strongly supported
- Employers include Northrop Grumman, Lockheed Martin, T. Rowe Price, government agencies

AI & Data Science: Electives available in ML, NLP, and data mining

Contact:
- Website: https://www.towson.edu/fcsm/departments/computerinfosci/
- Email: compsci@towson.edu
- Phone: 410-704-3101
- Location: 7800 York Rd, Room 330

Example tone: “Thank you for your interest in Towson CS. Please reach out if you need more details.”

`;
console.log("Initializing GoogleGenerativeAI...");

let genAI;
let model;

try {
    genAI = new GoogleGenerativeAI(API_KEY);
    model = genAI.getGenerativeModel({
        model: "gemini-2.0-flash",
        systemInstruction: towsonCSInfo,
    });
    console.log("Gemini model initialized successfully.");
} catch (initError) {
    console.error("Failed to initialize Gemini model:", initError);
}

let messages = {
    history: [],
};

async function sendMessage() {
    const userInput = document.querySelector(".chat-window input");
    const userMessage = userInput.value.trim();
    
    console.log("User message:", userMessage);

    if (!userMessage.length) return;

    try {
        // Clear input
        userInput.value = "";

        // Show user message
        document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
            <div class="user">
                <p>${userMessage}</p>
            </div>
        `);

        // Show loader
        document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
            <div class="loader"></div>
        `);

        // Start new chat instance
        console.log("Starting new chat session with current history...");
        const chat = model.startChat(messages);

        console.log("Sending message to Gemini...");
        const result = await chat.sendMessageStream(userMessage);
        console.log("Result object received:", result);

        // Append model response container
        document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
            <div class="model">
                <p></p>
            </div>
        `);

        let modelMessages = '';
        for await (const chunk of result.stream) {
            const chunkText = chunk.text();
            console.log("Stream chunk:", chunkText);

            const modelElems = document.querySelectorAll(".chat-window .chat div.model");
            if (modelElems.length === 0) {
                console.error("No .model elements found. Skipping text append.");
                continue;
            }

            const modelPara = modelElems[modelElems.length - 1].querySelector("p");
            modelPara.insertAdjacentHTML("beforeend", chunkText);
        }

        // Get the final response content
        const allModelDivs = document.querySelectorAll(".chat-window .chat div.model");
        const latestResponse = allModelDivs[allModelDivs.length - 1].querySelector("p").innerHTML;

        // Update message history
        messages.history.push({
            role: "user",
            parts: [{ text: userMessage }],
        });

        messages.history.push({
            role: "model",
            parts: [{ text: latestResponse }],
        });

        console.log("Updated message history:", messages.history);

    } catch (error) {
        console.error("Error during message send:", error);

        document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
            <div class="error">
                <p>The message could not be sent. Please try again.</p>
                <p>Error: ${error.message}</p>
            </div>
        `);
    } finally {
        const loader = document.querySelector(".chat-window .chat .loader");
        if (loader) loader.remove();
    }
}

document.querySelector(".chat-window .input-area button")
    .addEventListener("click", () => {
        console.log("Send button clicked.");
        sendMessage();
    });

document.querySelector(".chat-button")
    .addEventListener("click", () => {
        document.querySelector("body").classList.add("chat-open");
        console.log("Chat window opened.");
    });

document.querySelector(".chat-window button.close")
    .addEventListener("click", () => {
        document.querySelector("body").classList.remove("chat-open");
        console.log("Chat window closed.");
    });
