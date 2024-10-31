self.onmessage = function(e) {
    const { csrf, book_id, page } = e.data;

    fetch(`/pdf/image?id=${book_id}&page=${page}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }
        return response.json(); // Parse JSON response
    })
    .then(data => {
        if (data.image) {
            // Convert Base64 string to a Blob
            const blob = base64ToBlob(data.image);
            self.postMessage({ status: 'success', blob, page });
        } else {
            throw new Error('No image data received');
        }
    })
    .catch(error => {
        self.postMessage({ status: 'error', error: error.message });
    });
};

function base64ToBlob(base64, mimeType = 'image/jpeg') {
    // Decode the base64 string into binary data
    const byteCharacters = atob(base64);
    const byteNumbers = new Array(byteCharacters.length);
    
    for (let i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i] = byteCharacters.charCodeAt(i);
    }

    // Convert binary data into a Uint8Array, then create a Blob
    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], { type: mimeType });
}
