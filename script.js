
document.addEventListener("DOMContentLoaded", function () {
	const chatInput = document.getElementById("chat-input");
	const chatArea = document.getElementById("chat-area");
	const sendButton = document.getElementById("send-button");

	sendButton.addEventListener("click", function () {
		let messages = [];
		console.log((new URLSearchParams(window.location.search)).get('id'));

		const message = chatInput.value.trim();
		if (message) {
			const newMessage = document.createElement("div");
			newMessage.textContent = `You: ${message} 1`;
			messages.push({"role":"user","content":message})
			chatArea.appendChild(newMessage);
			chatInput.value = "";
			chatArea.scrollTop = chatArea.scrollHeight;

			// Send message to server
			fetch("http://localhost:5000/chat", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},x
				body: JSON.stringify({
					prompt: message,
					course_id: +(new URLSearchParams(
						window.location.search
					).get("id")),
					threshold: 0.4,
					limit: 5,
					messages: messages,
				}),
			})
				.then((response) => response.json())
				.then((data) => {
					const newMessage = document.createElement("div");
					newMessage.textContent = `answer: ${data.message}`;
					chatArea.appendChild(newMessage);
					messages.push({
						role: "assistant",
						content: data.message,
					});
					chatArea.scrollTop = chatArea.scrollHeight;
				})
				.catch((error) => {
					console.error("Error:", error);
				});
		}
	});
});
