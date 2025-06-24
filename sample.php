<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Marathi Transliteration</title>
  <script src="https://unpkg.com/indic-transliteration"></script>
</head>
<body>

  <h3>Type in English and convert to Marathi:</h3>
  <input type="text" id="englishInput" placeholder="Type here..." style="width: 300px;" />
  <button onclick="transliterate()">Transliterate</button>
  <p>Marathi Output: <span id="outputText"></span></p>

  <script>
    function transliterate() {
      const inputText = document.getElementById('englishInput').value;

      // From ITRANS to Devanagari (used for Marathi)
      const output = Sanscript.t(inputText, 'itrans', 'devanagari');

      document.getElementById('outputText').innerText = output;
    }
  </script>

</body>
</html>
