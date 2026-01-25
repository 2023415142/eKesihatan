<section>
    <h3>Translate</h3>
    <p>Use Google Translate API to translate English text to Bahasa Melayu or Mandarin.</p>
    <div>
        <textarea id="translate-text" rows="3" placeholder="Enter English text..."></textarea>
    </div>
    <div>
        <label for="translate-target">Target Language</label>
        <select id="translate-target">
            <option value="ms">Bahasa Melayu</option>
            <option value="zh">Mandarin</option>
        </select>
        <button type="button" id="translate-btn">Translate</button>
    </div>
    <div>
        <strong>Translated text:</strong>
        <p id="translate-result"></p>
    </div>
</section>
 
<script>
    document.getElementById('translate-btn').addEventListener('click', async () => {
        const text = document.getElementById('translate-text').value;
        const target = document.getElementById('translate-target').value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
 
        const response = await fetch('{{ route('translate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ text, target }),
        });
 
        if (!response.ok) {
            document.getElementById('translate-result').textContent = 'Translation failed. Please try again.';
            return;
        }
 
        const data = await response.json();
        document.getElementById('translate-result').textContent = data.translated_text || '';
    });
</script>
