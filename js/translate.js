  // marathi-transliteration.js

document.addEventListener("DOMContentLoaded", () => {
  const fields = document.querySelectorAll("input, textarea");

  fields.forEach((field) => {
    field.addEventListener("keydown", async (e) => {
      if (e.key === " ") {
        let words = field.value.trim().split(" ");
        let lastWord = words[words.length - 1];

        if (!lastWord || lastWord.length < 2) return;

        const isMarathi = /[\u0900-\u097F]/.test(lastWord);
        if (isMarathi) return;

        const res = await fetch("https://inputtools.google.com/request?itc=mr-t-i0-und&num=1", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "text=" + encodeURIComponent(lastWord)
        });

        const data = await res.json();

        if (data[0] === "SUCCESS" && data[1][0][1].length > 0) {
          const suggestion = data[1][0][1][0];
          words[words.length - 1] = suggestion;
          field.value = words.join(" ") + " ";
        }

        e.preventDefault();
      }
    });
  });
});
