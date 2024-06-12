document.addEventListener('DOMContentLoaded', function() {
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const posts = document.querySelectorAll('.con');
    let currentIndex = 0;

    // Hide previous button initially
    prevButton.style.display = 'none';

    // Show next post when clicking next button
    nextButton.addEventListener('click', function() {
        if (currentIndex < posts.length - 1) {
            posts[currentIndex].style.display = 'none'; // Hide current post
            currentIndex++; // Move to next post
            posts[currentIndex].style.display = 'block'; // Show next post

            // Show/hide previous button based on currentIndex
            if (currentIndex > 0) {
                prevButton.style.display = 'block';
            }
            if (currentIndex === posts.length - 1) {
                nextButton.style.display = 'none';
            }
        }
    });

    // Show previous post when clicking previous button
    prevButton.addEventListener('click', function() {
        if (currentIndex > 0) {
            posts[currentIndex].style.display = 'none'; // Hide current post
            currentIndex--; // Move to previous post
            posts[currentIndex].style.display = 'block'; // Show previous post

            // Show/hide next button based on currentIndex
            if (currentIndex < posts.length - 1) {
                nextButton.style.display = 'block';
            }
            if (currentIndex === 0) {
                prevButton.style.display = 'none';
            }
        }
    });
});
