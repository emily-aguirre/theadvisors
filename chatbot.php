<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Towson University Computer Science Chatbot</title>
  <link rel="stylesheet" href="style.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">

  <section class="chat-window bg-white shadow-lg rounded-lg w-full max-w-xl p-4 relative">
    <button class="close absolute top-3 right-3 text-sm text-red-600 hover:underline">x close</button>

    <div class="chat max-h-[400px] overflow-y-auto space-y-2 mt-4 mb-4">
      <div class="model bot-message message-box">
        <p>Hi, how can I help you?</p>
      </div>
    </div>

    <div class="input-area flex items-center gap-2">
      <input
        type="text"
        placeholder="Ask me anything about Towson University's Computer Science majors or programs"
        class="flex-grow border border-gray-300 rounded px-4 py-2 text-sm"
      />
      <button class="send-button px-4 py-2 rounded bg-black text-white hover:bg-yellow-400 hover:text-black">
        Send
      </button>
    </div>
  </section>

  <div class="chat-button fixed bottom-6 right-6">
    <button class="bg-black text-white px-4 py-2 rounded hover:bg-yellow-400 hover:text-black">Chat</button>
  </div>

  <button onclick="history.back()" class="go-back-button fixed top-6 left-6">← Go Back</button>

  <script type="importmap">
    {
      "imports": {
        "@google/generative-ai": "https://esm.run/@google/generative-ai"
      }
    }
  </script>
  <script type="module" src="main.js"></script>
</body>
</html>


