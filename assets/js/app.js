document.getElementById("urlForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const result = document.getElementById("result");
  result.textContent = "Shortening...";

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
    result.innerHTML = `<a href="${data.short_url}" target="_blank">${data.short_url}</a>`;
  }
});
