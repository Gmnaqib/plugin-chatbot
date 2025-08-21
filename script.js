document.addEventListener("DOMContentLoaded", function () {
	const chatInput = document.getElementById("chatbot-input");
	const chatArea = document.getElementById("chatbot-area");
	const sendButton = document.getElementById("send-button");

	const chatbotImage = document.querySelector('.chatbot-image');
	if (chatbotImage) {
		chatbotImage.style.display = 'block';
	}

	function addMessage(message, isUser = true) {
		// Hide chatbot image if any message is present
		if (chatbotImage && chatArea.children.length === 1) {
			chatbotImage.style.display = 'none';
		}
		const messageDiv = document.createElement("div");
		messageDiv.className = isUser ? "chat-message user-message" : "chat-message bot-message";
		messageDiv.textContent = message;
		chatArea.appendChild(messageDiv);
		chatArea.scrollTop = chatArea.scrollHeight;
	}

	async function sendMessage(message) {
		addMessage(message, true);
		chatInput.value = "";

		try {
			const response = await fetch("https://www.gumilarmn.site/api/chatbot/chat", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"x-api-key": "5680698aa667911182afce7ff2517d9afdd33511059e90f70521f4fa40689bff"
				},
				body: JSON.stringify({ prompt: message }),
			});

			if (!response.ok) {
				throw new Error('Network response was not ok');
			}

			const data = await response.json();
			addMessage(data.data.message, false);
		} catch (error) {
			console.error("Error:", error);
			addMessage("Maaf, terjadi kesalahan saat menghubungi chatbot.", false);
		}
	}

	sendButton.addEventListener("click", function () {
		const message = chatInput.value.trim();
		if (message) {
			sendMessage(message);
		}
	});

	chatInput.addEventListener("keypress", function (e) {
		if (e.key === "Enter") {
			const message = chatInput.value.trim();
			if (message) {
				sendMessage(message);
			}
		}
	});
});