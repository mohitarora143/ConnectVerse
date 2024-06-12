function checkFileType(input) {
    var file = input.files[0];
    if (file) {
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var categoryOptions = document.getElementById('categoryOptions');
        var categorySelect = document.getElementById('category');
        var emailInput = document.getElementById('email');
        if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
            categorySelect.innerHTML = '<option value="images">Images</option>';
        } else if (fileExtension === 'mp4' || fileExtension === 'avi' || fileExtension === 'mov' || fileExtension === 'wmv') {
            categorySelect.innerHTML = '<option value="videos">Videos</option>';
        } else {
            categorySelect.innerHTML = `
                <option value="">Select a category</option>
                <option value="images">Images</option>
                <option value="videos">Videos</option>
            `;
        }
        emailInput.readOnly = (fileExtension !== 'jpg' && fileExtension !== 'jpeg' && fileExtension !== 'png' && fileExtension !== 'gif');
    }
}


