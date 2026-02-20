document.getElementById("urlForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const result = document.getElementById("result");
  const btn = e.target.querySelector(".shorten-btn");
  const btnText = btn.querySelector(".btn-text");
  const input = e.target.querySelector(".url-input");

  // Auto-prepend https:// if the user typed a bare domain like "google.com"
  if (input.value && !/^https?:\/\//i.test(input.value)) {
    input.value = "https://" + input.value;
  }

  // Loading state
  btnText.textContent = "Shortening";
  btn.disabled = true;
  result.className = "";
  result.textContent = "";

  try {
    const res = await fetch("shorten.php", {
      method: "POST",
      body: new FormData(e.target),
    });

    const data = await res.json();

    if (data.error) {
      result.className = "error";
      result.textContent = data.error;
    } else {
      result.className = "success";
      result.innerHTML = `
        <a href="${data.short_url}" target="_blank" rel="noopener">${data.short_url}</a>
        <button class="copy-btn" data-url="${data.short_url}">Copy</button>
      `;

      // Copy to clipboard
      result
        .querySelector(".copy-btn")
        .addEventListener("click", async function () {
          try {
            await navigator.clipboard.writeText(this.dataset.url);
            this.textContent = "Copied!";
            this.classList.add("copied");
            setTimeout(() => {
              this.textContent = "Copy";
              this.classList.remove("copied");
            }, 2000);
          } catch {
            this.textContent = "Error";
          }
        });
    }
  } catch {
    result.className = "error";
    result.textContent = "Something went wrong. Please try again.";
  } finally {
    btnText.textContent = "Shorten";
    btn.disabled = false;
  }
});
