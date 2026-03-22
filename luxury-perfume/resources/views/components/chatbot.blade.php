<!-- Chatbot Component -->
<style>
    /* Ensure the chatbot widget stays anchored bottom right */
    #chatbot-widget {
        position: fixed !important;
        bottom: 24px !important;
        right: 24px !important;
        z-index: 99999 !important;
        font-family: 'Inter', sans-serif;
    }
    #chatbot-window {
        position: absolute !important;
        bottom: 80px !important;
        right: 0 !important;
        width: 380px !important;
        display: none;
        background: white;
    }
    #chatbot-messages {
        height: 380px;
    }
    #chatbot-welcome-bubble {
        position: absolute !important;
        bottom: 80px !important;
        right: 0px !important;
        width: 220px !important;
        background: white;
        opacity: 0;
        transform: translateY(10px) scale(0.95);
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-origin: bottom right;
    }
    #chatbot-welcome-bubble.show {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    /* Mobile Responsive Adjustments */
    @media (max-width: 768px) {
        #chatbot-widget {
            bottom: 16px !important;
            right: 16px !important;
        }
        #chatbot-toggle {
            width: 50px !important;
            height: 50px !important;
        }
        #chatbot-window {
            position: fixed !important;
            bottom: 80px !important;
            right: 5vw !important;
            width: 90vw !important;
            max-width: 90vw !important;
        }
        #chatbot-messages {
            height: calc(65vh - 110px) !important;
            max-height: 480px;
            padding: 16px 12px;
        }
        #chatbot-welcome-bubble {
            width: 190px !important;
            bottom: 65px !important;
        }
    }
