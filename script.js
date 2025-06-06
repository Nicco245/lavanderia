document.addEventListener("DOMContentLoaded", function() {
    const bubbleContainer = document.createElement("div");
    bubbleContainer.style.position = "fixed";
    bubbleContainer.style.bottom = "0";
    bubbleContainer.style.left = "0";
    bubbleContainer.style.width = "100%";
    bubbleContainer.style.height = "100%";
    bubbleContainer.style.overflow = "hidden";
    bubbleContainer.style.pointerEvents = "none";
    document.body.appendChild(bubbleContainer);

    function createBubble() {
        const bubble = document.createElement("div");
        bubble.classList.add("bubble");
        bubble.style.width = Math.random() * 30 + 10 + "px";
        bubble.style.height = bubble.style.width;
        bubble.style.position = "absolute";
        bubble.style.bottom = "-20px";
        bubble.style.left = Math.random() * 100 + "%";
        bubble.style.backgroundColor = "rgba(255, 255, 255, 0.7)";
        bubble.style.borderRadius = "50%";
        bubble.style.opacity = "0";
        bubble.style.animation = `bubbles ${Math.random() * 5 + 5}s linear infinite`;
        
        bubbleContainer.appendChild(bubble);

        setTimeout(() => {
            bubble.remove();
        }, 10000);
    }

    setInterval(createBubble, 500);
});

function conferma(){
    return confirm("Vuoi eliminare l'indumento?")
}