document.addEventListener('DOMContentLoaded', function() {
    // Handle like button clicks
    document.querySelectorAll('.like-button').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const url = `/posts/${postId}/like`;
            const likeCounter = document.querySelector(`.like-count[data-post-id="${postId}"]`);
            const likeIcon = this.querySelector('i');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update like counter
                    likeCounter.textContent = data.count;

                    // Toggle like button appearance
                    if (data.liked) {
                        likeIcon.classList.remove('far');
                        likeIcon.classList.add('fas');
                        likeIcon.classList.add('text-red-500');
                    } else {
                        likeIcon.classList.remove('fas');
                        likeIcon.classList.remove('text-red-500');
                        likeIcon.classList.add('far');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Handle comment form submissions
    document.querySelectorAll('.comment-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const url = `/posts/${postId}/comments`;
            const commentInput = this.querySelector('textarea[name="content"]');
            const commentsList = document.querySelector(`.comments-list[data-post-id="${postId}"]`);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    content: commentInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new comment to the list
                    commentsList.innerHTML += data.html;

                    // Clear comment input
                    commentInput.value = '';

                    // Update comment counter if exists
                    const commentCounter = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                    if (commentCounter) {
                        commentCounter.textContent = parseInt(commentCounter.textContent) + 1;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
