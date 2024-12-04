// admin.js
function showSection(section) {
    let contentDiv = document.getElementById('content');
    contentDiv.innerHTML = 'Loading...'; // Show loading text while fetching content
    
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `${section}.php`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            contentDiv.innerHTML = xhr.responseText;
        } else {
            contentDiv.innerHTML = 'Error loading content';
        }
    };
    xhr.send();
}