</style>
<div id="chatbot-widget" class="fixed bottom-6 right-6 z-50">
    <button id="chatbot-toggle" class="bg-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:scale-105 transition border-2 border-[#8C3B44] p-0.5 overflow-hidden">
        <img src="{{ asset('images/haifa_avatar.png') }}" alt="Haifa AI" class="w-full h-full object-cover rounded-full">
    </button>
    
    <!-- Floating Welcome Bubble -->
    <div id="chatbot-welcome-bubble" class="border border-gray-200 rounded-2xl rounded-br-sm shadow-xl p-3 flex space-x-3 items-start cursor-pointer hover:bg-gray-50 transition drop-shadow-lg">
        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0 shadow-inner mt-0.5 border border-gray-200 overflow-hidden p-[1px]">
            <img src="{{ asset('images/haifa_avatar.png') }}" alt="Haifa" class="w-full h-full object-cover rounded-full">
        </div>
        <div class="flex-1 pr-4">
            <h5 class="font-bold text-[#2F2F2F] text-[12px] mb-0.5 font-serif">Haifa</h5>
            <p class="text-gray-600 text-[11px] leading-tight">Hi there! How can I help you with your skin today?</p>
        </div>
        <button id="chatbot-welcome-close" class="absolute top-1 right-2 text-gray-400 hover:text-gray-600 focus:outline-none p-1">
            <i class="fas fa-times text-[10px]"></i>
        </button>
    </div>

    <!-- Chat Window Template (Lazy Loaded) -->
    <template id="chatbot-window-template">
        <!-- Chat Window -->
        <div id="chatbot-window" class="flex-col bg-white border border-gray-200 rounded-lg shadow-2xl overflow-hidden text-sm" style="display: flex;">
            <!-- Header -->
            <div class="bg-[#8C3B44] text-white px-4 py-3 flex justify-between items-center rounded-t-lg shadow-md">
                <div class="flex items-center space-x-3 flex-1">
                    <!-- Avatar -->
                    <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center shadow-inner overflow-hidden border border-[#f2ddd6] p-[1px]">
                        <img src="{{ asset('images/haifa_avatar.png') }}" class="w-full h-full object-cover rounded-full" alt="Haifa" loading="lazy">
                    </div>
                    <!-- Text Container -->
                    <div class="flex flex-col justify-center">
                        <h4 class="font-bold text-[15px] leading-tight font-serif tracking-wide m-0">Haifa</h4>
                        <span class="text-[10px] text-[#f2ddd6] block font-light tracking-widest uppercase mt-0.5">AI Skincare Advisor</span>
                    </div>
                </div>
                <!-- Close Button -->
                <button id="chatbot-close" class="text-white hover:text-gray-200 transition shrink-0 p-1 ml-2 flex items-center justify-center hover:rotate-90 duration-300">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Messages Body -->
            <div id="chatbot-messages" class="p-4 overflow-y-auto bg-[#FDFBF8] flex flex-col space-y-3">
                <!-- Initial Bot Message -->
                <div class="flex flex-col space-y-1">
                    <div class="bg-gray-100 text-[#2F2F2F] p-3 rounded-xl rounded-tl-sm self-start max-w-[85%] text-[13px] shadow-sm leading-relaxed">
                        Hello! I'm <strong>Haifa</strong>, your AI skincare consultant. How can I help you today? Let me know your skin concerns!
                    </div>
                    <!-- Quick Replies -->
                    <div class="flex flex-wrap gap-2 mt-2" id="chatbot-quick-replies">
                        <button class="quick-reply text-[11px] border border-[#8C3B44] text-[#8C3B44] px-3 py-1.5 rounded-full hover:bg-[#8C3B44] hover:text-white transition shadow-sm font-medium" data-concern="acne">Acne</button>
                        <button class="quick-reply text-[11px] border border-[#8C3B44] text-[#8C3B44] px-3 py-1.5 rounded-full hover:bg-[#8C3B44] hover:text-white transition shadow-sm font-medium" data-concern="dark spots">Dark Spots</button>
                        <button class="quick-reply text-[11px] border border-[#8C3B44] text-[#8C3B44] px-3 py-1.5 rounded-full hover:bg-[#8C3B44] hover:text-white transition shadow-sm font-medium" data-concern="dry skin">Dry Skin</button>
                        <button class="quick-reply text-[11px] border border-[#8C3B44] text-[#8C3B44] px-3 py-1.5 rounded-full hover:bg-[#8C3B44] hover:text-white transition shadow-sm font-medium" data-concern="sensitive skin">Sensitive Skin</button>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="border-t border-gray-100 p-3 bg-white flex items-center space-x-2">
                <input type="text" id="chatbot-input" placeholder="Type your skin concern..." class="flex-1 w-full border border-gray-200 rounded-full px-4 py-2 outline-none focus:border-[#8C3B44] focus:ring-1 focus:ring-[#8C3B44] text-[13px] bg-gray-50 transition" autocomplete="off">
                <button id="chatbot-send" class="bg-[#2F2F2F] text-white w-9 h-9 rounded-full flex items-center justify-center font-bold hover:bg-[#8C3B44] transition shadow-md shrink-0">
                    <i class="fas fa-paper-plane text-xs"></i>
                </button>
            </div>
        </div>
    </template>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('chatbot-toggle');
        const widgetContainer = document.getElementById('chatbot-widget');
        const welcomeBubble = document.getElementById('chatbot-welcome-bubble');
        const welcomeCloseBtn = document.getElementById('chatbot-welcome-close');
        
        let chatWindow = null;
        let isInitialized = false;

        // Show welcome bubble after delay
        setTimeout(() => {
            if (!isInitialized && welcomeBubble) {
                welcomeBubble.classList.add('show');
            }
        }, 500);

        // Close welcome bubble
        if (welcomeCloseBtn) {
            welcomeCloseBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // prevent window open
                welcomeBubble.classList.remove('show');
            });
        }
        
        // Initializing the Chatbot on first interaction
        const initializeChatbot = () => {
            if (welcomeBubble) welcomeBubble.classList.remove('show');
            
            if (isInitialized) {
                chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
                return;
            }

            // Lazy Load DOM 
            const template = document.getElementById('chatbot-window-template');
            widgetContainer.appendChild(template.content.cloneNode(true));
            chatWindow = document.getElementById('chatbot-window');
            isInitialized = true;

            // Bind newly injected elements
            const closeBtn = document.getElementById('chatbot-close');
            const messagesContainer = document.getElementById('chatbot-messages');
            const inputField = document.getElementById('chatbot-input');
            const sendBtn = document.getElementById('chatbot-send');
            const quickReplies = document.querySelectorAll('.quick-reply');
            const quickRepliesContainer = document.getElementById('chatbot-quick-replies');

            closeBtn.addEventListener('click', () => {
                chatWindow.style.display = 'none';
            });

            const scrollToBottom = () => {
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 50);
            };

            const addMessage = (text, sender) => {
                const div = document.createElement('div');
                if(sender === 'user') {
                    div.className = 'bg-[#2F2F2F] text-white p-3 rounded-xl rounded-tr-sm self-end max-w-[85%] text-[13px] shadow-sm';
                    div.textContent = text;
                } else {
                    div.className = 'bg-gray-100 text-[#2F2F2F] p-3 rounded-xl rounded-tl-sm self-start max-w-[85%] text-[13px] shadow-sm leading-relaxed';
                    div.innerHTML = text; // Allow HTML for strong tags
                }
                messagesContainer.appendChild(div);
                scrollToBottom();
            };

            const addTypingIndicator = (id) => {
                const div = document.createElement('div');
                div.id = id;
                div.className = 'bg-gray-100 text-[#2F2F2F] p-3 rounded-xl rounded-tl-sm self-start max-w-[85%] text-[12px] text-gray-500 italic shadow-sm flex items-center space-x-1';
                div.innerHTML = `<span>Thinking</span><span class="animate-bounce inline-block">.</span><span class="animate-bounce inline-block" style="animation-delay: 0.1s">.</span><span class="animate-bounce inline-block" style="animation-delay: 0.2s">.</span>`;
                messagesContainer.appendChild(div);
                scrollToBottom();
            };

            const removeTypingIndicator = (id) => {
                const el = document.getElementById(id);
                if(el) el.remove();
            };

            const addProductCard = (product) => {
                const card = document.createElement('div');
                card.className = 'bg-white border border-gray-100 rounded-lg p-2.5 flex space-x-3 w-[260px] self-start items-center shadow shadow-gray-200 mb-2 hover:-translate-y-0.5 transition duration-300';
                
                card.innerHTML = `
                    <a href="${product.product_link}" class="shrink-0 w-16 h-16 rounded overflow-hidden border border-gray-100 bg-[#FDFBF8] block">
                        <img src="${product.image_url}" alt="${product.product_name}" loading="lazy" class="w-full h-full object-cover mix-blend-multiply">
                    </a>
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <a href="${product.product_link}">
                            <h5 class="text-[12px] font-bold text-[#2F2F2F] truncate mb-0.5 hover:text-[#8C3B44] transition">${product.product_name}</h5>
                        </a>
                        <span class="text-[10px] text-[#8C3B44] uppercase tracking-wider font-bold mb-1.5 block">${product.skin_concern}</span>
                        <div class="flex justify-between items-center mt-auto">
                            <span class="text-[13px] font-bold text-[#2F2F2F]">$${parseFloat(product.price).toFixed(2)}</span>
                            <a href="${product.product_link}" class="text-[10px] uppercase font-bold tracking-widest bg-transparent border border-[#2F2F2F] text-[#2F2F2F] px-2 py-1 rounded-sm hover:bg-[#2F2F2F] hover:text-white transition">View</a>
                        </div>
                    </div>
                `;
                messagesContainer.appendChild(card);
                scrollToBottom();
            };

            const sendMessage = async (text) => {
                text = text.trim();
                if(!text) return;

                if(quickRepliesContainer) {
                    quickRepliesContainer.style.display = 'none';
                }

                addMessage(text, 'user');
                inputField.value = '';
                
                const typingId = 'typing-' + Date.now();
                addTypingIndicator(typingId);

                try {
                    const url = '/api/products?concern=' + encodeURIComponent(text);
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: { 'Accept': 'application/json' }
                    });
                    
                    removeTypingIndicator(typingId);
                    const result = await response.json();

                    if(response.ok && result.success && result.data.length > 0) {
                        const products = result.data;
                        let replyText = result.message ? result.message : `I found some excellent products that target <strong>${text}</strong>:`;
                        addMessage(replyText, 'bot');
                        
                        products.forEach(product => {
                            addProductCard(product);
                        });
                    } else {
                        addMessage(result.message || "I'm sorry, I couldn't fully understand your concern. Could you tell me if your issue is acne, dryness, or dark spots?", 'bot');
                    }
                } catch(error) {
                    removeTypingIndicator(typingId);
                    addMessage("I am sorry, I am experiencing server connection issues. Please try again later.", 'bot');
                }
            };

            sendBtn.addEventListener('click', () => {
                sendMessage(inputField.value);
            });

            inputField.addEventListener('keypress', (e) => {
                if(e.key === 'Enter') {
                    sendMessage(inputField.value);
                }
            });

            quickReplies.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const concern = e.target.getAttribute('data-concern');
                    sendMessage(concern);
                });
            });
        };

        // Open chat on bubble or icon click
        if (welcomeBubble) welcomeBubble.addEventListener('click', initializeChatbot);
        toggleBtn.addEventListener('click', initializeChatbot);
    });
</script>
