self.onmessage = function(e) {
    const { csrf, book_id, page } = e.data;

    fetch(`/pdf/image?id=${book_id}&page=${page}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrf
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }
        return response.blob(); // Convert response to Blob
    })
    .then(blob => {
        self.postMessage({ status: 'success', blob, page }); // Send the Blob back to main thread
    })
    .catch(error => {
        self.postMessage({ status: 'error', error: error.message });
    });
};