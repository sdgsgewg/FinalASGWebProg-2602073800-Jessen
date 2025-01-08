// Inisialisasi Pusher dan Laravel Echo
window.Echo = new Echo({
    broadcaster: "pusher",
    key: window.PUSHER_APP_KEY,
    cluster: window.PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: true,
});

const chatId = window.chatId; // Ambil dari atribut blade
const userId = window.userId; // Ambil dari atribut blade

// Real-time listener untuk event MessageSent
window.Echo.private(`chat.${chatId}`).listen("MessageSent", (e) => {
    // Abaikan pesan yang dikirim oleh pengirim sendiri
    if (userId === e.message.sender_id) {
        return;
    }

    const messageDiv = `
            <div class="message received pb-2">
                <div class="message-bubble">
                    <p class="m-0">${e.message.message_text}</p>
                </div>
                <div class="message-info received">
                    <span class="timestamp">
                        ${new Date(e.message.created_at).toLocaleTimeString(
                            "id-ID",
                            {
                                hour: "2-digit",
                                minute: "2-digit",
                            }
                        )}
                    </span>
                </div>
            </div>
        `;

    const chatMessages = document.getElementById("chat-messages");
    chatMessages.insertAdjacentHTML("beforeend", messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll ke bawah otomatis
});

// AJAX form submission
const chatForm = document.getElementById("chat-form");
if (chatForm) {
    chatForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Cegah refresh halaman

        const messageInput = document.querySelector('input[name="message"]');
        const message = messageInput.value;

        fetch(chatForm.action, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                chat: chatId,
                message: message,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Server response was not OK");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    const messageDiv = `
                        <div class="message sent pb-2">
                            <div class="message-bubble">
                                <p class="m-0">${data.message.message_text}</p>
                            </div>
                            <div class="message-info sent">
                                <span class="timestamp">
                                    ${new Date(
                                        data.message.created_at
                                    ).toLocaleTimeString("id-ID", {
                                        hour: "2-digit",
                                        minute: "2-digit",
                                    })}
                                </span>
                            </div>
                        </div>
                    `;
                    const chatMessages =
                        document.getElementById("chat-messages");
                    chatMessages.insertAdjacentHTML("beforeend", messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    messageInput.value = ""; // Kosongkan input
                } else {
                    console.error("Failed to send message");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert(
                    "Terjadi kesalahan saat mengirim pesan. Silakan coba lagi."
                );
            });
    });
}

// Scroll otomatis ke bawah saat halaman dimuat
window.onload = () => {
    const chatMessages = document.getElementById("chat-messages");
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
};
