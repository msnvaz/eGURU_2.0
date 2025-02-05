document.addEventListener("DOMContentLoaded", () => {
    fetchUploadedFiles();
});

function fetchUploadedFiles() {
    fetch('fetch_files.php')
        .then(response => response.json())
        .then(data => {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            data.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.classList.add('file-item');
                fileItem.innerHTML = `<a href="${file.file_path}" download>${file.name}</a> - ${file.visibility}`;
                fileList.appendChild(fileItem);
            });
        });
}
