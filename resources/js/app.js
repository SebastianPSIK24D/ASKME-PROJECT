import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.shareQuestion = function(url, title) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Lihat pertanyaan ini di Forum ASKME:',
            url: url,
        })
        .catch((error) => console.log('Error sharing', error));
    } else {
        navigator.clipboard.writeText(url).then(function() {
            alert('Link pertanyaan disalin ke clipboard!');
        }, function(err) {
            alert('Gagal menyalin link.');
        });
    }
};
window.previewImage = function() {
    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');

    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.classList.add('hidden');
    }
};

window.confirmDelete = function(event) {
    event.preventDefault();
    const form = event.target;
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#0fff33ff',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

window.previewAnswerImage = function() {
    const input = document.getElementById('answer-image');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('answer-image-preview');
    const fileNameDisplay = document.getElementById('file-name-display');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            fileNameDisplay.textContent = file.name;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        previewImage.src = '';
        previewContainer.classList.add('hidden');
    }
};
window.toggleLike = async function(questionId) {
    try {
        const response = await fetch(`/questions/${questionId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (data.status === 'success') {
            const icon = document.getElementById(`icon-like-${questionId}`);
            const text = document.getElementById(`text-like-${questionId}`);
            const badge = document.getElementById(`badge-like-${questionId}`);
            if (data.liked) {

                text.innerText = 'Disukai';
                text.classList.remove('text-gray-600', 'dark:text-gray-400');
                text.classList.add('text-green-600', 'dark:text-green-500');

                icon.classList.remove('text-gray-400', 'dark:text-gray-500');
                icon.classList.add('text-green-600', 'dark:text-green-500');

                badge.classList.remove('bg-gray-200', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-400');
                badge.classList.add('bg-green-500', 'text-white');

            } else {
                text.innerText = 'Suka';
                text.classList.add('text-gray-600', 'dark:text-gray-400');

                text.classList.remove('text-green-600', 'dark:text-green-500');
                icon.classList.add('text-gray-400', 'dark:text-gray-500');

                icon.classList.remove('text-green-600', 'dark:text-green-500');
                badge.classList.add('bg-gray-200', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-400');
                badge.classList.remove('bg-green-500', 'text-white');
            }
            badge.innerText = data.count;
        }
    } catch (error) {
        console.error('Error:', error);
    }
};
document.addEventListener('DOMContentLoaded', () => {
    const mainContent = document.getElementById('main-content');
    if (!mainContent) return;
    setTimeout(() => {
        mainContent.classList.remove('opacity-0');
    }, 50);
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.target === '_blank' ||
                this.href.includes('#') ||
                this.href === '' ||
                this.closest('form') ||
                this.href.includes('logout')
            ) {
                return;
            }
            const targetUrl = new URL(this.href);
            if (targetUrl.origin === window.location.origin) {
                e.preventDefault();
                mainContent.classList.add('opacity-0');
                setTimeout(() => {
                    window.location.href = this.href;
                }, 150);
            }
        });
    });
});
window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        const mainContent = document.getElementById('main-content');
        if (mainContent) mainContent.classList.remove('opacity-0');
    }
});
