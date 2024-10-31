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
            self.postMessage({ status: 'success', image: data.image, page });
        } else {
            throw new Error('No image data received');
        }
    })
    .catch(error => {
        self.postMessage({ status: 'error', error: error.message });
    });
};
